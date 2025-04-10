<?php
include_once("../conexao.php");

$id = $_GET['id'] ?? '';

if ($id) {
    $sql = "DELETE FROM pessoas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "✅ Registro excluído com sucesso! <a href='../login.php'>Voltar</a>";
    } else {
        echo "❌ Erro ao excluir: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "⚠️ ID inválido.";
}

$conn->close();
