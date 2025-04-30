<?php
include_once("../conexao.php");

$id = $_GET['id'] ?? '';
$tipo = $_GET['tipo'] ?? ''; // tecnico ou atleta

if ($id) {
    // 💡 Excluir vínculo do banco primeiro, se existir
    if ($tipo === 'tecnico') {
        $conn->query("DELETE FROM tecnico WHERE id_pessoa = $id");
    } elseif ($tipo === 'atleta') {
        $conn->query("DELETE FROM atleta WHERE id_pessoa = $id");
    }

    // Agora sim, deletar da tabela principal
    $sql = "DELETE FROM pessoas WHERE id_pessoa = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Exclusão</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f0f0f0;
                    text-align: center;
                    padding-top: 100px;
                }
                .msg {
                    background-color: #f8d7da;
                    color: #721c24;
                    border: 1px solid #f5c6cb;
                    display: inline-block;
                    padding: 20px;
                    border-radius: 10px;
                    font-size: 18px;
                }
            </style>
            <script>
                setTimeout(function(){
                    window.location.href = 'usuario.php?tipo=$tipo';
                }, 3000); // redireciona após 3 segundos
            </script>
        </head>
        <body>
            <div class='msg'>🗑️ Registro excluído com sucesso!<br>Redirecionando...</div>
        </body>
        </html>
        ";
    } else {
        echo "❌ Erro ao excluir: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "⚠️ ID inválido.";
}

$conn->close();
