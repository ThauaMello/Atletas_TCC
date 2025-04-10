<?php
session_start();
include_once("../conexao.php");

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}

$id_tecnico = $_SESSION['id'] ?? null;
$tipo_treino = $_POST['tipo_treino'] ?? '';
$data_treino = $_POST['data_treino'] ?? '';
$duracao = $_POST['duracao'] ?? '';
$dia_semana = $_POST['dia_semana'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$resultado = $_POST['resultado'] ?? null;
$atletas = $_POST['atleta_id'] ?? [];

if ($id_tecnico && $tipo_treino && $data_treino && $duracao && $descricao && !empty($atletas)) {
    // mandando pra tabela treinos
    $sql = "INSERT INTO treinos (id_tecnico, tipo_treino, dia_semana, data_treino, duracao, descricao, resultado)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $id_tecnico, $tipo_treino, $dia_semana, $data_treino, $duracao, $descricao, $resultado);


    if ($stmt->execute()) {
        $id_treino = $stmt->insert_id;

        // vinculando com os atletas
        foreach ($atletas as $id_atleta) {
            $sql_vinculo = "INSERT INTO treino_atletas (id_treino, id_atleta) VALUES (?, ?)";
            $stmt_vinculo = $conn->prepare($sql_vinculo);
            $stmt_vinculo->bind_param("ii", $id_treino, $id_atleta);
            $stmt_vinculo->execute();
        }

        echo "✅ Treino cadastrado com sucesso com os atletas vinculados! <a href='cadastrar_OP_Tec.php'>Voltar</a>";
    } else {
        echo "❌ Erro ao cadastrar treino: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "⚠️ Preencha todos os campos obrigatórios.";
}

$conn->close();
