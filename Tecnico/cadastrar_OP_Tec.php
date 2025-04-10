<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilo/estilo.css">
    <title>Cadastro de Atletas e Treinos</title>
</head>
<body class="">
    <?php include 'menu_Tec.php'; ?>

    <div class="main-container">
        <h2 class="form-title">Cadastro de Atletas e Treinos</h2>

        <div class="escolha-container">
            <div class="escolha" onclick="window.location.href='../Cadastro/usuario.php?tipo=atleta'">
                <img src="/TCC/img/atleta.png" class="escolha-img" alt="Atleta">
                <div class="escolha-texto">Atleta</div>
            </div>

            <div class="escolha" onclick="window.location.href='cadastrar_Treino_Tec.php'">
                <img src="/TCC/img/treino.png" class="escolha-img" alt="Treino">
                <div class="escolha-texto">Treinos</div>
            </div>
        </div>
    </div>
</body>
</html>