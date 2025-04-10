<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'atleta') {
    header("Location: ../login.php");
    exit();
}

include_once("../conexao.php");
$id_atleta = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Treinos</title>
    <link rel="stylesheet" href="../estilo/estilo.css">
    <script>
        function toggleInfo(button) {
            const recordInfo = button.closest('.record').querySelector('.record-info');
            recordInfo.style.display = recordInfo.style.display === 'none' ? 'block' : 'none';
            button.textContent = button.textContent === '▼' ? '▲' : '▼';
        }
    </script>
</head>
<body>

<?php include 'menu_Atl.php'; ?>

<div class="main-container">
    <h2 class="form-title">Meus Treinos por Dia da Semana</h2>

    <?php
    // Buscar treinos do atleta com dia_semana
    $sql = "SELECT t.* FROM treinos t
            JOIN treino_atletas ta ON t.id_treino = ta.id_treino
            WHERE ta.id_atleta = ?
            ORDER BY FIELD(t.dia_semana, 'Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'), t.data_treino DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_atleta);
    $stmt->execute();
    $result = $stmt->get_result();

    $treinos_por_dia = [];

    while ($treino = $result->fetch_assoc()) {
        $dia = $treino['dia_semana'] ?? 'Sem Dia Definido';
        $treinos_por_dia[$dia][] = $treino;
    }

    if (empty($treinos_por_dia)) {
        echo "<p>Nenhum treino atribuído até o momento.</p>";
    } else {
        foreach ($treinos_por_dia as $dia_semana => $treinos) {
            echo "<h3 style='color:#0077ff; margin-top:20px;'>📅 $dia_semana</h3>";

            foreach ($treinos as $row) {
                echo "<div class='record'>";
                echo "<button class='toggle-info' onclick='toggleInfo(this)'>▼</button>";
                echo "<div class='record-name'>" . htmlspecialchars($row["tipo_treino"]) . "</div>";
                echo "<div class='record-info'>";
                echo "<p><strong>Data:</strong> " . htmlspecialchars($row["data_treino"]) . "</p>";
                echo "<p><strong>Duração:</strong> " . htmlspecialchars($row["duracao"]) . "</p>";
                echo "<p><strong>Descrição:</strong> " . nl2br(htmlspecialchars($row["descricao"])) . "</p>";
                echo "<p><strong>Resultado:</strong> " . nl2br(htmlspecialchars($row["resultado"])) . "</p>";
                echo "</div>";
                echo "</div>";
            }
        }
    }

    $conn->close();
    ?>
</div>

</body>
</html>
