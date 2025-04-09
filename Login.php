
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
            <form class="login-form" action="login.php" method="POST">

                <label for="cpf">CPF:</label>
                <input type="email" id="email" name="email" required class="input-field">
                
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required class="input-field">
                
                <button class="button_" type="submit">Entrar</button>
                
            </form>
        </div>
    </div>
    
</body>
</html>