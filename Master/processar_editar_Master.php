<?php
include 'db_connect.php';

$tipo = $_GET['tipo'];
$id = $_GET['id'];
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$modalidade = $_POST['modalidade'];
$foto = $_FILES['foto'];

// coloquei CPF agora tbm, testar se esta dando certo
$update_query = "UPDATE " . ($tipo == 'atleta' ? 'atletas' : 'tecnicos') . " SET nome='$nome', idade='$idade', modalidade='$modalidade', cpf='$CPF'";

if ($foto['size'] > 0) {
    //  onde as fotos serão salvas
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($foto["name"]);
    move_uploaded_file($foto["tmp_name"], $target_file);
    $update_query .= ", foto='$target_file'";
}

$update_query .= " WHERE id=$id";

if ($conn->query($update_query) === TRUE) {
    header("Location: lista_Master.php?tipo=$tipo&mensagem=sucesso");
} else {
    echo "Erro: " . $update_query . "<br>" . $conn->error;
}

$conn->close();
?>