<?php
session_start();
include "conexao.php"; // Conexão com o banco

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Busca o usuário na tabela pessoas 
    $stmt = $conn->prepare("SELECT * FROM pessoas WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se encontrou alguém com esse usuário
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifica a senha
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['id_pessoa'] = $user['id_pessoa'];
            $_SESSION['tipo'] = $user['tipo'];

            // Mandando cada um pro seu lugar
            switch ($user['tipo']) {
                case 'atleta':
                    header("Location: Atleta/index_Atleta.php");
                    break;
                case 'tecnico':
                    header("Location: Tecnico/index_Tec.php");
                    break;
                case 'master':
                    header("Location: Master/index_Master.php");
                    break;
                default:
                    $erro = "Tipo de usuário inválido.";
            }
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./estilo/estilo.css">
</head>
<body class="index">

    <div class="login">
        <div>
            <h3 class="PG_NOME">Login - Equipe de Atletismo</h3>
        </div>
        <div class="container">
            <form class="login-form" action="" method="POST">
                <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required class="input-field">

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required class="input-field">

                <button class="button_" type="submit">Entrar</button>
            </form>
        </div>
    </div>
    
</body>
</html>