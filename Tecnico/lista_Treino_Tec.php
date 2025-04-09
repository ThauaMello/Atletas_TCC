<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TCC/estilo/estilo.css">
    <title>Lista de Treinos</title>

    <script>
        function toggleInfo(button) {
            const recordInfo = button.closest('.record').querySelector('.record-info');
            if (recordInfo.style.display === 'none') {
                recordInfo.style.display = 'block';
                button.textContent = '▲';
            } else {
                recordInfo.style.display = 'none';
                button.textContent = '▼';
            }
        }
    </script>
</head>
<body>

<?php include 'menu_Tec.php'; ?>

<div class="main-container">
    <h2 class="form-title">Lista de Treinos</h2>

    <?php
   include __DIR__ . '/../db_connect.php';

    // Consulta à tabela de treinos
    $sql = "SELECT * FROM treinos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='record'>";
            echo "<button class='toggle-info' onclick='toggleInfo(this)'>▼</button>";
            echo "<div class='record-name'>Treino de " . $row["tipo_treino"] . "</div>";
            echo "<div class='record-info'>";
            echo "<p><strong>Data:</strong> " . $row["data"] . "</p>";
            echo "<p><strong>Horário:</strong> " . $row["horario"] . "</p>";
            echo "<p><strong>Duração:</strong> " . $row["duracao"] . "</p>";
            echo "<p><strong>Observações:</strong> " . $row["observacoes"] . "</p>";
            echo "<a href='editar_treino.php?id=" . $row['id'] . "'>Editar</a> | ";
            echo "<a href='excluir_treino.php?id=" . $row['id'] . "'>Excluir</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "Nenhum treino encontrado.";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
