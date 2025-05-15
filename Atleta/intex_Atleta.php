



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilo/estilo.css">
    <title>Equipe de Atletismo</title>
</head>
<body class="index">
    
    <div>
        <h3 class="PG_NOME">Seja bem vindo, <?= htmlspecialchars($_SESSION['nome']) ?></h3> <!-- colocar php para pegar nome do atleta -->
    </div>

    <div class="botoes"> 
        <button class="button_" onclick="window.location.href='lista_treinos_Atl.php'">Treinos</button>
        <button class="button_" onclick="window.location.href='relatorio_Atleta.php'">Relatorios</button>
    </div>

</body>
</html>