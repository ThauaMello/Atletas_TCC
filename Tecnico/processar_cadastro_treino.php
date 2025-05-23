<?php
session_start();
include_once("../conexao.php");

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}

// Buscar id_tecnico a partir do id_pessoa da sessão
$id_pessoa = $_SESSION['id'];

$sql = "SELECT id_tecnico FROM tecnico WHERE id_pessoa = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pessoa);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $id_tecnico = $row['id_tecnico'];
    $stmt->close();
} else {
    echo "❌ Técnico não encontrado no banco de dados.";
    exit;
}

// Receber os dados do formulário
$tipo_treino = $_POST['tipo_treino'] ?? '';
$data_treino = $_POST['data_treino'] ?? '';
$duracao = $_POST['duracao'] ?? '';
$dia_semana = $_POST['dia_semana'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$atletas = $_POST['id_atleta'] ?? [];

// Validação
if ($id_tecnico && $tipo_treino && $data_treino && $duracao && $descricao && !empty($atletas)) {
    $sql = "INSERT INTO treinos (id_tecnico, tipo_treino, dia_semana, data_treino, duracao, descricao)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("❌ Erro ao preparar treino: " . $conn->error);
    }
    
    if (!$stmt->bind_param("isssss", $id_tecnico, $tipo_treino, $dia_semana, $data_treino, $duracao, $descricao)) {
        die("❌ Erro no bind_param: " . $stmt->error);
    }
    
    if ($stmt->execute()) {
        $id_treino = $stmt->insert_id;
        $stmt->close();
    

        // Vincular atletas ao treino
        $sql_vinculo = "INSERT INTO treino_atletas (id_treino, id_atleta) VALUES (?, ?)";
        $stmt_vinculo = $conn->prepare($sql_vinculo);

        if (!$stmt_vinculo) {
            echo "❌ Erro ao preparar vínculo com atletas: " . $conn->error;
            $conn->close();
            exit;
        }

        foreach ($atletas as $id_atleta) {
            $stmt_vinculo->bind_param("ii", $id_treino, $id_atleta);
            $stmt_vinculo->execute();
        }

        $stmt_vinculo->close();

        echo "<p style='text-align:center; font-weight:bold; color:green;'>✅ Treino cadastrado com sucesso com os atletas vinculados!</p>";
        echo "<script>setTimeout(function(){ window.location.href = 'cadastrar_OP_Tec.php'; }, 2000);</script>";
    } else {
        echo "❌ Erro ao cadastrar treino: " . $stmt->error;
        $stmt->close();
    }
} else {
    echo "<p style='color:red;'>⚠️ Preencha todos os campos obrigatórios.</p>";
}

$conn->close();
