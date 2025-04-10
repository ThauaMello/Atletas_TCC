<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}

include_once("../conexao.php");
$id_tecnico = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treinos Cadastrados</title>
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

<?php include 'menu_Tec.php'; ?>

<div class="main-container">
    <h2 class="form-title">Treinos Cadastrados</h2>

    <?php
    $sql = "SELECT * FROM treinos WHERE id_tecnico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_tecnico);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
            $id_treino = $row['id_treino'];

            // Buscar atletas vinculados a este treino
            $sql_atletas = "SELECT p.nome FROM treino_atletas ta 
                            JOIN pessoas p ON ta.id_atleta = p.id
                            WHERE ta.id_treino = ?";
            $stmt_atletas = $conn->prepare($sql_atletas);
            $stmt_atletas->bind_param("i", $id_treino);
            $stmt_atletas->execute();
            $result_atletas = $stmt_atletas->get_result();

            $nomes_atletas = [];
            while ($a = $result_atletas->fetch_assoc()) {
                $nomes_atletas[] = $a['nome'];
            }
            $lista_atletas = implode(", ", $nomes_atletas);

            echo "<div class='record'>";
            echo "<button class='toggle-info' onclick='toggleInfo(this)'>▼</button>";
            echo "<div class='record-name'>" . htmlspecialchars($row["tipo_treino"]) . "</div>";
            echo "<div class='record-info'>";
            echo "<p><strong>Data:</strong> " . htmlspecialchars($row["data_treino"]) . "</p>";
            echo "<p><strong>Duração:</strong> " . htmlspecialchars($row["duracao"]) . "</p>";
            echo "<p><strong>Descrição:</strong> " . nl2br(htmlspecialchars($row["descricao"])) . "</p>";
            echo "<p><strong>Resultado:</strong> " . nl2br(htmlspecialchars($row["resultado"])) . "</p>";
            echo "<p><strong>Atletas:</strong> " . $lista_atletas . "</p>";
            echo "<a href='editar_treino.php?id=$id_treino'>Editar</a> | ";
            echo "<a href='excluir_treino.php?id=$id_treino' onclick=\"return confirm('Deseja excluir este treino?')\">Excluir</a>";
            echo "</div>";
            echo "</div>";
        endwhile;
    else:
        echo "<p>Nenhum treino encontrado.</p>";
    endif;

    $conn->close();
    ?>
</div>

</body>
</html>

