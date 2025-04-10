<?php
include_once("../conexao.php");

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = password_hash($_POST['senha'] ?? '', PASSWORD_DEFAULT);
$cpf = $_POST['cpf'] ?? null;
$tipo = $_POST['tipo'] ?? '';

if ($nome && $email && $senha && $tipo) {
    $sql = "INSERT INTO pessoas (nome, email, senha, tipo, cpf) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $senha, $tipo, $cpf);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso! <a href='usuario.php?tipo=$tipo'>Voltar</a>";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Preencha todos os campos.";
}
$conn->close();
