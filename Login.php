<?php
session_start();
include "conexao.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Consulta
    $stmt = $conn->prepare("SELECT * FROM pessoas WHERE usuario = ?");
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            // Sessões padronizadas
            $_SESSION['id'] = $user['id_pessoa']; // ← importante!
            $_SESSION['tipo'] = $user['tipo'];

            // Redirecionamento por tipo
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

    $stmt->close();
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
            <?php if (!empty($erro)): ?>
                <p style="color: red; text-align: center;"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

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
