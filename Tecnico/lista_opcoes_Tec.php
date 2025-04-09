<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilo/estilo.css">
    <title>Lista de Atletas e treinos</title>
</head>
<body>

    <?php include 'menu_Tec.php'; ?>

    <div class="main-container">
        <h2 class="form-title">Lista de Atletas e Técnicos</h2>
        <div class="escolha-container">

            <div class="escolha" onclick="window.location.href='lista_Tec.php?tipo=atleta'">
                <img src="/TCC/img/atleta.png" class="escolha-img" alt="Atleta">
                <div class="escolha-texto">Atleta</div>
            </div>

            <div class="escolha" onclick="window.location.href='lista_Treino_Tec.php?tipo=treino'">
                <img src="/TCC/img/treino.png" class="escolha-img" alt="treino">
                <div class="escolha-texto">Treinos</div>
            </div>
            
        </div>
    </div>

</body>
</html>