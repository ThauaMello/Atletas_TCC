<?php
$tipo = $_GET['tipo'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Treino</title>
    <link rel="stylesheet" href="../estilo/estilo.css">
</head>
<body>
    <?php include 'menu_Tec.php'; ?>
    <div class="main-container">
        <h2 class="form-title">Cadastro de Treino</h2>

        <form action="processar_cadastro_treino.php" method="POST" class="cadastro-form">
        <input type="hidden" name="id_tecnico" value="<?php echo $_SESSION['id_tecnico']; ?>">  

            <label for="nome">Nome do Treino:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required></textarea>

            <label for="data">Data do Treino:</label>
            <input type="date" id="data" name="data" required>

            <label for="duracao">Duração (minutos):</label>
            <input type="number" id="duracao" name="duracao" min="1" required>

            <label for="tipo_treino">Tipo de Treino:</label>
            <select id="tipo_treino" name="tipo_treino" required>
                <option value="resistencia">Resistência</option>
                <option value="velocidade">Velocidade</option>
                <option value="forca">Força</option>
            </select>

            <label for="atleta_id">Atletas:</label>
            <select id="atleta_id" name="atleta_id[]" multiple required>
                <?php
                include 'db_connect.php';
                $sql = "SELECT id, nome FROM atletas";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
            </select>


            <button type="submit" class="button">Cadastrar</button>
        </form>
    </div>
</body>
</html>