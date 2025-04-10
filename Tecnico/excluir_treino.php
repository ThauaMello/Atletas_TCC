<?php
session_start();
include_once("../conexao.php");

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}

$id_treino = $_GET['id'] ?? null;

if ($id_treino) {
    // Remover vínculos
    $conn->query("DELETE FROM treino_atletas WHERE id_treino = $id_treino");

    // Remover o treino
    $sql = "DELETE FROM treinos WHERE id_treino = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_treino);

    if ($stmt->execute()) {
        echo "✅ Treino excluído com sucesso! <a href='lista_Treino_Tec.php'>Voltar</a>";
    } else {
        echo "❌ Erro ao excluir: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "⚠️ Treino não especificado.";
}

$conn->close();
