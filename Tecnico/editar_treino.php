<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}

include_once("../conexao.php");

$id_treino = $_GET['id'] ?? null;
if (!$id_treino) {
    echo "Treino não especificado.";
    exit();
}

// Buscar treino
$sql = "SELECT * FROM treinos WHERE id_treino = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_treino);
$stmt->execute();
$result = $stmt->get_result();
$treino = $result->fetch_assoc();

if (!$treino) {
    echo "Treino não encontrado.";
    exit();
}

// Buscar atletas já vinculados
$sql_atletas_vinculados = "SELECT id_atleta FROM treino_atletas WHERE id_treino = ?";
$stmt_vinc = $conn->prepare($sql_atletas_vinculados);
$stmt_vinc->bind_param("i", $id_treino);
$stmt_vinc->execute();
$result_vinc = $stmt_vinc->get_result();

$atletas_vinculados = [];
while ($row = $result_vinc->fetch_assoc()) {
    $atletas_vinculados[] = $row['id_atleta'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Treino</title>
    <link rel="stylesheet" href="../estilo/estilo.css">
</head>
<body>
    <?php include 'menu_Tec.php'; ?>
    <div class="main-container">
        <h2 class="form-title">Editar Treino</h2>

        <form class="cadastro-form" action="salvar_edicao_treino.php" method="POST">
            <input type="hidden" name="id_treino" value="<?= $treino['id_treino'] ?>">

            <label for="tipo_treino">Tipo de treino:</label>
            <input type="text" name="tipo_treino" value="<?= $treino['tipo_treino'] ?>" required class="input-field">

            <label for="dia_semana">Dia da Semana:</label>
            <select name="dia_semana" id="dia_semana" class="input-field" required>
                <?php
                $dias = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
                foreach ($dias as $dia) {
                    $selected = $treino['dia_semana'] === $dia ? 'selected' : '';
                    echo "<option value='$dia' $selected>$dia</option>";
                }
                ?>
            </select>

            <label for="data_treino">Data do treino:</label>
            <input type="date" name="data_treino" value="<?= $treino['data_treino'] ?>" required class="input-field">

            <label for="duracao">Duração:</label>
            <input type="text" name="duracao" value="<?= $treino['duracao'] ?>" required class="input-field">

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" rows="4" required class="input-field"><?= $treino['descricao'] ?></textarea>

            <label for="resultado">Resultado:</label>
            <textarea name="resultado" rows="3" class="input-field"><?= $treino['resultado'] ?></textarea>

            <label for="id_atleta">Selecionar Atletas:</label>
            <select id="id_atleta" name="id_atleta[]" multiple required class="input-field">
                <?php
                $sql = "SELECT id_pessoa, nome FROM pessoas WHERE tipo = 'atleta'";
                $res = $conn->query($sql);
                while ($a = $res->fetch_assoc()) {
                    $selected = in_array($a['id'], $atletas_vinculados) ? 'selected' : '';
                    echo "<option value='{$a['id_pessoa']}' $selected>{$a['nome']}</option>";
                }
                ?>
            </select>

            <button type="submit" class="button">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
