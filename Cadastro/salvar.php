<?php
include_once("../conexao.php");

$nome = $_POST['nome'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$senha = password_hash($_POST['senha'] ?? '', PASSWORD_DEFAULT);
$cpf = $_POST['cpf'] ?? null;
$tipo = $_POST['tipo'] ?? '';

if ($nome && $usuario && $senha && $tipo) {
    $sql = "INSERT INTO pessoas (nome, usuario, senha, tipo, cpf) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro no prepare: " . $conn->error);
    }

    $stmt->bind_param("sssss", $nome, $usuario, $senha, $tipo, $cpf);

    if ($stmt->execute()) {
        echo "
        <html>
            <head>
                <meta charset='UTF-8'>
                <title>Exclusão</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f0f0f0;
                        text-align: center;
                        padding-top: 100px;
                    }
                    .msg {
                        background-color: #d4edda;
                        color: #155724;
                        border: 1px solid #c3e6cb;
                        display: inline-block;
                        padding: 20px;
                        border-radius: 10px;
                        font-size: 18px;
                    }
                </style>
                <script>
                    setTimeout(function(){
                        window.location.href = 'usuario.php?tipo=$tipo';
                    }, 3000); // redireciona após 3 segundos
                </script>
            </head>
            <body>
                <div class='msg'>Cadastro realizado com sucesso!<br>Redirecionando...</div>
            </body>
        </html>
        ";
    } else {
        echo "❌ Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Preencha todos os campos.";
}
$conn->close();