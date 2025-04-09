<?php
include 'db_connect.php';

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
$nome = trim($_POST['nome']);
$idade = intval($_POST['idade']);
$modalidade = trim($_POST['modalidade']);
$CPF = isset($_POST['cpf']) ? trim($_POST['cpf']) : null;
$foto = $_FILES['foto'];

// CPF foi preenchido
if (empty($CPF)) {
    die("Erro: CPF não pode ser vazio!");
}

// Verifica se a pasta "uploads" existe e cria se necessário
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Verifica se uma imagem foi enviada sem erro
if ($foto['error'] === UPLOAD_ERR_OK) {
    $target_file = $target_dir . basename($foto["name"]);
    if (!move_uploaded_file($foto["tmp_name"], $target_file)) {
        die("Erro ao mover a foto para a pasta uploads!");
    }
} else {
    die("Erro no upload da imagem!");
}

// Valida se o tipo é válido
if ($tipo !== 'atleta' && $tipo !== 'tecnico') {
    die("Erro: Tipo inválido!");
}

// Prepara a inserção no banco
if ($tipo == 'atleta') {
    $sql = "INSERT INTO atletas (nome, idade, modalidade, foto, cpf) VALUES (?, ?, ?, ?, ?)";
} else {
    $sql = "INSERT INTO tecnicos (nome, idade, modalidade, foto, cpf) VALUES (?, ?, ?, ?, ?)";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("sisss", $nome, $idade, $modalidade, $target_file, $CPF);

if ($stmt->execute()) {
    header("Location: lista_Tec.php?tipo=$tipo");
    exit();
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>