<?php
include 'db_connect.php';

// Verifica se ta td certo

if (empty($_POST['atleta_id']) || !isset($_POST['id_tecnico'], $_POST['tipo_treino'], $_POST['data'], $_POST['duracao'], $_POST['descricao'])) {
    die("Erro: Todos os campos devem ser preenchidos.");
}

// Pegando dados do form
$id_tecnico = $_POST['id_tecnico'];
$tipo_treino = $_POST['tipo_treino']; 
$data_treino = $_POST['data']; 
$duracao = $_POST['duracao'];
$descricao = $_POST['descricao'];
$resultado = !empty($_POST['resultado']) ? $_POST['resultado'] : 'pendente';

// Permitir seleção de varios atletas
$atletas = $_POST['atleta_id']; // Pode ser um array se permitir múltiplos

// Verifica se foi enviado mais de um atleta
if (is_array($atletas)) {
    foreach ($atletas as $id_atleta) {
        $sql = "INSERT INTO treinos (id_atleta, id_tecnico, modalidade, data_treino, duracao, descricao, resultado) 
                VALUES ('$id_atleta', '$id_tecnico', '$tipo_treino', '$data_treino', '$duracao', '$descricao', '$resultado')";

        if (!$conn->query($sql)) {
            echo "Erro ao cadastrar treino para o atleta ID $id_atleta: " . $conn->error . "<br>";
        }
    }
} else {
    // Caso apenas um atleta seja selecionado
    $sql = "INSERT INTO treinos (id_atleta, id_tecnico, modalidade, data_treino, duracao, descricao, resultado) 
            VALUES ('$atletas', '$id_tecnico', '$tipo_treino', '$data_treino', '$duracao', '$descricao', '$resultado')";

    if (!$conn->query($sql)) {
        echo "Erro ao cadastrar treino: " . $conn->error;
    }
}

echo "Treino cadastrado com sucesso!";
header("Location: lista_treinos.php"); // Redireciona para a lista de treinos
$conn->close();
?>