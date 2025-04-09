<?php
$tipo = $_GET['tipo'];
?>

<!DOCTYPE html>
<html lang="pt-bt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de <?php echo ucfirst($tipo); ?> </title>
        <link rel="stylesheet" href="/TCC/estilo/estilo.css">
    </head>

    <body>
        <?php include 'menu_Master.php'; ?>
        <div class="main-container">
            <h2 class="form-title">Cadastro de <?php echo ucfirst($tipo); ?></h2>

            <form action="processar_cadastro_Master.php?tipo=<?php echo $tipo; ?>" method="POST" class="cadastro-form" enctype="multipart/form-data">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required 
                       maxlength="14" placeholder="123.456.789-10"
                       pattern="\d{3}\.\d{3}\.\d{3}-\d{2}">

                <label for="idade">Idade:</label>
                <input type="number" id="idade" name="idade" min="0" required>

                <label for="modalidade">Modalidade:</label>
                <input type="text" id="modalidade" name="modalidade" required>

                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>

                <button type="submit" class="button">Cadastrar</button>
            </form>
            
    </div>
    </body>

</html>