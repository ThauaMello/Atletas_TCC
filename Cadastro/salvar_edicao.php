<?php
include_once("../conexao.php");

$id = $_POST['id'] ?? '';
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$cpf = $_POST['cpf'] ?? null;
$senha = $_POST['senha'] ?? '';

// Atualiza senha se informada
if (!empty($senha)) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "UPDATE pessoas SET nome=?, email=?, senha=?, cpf=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $email, $senha_hash, $cpf, $id);
} else {
    $sql = "UPDATE pessoas SET nome=?, email=?, cpf=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $email, $cpf, $id);
}

if ($stmt->execute()) {
    echo "✅ Dados atualizados com sucesso! <a href='../login.php'>Voltar</a>";
} else {
    echo "❌ Erro ao atualizar: " . $stmt->error;
}

$stmt->close();
$conn->close();