<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/TCC/estilo/estilo.css">
        <title>Lista de <?php echo isset($_GET['tipo']) ? ucfirst($_GET['tipo']) . 's' : 'Registros'; ?></title>
        
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
            <h2 class="form-title">Lista de <?php echo isset($_GET['tipo']) ? ucfirst($_GET['tipo']) . 's' : 'Registros'; ?></h2>

            <?php

            include __DIR__ . '/../db_connect.php';

            // buscando a tabela propria
            if (isset($_GET['tipo'])) {
                $tipo = $_GET['tipo'];
                $table = ($tipo == 'atleta') ? 'atletas' : 'tecnicos';

                // Consulta ao banco de dados
                $sql = "SELECT * FROM $table";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Exibir dados de cada linha
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='record'>";
                        echo "<button class='toggle-info' onclick='toggleInfo(this)'>▼</button>";
                        echo "<img src='uploads/" . $row['foto'] . "' alt='" . $row['nome'] . "'>";
                        echo "<div class='record-name'>" . $row["nome"] . "</div>";
                        echo "<div class='record-info'>";
                        echo "<p>Idade: " . $row["idade"]. "</p>";
                        echo "<p>Modalidade: " . $row["modalidade"]. "</p>";
                        echo "<a href='editar_Tec.php?id=" . $row['id'] . "&tipo=" . $tipo . "'>Editar</a> | ";
                        echo "<a href='excluir_Tec.php?id=" . $row['id'] . "&tipo=" . $tipo . "'>Excluir</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "Nenhum registro encontrado.";
                }
            } else {
                echo "Tipo não especificado.";
            }

            $conn->close();
            ?>
        </div>
        
    </body>
</html>