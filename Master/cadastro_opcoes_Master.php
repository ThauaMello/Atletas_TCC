<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../estilo/estilo.css">
        <title>Cadastro de Atletas e Técnicos</title>
    </head>

    <body>
        <?php include 'menu_Master.php'; ?>
        <div class="main-container">
            <h2 class="form-title">Cadastro de Atletas e Técnicos</h2>
            <div class="escolha-container">
                <div class="escolha" onclick="window.location.href='cadastrar_master.php?tipo=atleta'">
                    <img src="/TCC/img/atleta.png" class="escolha-img" alt="Atleta">
                    <div class="escolha-texto">Atleta</div>
                </div>
                <div class="escolha" onclick="window.location.href='cadastrar_master.php?tipo=tecnico'">
                    <img src="/TCC/img/tecnico.png" class="escolha-img" alt="Técnico">
                    <div class="escolha-texto">Técnico</div>
                </div>
            </div>
        </div>
    </body>

</html>