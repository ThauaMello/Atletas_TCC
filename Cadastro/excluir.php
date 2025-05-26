<?php
include_once("../conexao.php");

$id = $_GET['id'] ?? '';
$tipo = $_GET['tipo'] ?? ''; // tecnico ou atleta

if ($id) {
    if ($tipo === 'tecnico') {
        // 1. Buscar o id_tecnico correspondente
        $stmt = $conn->prepare("SELECT id_tecnico FROM tecnico WHERE id_pessoa = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tec = $result->fetch_assoc();
        $id_tecnico = $tec['id_tecnico'] ?? null;
        $stmt->close();

        if ($id_tecnico) {
            // 2. Apagar os treinos vinculados a esse técnico (e por consequência, suas ligações em treino_atletas e avaliações)
            $conn->query("DELETE FROM treino_atletas WHERE id_treino IN (SELECT id_treino FROM treinos WHERE id_tecnico = $id_tecnico)");
            $conn->query("DELETE FROM avaliacoes_treino WHERE id_treino IN (SELECT id_treino FROM treinos WHERE id_tecnico = $id_tecnico)");
            $conn->query("DELETE FROM treinos WHERE id_tecnico = $id_tecnico");
        }

        // 3. Apagar o técnico
        $conn->query("DELETE FROM tecnico WHERE id_pessoa = $id");

    } elseif ($tipo === 'atleta') {
        // 1. Buscar o id_atleta correspondente
        $stmt = $conn->prepare("SELECT id_atleta FROM atleta WHERE id_pessoa = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $atl = $result->fetch_assoc();
        $id_atleta = $atl['id_atleta'] ?? null;
        $stmt->close();

        if ($id_atleta) {
            // 2. Apagar vínculos com treinos e avaliações
            $conn->query("DELETE FROM treino_atletas WHERE id_atleta = $id_atleta");
            $conn->query("DELETE FROM avaliacoes_treino WHERE id_atleta = $id_atleta");
        }

        // 3. Apagar o atleta
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
                    background-color: #d4edda;
                    color: #155724;
                    border: 1px solid #c3e6cb;
                    display: inline-block;
                    padding: 20px;
                    border-radius: 10px;
                    font-size: 18px;
                }
            </style>
            <script>
                setTimeout(function(){
                    window.location.href = 'usuario.php?tipo=$tipo';
                }, 3000);
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
