<?php
include_once("../conexao.php");

$id = $_POST['id'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$nome = $_POST['nome'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$cpf = $_POST['cpf'] ?? null;
$senha = $_POST['senha'] ?? '';

if (!$id || !$nome || !$usuario) {
    echo "⚠️ Dados inválidos.";
    exit;
}

// Se uma nova senha foi informada, atualiza com ela
if (!empty($senha)) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "UPDATE pessoas SET nome = ?, usuario = ?, cpf = ?, senha = ? WHERE id_pessoa = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $nome, $usuario, $cpf, $senha_hash, $id);
} else {
    $sql = "UPDATE pessoas SET nome = ?, usuario = ?, cpf = ? WHERE id_pessoa = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    $stmt->bind_param("sssi", $nome, $usuario, $cpf, $id);
}

if ($stmt->execute()) {
    echo "✅ Dados atualizados com sucesso! <a href='../usuario.php'>Voltar</a>";
} else {
    echo "❌ Erro ao atualizar: " . $stmt->error;
}

$stmt->close();
$conn->close();