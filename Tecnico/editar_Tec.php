<?php
include 'db_connect.php';

$tipo = $_GET['tipo'];
$id = $_GET['id'];

if ($tipo == 'atleta') {
    $sql = "SELECT * FROM atletas WHERE id=$id";
} else {
    $sql = "SELECT * FROM tecnicos WHERE id=$id";
}

$result = $conn->query($sql);
$data = $result->fetch_assoc();

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilo/estilo.css">
    <title>Editar <?php echo ucfirst($tipo); ?></title>
</head>
<body>
<?php include 'menu_Tec.php'; ?>
    <div class="main-container">
        <h2 class="form-title">Editar <?php echo ucfirst($tipo); ?></h2>

        <form action="processar_editar_Tec.php?tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>" method="POST" class="cadastro-form" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $data['nome']; ?>" required>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" min="0" value="<?php echo $data['idade']; ?>" required>

            <label for="modalidade">Modalidade:</label>
            <input type="text" id="modalidade" name="modalidade" value="<?php echo $data['modalidade']; ?>" required>

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*">

            <button type="submit" class="button">Atualizar</button>
        </form>

    </div>
</body>
</html>

