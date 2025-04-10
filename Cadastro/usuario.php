<?php
include_once("../conexao.php");

$tipo = $_GET['tipo'] ?? '';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de <?= ucfirst($tipo) ?></title>
    <link rel="stylesheet" href="../estilo/estilo.css">
</head>
<body>
    <div class="main-container">
        <h2 class="form-title">Cadastro de <?= ucfirst($tipo) ?></h2>
        <form action="salvar.php" method="POST">
            <input type="hidden" name="tipo" value="<?= $tipo ?>">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="input-field" required>

            <label for="email">Email:</label>
            <input type="email" name="email" class="input-field" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" class="input-field" required>

            <?php if ($tipo == 'atleta' || $tipo == 'tecnico'): ?>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" class="input-field" required>

            <?php endif; ?>

            <button type="submit">Salvar</button>
        </form>
    </div>
</body>
</html>