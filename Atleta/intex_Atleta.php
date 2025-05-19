<?php
    session_start();
    include_once("../conexao.php");

    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'atleta') {
    header("Location: ../login.php");
    exit();}

    $id_pessoa = $_SESSION['id'];
    $sql_atleta = "SELECT id_atleta FROM atleta WHERE id_pessoa = ?";
    $stmt = $conn->prepare($sql_atleta);
    $stmt->bind_param("i", $id_pessoa);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id_atleta = $row['id_atleta'];
    
?>


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