<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Treino</title>
    <link rel="stylesheet" href="../estilo/estilo.css">
</head>
<body>
    <?php include 'menu_Tec.php'; ?>

    <div class="main-container">
        <h2 class="form-title">Cadastro de Treino</h2>

        <form class="cadastro-form" action="processar_cadastro_treino.php" method="POST">
            <label for="tipo_treino">Tipo de treino:</label>
            <input type="text" name="tipo_treino" id="tipo_treino" required class="input-field">

            <label for="dia_semana">Dia da Semana:</label>
            <select name="dia_semana" id="dia_semana" class="input-field" required>
                <option value="">Selecione</option>
                <option value="Segunda">Segunda</option>
                <option value="Terça">Terça</option>
                <option value="Quarta">Quarta</option>
                <option value="Quinta">Quinta</option>
                <option value="Sexta">Sexta</option>
                <option value="Sábado">Sábado</option>
                <option value="Domingo">Domingo</option>
            </select>

            <label for="data_treino">Data do treino:</label>
            <input type="date" name="data_treino" id="data_treino" required class="input-field">

            <label for="duracao">Duração (ex: 01:30h):</label>
            <input type="text" name="duracao" id="duracao" required class="input-field">

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" rows="4" required class="input-field"></textarea>

            <label for="resultado">Resultado (opcional):</label>
            <textarea name="resultado" id="resultado" rows="3" class="input-field"></textarea>

            <label for="atleta_id">Selecionar Atletas:</label>
            <select id="atleta_id" name="atleta_id[]" multiple required class="input-field">
                <?php
                include '../conexao.php';
                $sql = "SELECT id, nome FROM pessoas WHERE tipo = 'atleta'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
            </select>

            <button type="submit" class="button">Salvar Treino</button>
        </form>
    </div>
</body>
</html>
