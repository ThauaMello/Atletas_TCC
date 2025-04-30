<?php
    include_once("../conexao.php");

    $id = $_GET['id'] ?? '';

    if (!$id) {
        echo "ID inválido.";
        exit;
    }

    $sql = "SELECT * FROM pessoas WHERE id_pessoa = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

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
        <h2 class="form-title">Editar <?= ucfirst($pessoa['tipo']) ?></h2>

        <form action="salvar_edicao.php" method="POST">
            <input type="hidden" name="id" value="<?= $pessoa['id_pessoa'] ?>">
            <input type="hidden" name="tipo" value="<?= $pessoa['tipo'] ?>">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?= $pessoa['nome'] ?>" class="input-field" required>

            <label for="usuario">Usuário:</label>
            <input type="text" name="usuario" value="<?= $pessoa['usuario'] ?>" class="input-field" required>

            <?php if ($pessoa['tipo'] === 'atleta' || $pessoa['tipo'] === 'tecnico'): ?>
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?= $pessoa['cpf'] ?>" class="input-field" required>
            <?php endif; ?>

            <label for="senha">Nova Senha (opcional):</label>
            <input type="password" name="senha" class="input-field">

            <button type="submit" class="button">Salvar</button>
        </form>
    </div>
</body>
</html>