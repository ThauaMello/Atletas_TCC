<?php
session_start();
include_once("../conexao.php");

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'atleta') {
    header("Location: ../login.php");
    exit();
}
    $id_pessoa = $_SESSION['id'];
    $sql_atleta = "SELECT id_atleta FROM atleta WHERE id_pessoa = ?";
    $stmt = $conn->prepare($sql_atleta);
    $stmt->bind_param("i", $id_pessoa);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id_atleta = $row['id_atleta'];
    
    $id_treino = $_POST['id_treino'] ?? null;
    $avaliacao = trim($_POST['avaliacao'] ?? '');

if ($id_treino && $avaliacao) {
    $sql = "UPDATE treino_atletas SET avaliacao = ? WHERE id_treino = ? AND id_atleta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $avaliacao, $id_treino, $id_atleta);

    if ($stmt->execute()) {
        echo "✅ Avaliação enviada com sucesso! <a href='lista_treinos_Atl.php'>Voltar</a>";
    } else {
        echo "❌ Erro ao salvar avaliação: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "⚠️ Preencha todos os campos.";
}

$conn->close();

