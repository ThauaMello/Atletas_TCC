<?php
$host = "localhost";
$usuario = "root";         // ou seu usuário do banco
$senha = "";               // se tiver senha no XAMPP ou no servidor, coloque aqui
$banco = "atletismo";      // nome do seu banco (no seu caso, manteve "atletismo")

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco: " . $conn->connect_error);
}
?>