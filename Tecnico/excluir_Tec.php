<?php
include 'db_connect.php';

$tipo = $_GET['tipo'];
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['confirm'] === 'Sim') {
        if ($tipo == 'atleta') {
            $sql = "DELETE FROM atletas WHERE id=$id";
        } else {
            $sql = "DELETE FROM treinos WHERE id=$id";
        }

        if ($conn->query($sql) === TRUE) {
            header("Location: lista_Tec.php?tipo=$tipo");
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    } else {
        header("Location: lista_Tec.php?tipo=$tipo");
    }
    $conn->close();
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilo/estilo.css">
    <title>Confirmação de Exclusão</title>
</head>
<body>
<?php include 'menu_Tec.php'; ?>
    <div class="main-container">
        <h2 class="form-title">Confirmar Exclusão</h2>
        <form method="POST">
            <p>Tem certeza de que deseja excluir este <?php echo $tipo; ?>?</p>
            <button type="submit" name="confirm" value="Sim" class="button">Sim</button>
            <button type="submit" name="confirm" value="Não" class="button">Não</button>
        </form>
    </div>
</body>
</html>