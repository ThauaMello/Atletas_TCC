<?php
session_start();
include_once("../conexao.php");

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}

$id_treino = $_POST['id_treino'] ?? null;
$tipo_treino = $_POST['tipo_treino'] ?? '';
$dia_semana = $_POST['dia_semana'] ?? '';
$data_treino = $_POST['data_treino'] ?? '';
$duracao = $_POST['duracao'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$resultado = $_POST['resultado'] ?? '';
$atletas = $_POST['atleta_id'] ?? [];

if ($id_treino && $tipo_treino && $data_treino && $duracao && $descricao && !empty($atletas)) {
    // Atualizar treino
    $sql = "UPDATE treinos SET tipo_treino=?, dia_semana=?, data_treino=?, duracao=?, descricao=?, resultado=? WHERE id_treino=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $tipo_treino, $dia_semana, $data_treino, $duracao, $descricao, $resultado, $id_treino);
    $stmt->execute();

    // Apagar vínculos antigos
    $conn->query("DELETE FROM treino_atletas WHERE id_treino = $id_treino");

    // Inserir novos vínculos
    foreach ($atletas as $id_atleta) {
        $sql_vinc = "INSERT INTO treino_atletas (id_treino, id_atleta) VALUES (?, ?)";
        $stmt_vinc = $conn->prepare($sql_vinc);
        $stmt_vinc->bind_param("ii", $id_treino, $id_atleta);
        $stmt_vinc->execute();
    }

    echo "✅ Treino atualizado com sucesso! <a href='lista_Treino_Tec.php'>Voltar</a>";
} else {
    echo "⚠️ Preencha todos os campos.";
}

$conn->close();
