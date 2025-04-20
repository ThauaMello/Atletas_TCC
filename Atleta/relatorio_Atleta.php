<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'atleta') {
    header("Location: ../login.php");
    exit();
}

include_once("../conexao.php");
$id_atleta = $_SESSION['id_pessoa'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Desempenho</title>
    <link rel="stylesheet" href="../estilo/estilo.css">
</head>
<body>
    <?php include 'menu_Atl.php'; ?>
    <div class="main-container">
        <h2 class="form-title">Relatório de Desempenho</h2>

        <?php
        $sql = "SELECT t.tipo_treino, t.data_treino, ta.avaliacao 
                FROM treinos t 
                JOIN treino_atletas ta ON t.id_treino = ta.id_treino 
                WHERE ta.id_atleta = ? AND ta.avaliacao IS NOT NULL 
                ORDER BY t.data_treino DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_atleta);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                echo "<div class='record'>";
                echo "<div class='record-name'>" . htmlspecialchars($row['tipo_treino']) . " - " . htmlspecialchars($row['data_treino']) . "</div>";
                echo "<div class='record-info' style='display: block'>";
                echo "<p><strong>Avaliação:</strong><br>" . nl2br(htmlspecialchars($row['avaliacao'])) . "</p>";
                echo "</div>";
                echo "</div>";
            endwhile;
        else:
            echo "<p>Nenhuma avaliação registrada ainda.</p>";
        endif;

        $conn->close();
        ?>
    </div>
</body>
</html>
