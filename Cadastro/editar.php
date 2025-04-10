<?php
include_once("../conexao.php");

$id = $_GET['id'] ?? '';
$sql = "SELECT * FROM pessoas WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$pessoa = $result->fetch_assoc();

if (!$pessoa) {
    echo "Pessoa não encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Pessoa</title>
    <link rel="stylesheet" href="../estilo/estilo.css">
</head>
<body>
    <div class="main-container">
        <h2 class="form-title">Editar Pessoa</h2>
        <form action="salvar.php" method="POST">
            <input type="hidden" name="id" value="<?= $pessoa['id'] ?>">
            <input type="hidden" name="tipo" value="<?= $pessoa['tipo'] ?>">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?= $pessoa['nome'] ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= $pessoa['email'] ?>" required>

            <label for="senha">Nova Senha (opcional):</label>
            <input type="password" name="senha">

            <button type="submit">Salvar</button>
        </form>
    </div>
</body>
</html>
