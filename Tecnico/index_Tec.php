<?php
    session_start();
    include_once("../conexao.php");

    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();}

    $id_pessoa = $_SESSION['id'];
    $sql_tecnico = "SELECT id_tecnico FROM tecnico WHERE id_pessoa = ?";
    $stmt = $conn->prepare($sql_tecnico);
    $stmt->bind_param("i", $id_pessoa);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id_tecnico = $row['id_tecnico'];
    
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilo/estilo.css">
    <title>Equipe de Atletismo_Tecnico</title>
</head>
<body class="index">
    
    <div>
        <h3 class="PG_NOME">Equipe de Atletismo</h3>
    </div>
    <div>
        <h3 class="PG_NOME">Bem-vindo, <?= htmlspecialchars($_SESSION['nome']) ?></h3>
    </div>

    <div class="botoes"> 
        <button class="button_" onclick="window.location.href='lista_opcoes_Tec.php'">Lista</button>
        <button class="button_" onclick="window.location.href='cadastrar_OP_Tec.php'">Cadastro</button>
    </div>

</body>
</html>