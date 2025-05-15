<?php
session_start();
include_once("../conexao.php");

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}

$id_treino = $_POST['id_treino'] ?? null;
$tipo_treino = $_POST['tipo_treino'] ?? '';
$dia_semana = $_POST['dia_semana'] ?? '';
$data_treino = $_POST['data_treino'] ?? '';
$duracao = $_POST['duracao'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$atletas = $_POST['id_atleta'] ?? [];

if ($id_treino && $tipo_treino && $data_treino && $duracao && $descricao && !empty($atletas)) {
    
    // Atualizar treino
    $sql = "UPDATE treinos SET tipo_treino=?, dia_semana=?, data_treino=?, duracao=?, descricao=? WHERE id_treino=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("❌ Erro no prepare da edição: " . $conn->error);
    }

    $stmt->bind_param("sssssi", $tipo_treino, $dia_semana, $data_treino, $duracao, $descricao, $id_treino);
    $stmt->execute();
    $stmt->close();

    // Apagar vínculos antigos
    $conn->query("DELETE FROM treino_atletas WHERE id_treino = $id_treino");

    // Inserir novos vínculos
    $sql_vinc = "INSERT INTO treino_atletas (id_treino, id_atleta) VALUES (?, ?)";
    $stmt_vinc = $conn->prepare($sql_vinc);

    if (!$stmt_vinc) {
        die("❌ Erro no prepare do vínculo: " . $conn->error);
    }

    foreach ($atletas as $id_atleta) {
        $stmt_vinc->bind_param("ii", $id_treino, $id_atleta);
        $stmt_vinc->execute();
    }

    $stmt_vinc->close();

    echo "<p style='color: green; font-weight:bold;'>✅ Treino atualizado com sucesso!</p>";
    echo "<script>setTimeout(() => window.location.href='lista_Treino_Tec.php', 2000);</script>";

} else {
    echo "<p style='color: red;'>⚠️ Preencha todos os campos obrigatórios.</p>";
}

$conn->close();
