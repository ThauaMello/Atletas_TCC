<?php
session_start();
include __DIR__ . '/../db_connect.php';

$id_treino = $_POST['id_treino'];
$id_atleta = $_SESSION['id_atleta'];
$cansaco = $_POST['cansaco'];
$dificuldades = $_POST['dificuldades'];
$melhor_marca = isset($_POST['melhor_marca']) ? 1 : 0;

$sql = "INSERT INTO avaliacoes_treino (id_treino, id_atleta, cansaco, dificuldades, melhor_marca)
        VALUES ($id_treino, $id_atleta, $cansaco, '$dificuldades', $melhor_marca)";

if ($conn->query($sql)) {
    header("Location: lista_treinos_Atl.php?msg=avaliacao_sucesso");
} else {
    echo "Erro ao salvar: " . $conn->error;
}
$conn->close();
?>
