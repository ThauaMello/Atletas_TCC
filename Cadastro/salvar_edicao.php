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
        echo "
        <html>
            <head>
                <meta charset='UTF-8'>
                <title>Sucesso</title>
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
                    }, 3000); // 3 segundos
                </script>
            </head>
            <body>
                <div class='msg'>✅ Dados atualizados com sucesso!<br>Você será redirecionado em instantes...</div>
            </body>
        </html>
        ";
    } else {
        echo "❌ Erro ao atualizar: " . $stmt->error;
    }


    $stmt->close();
    $conn->close();