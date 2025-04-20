<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}

include_once("../conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Atletas Cadastrados</title>
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
            <h2 class="form-title">Lista de Atletas</h2>

            <?php
            $sql = "SELECT * FROM pessoas WHERE tipo = 'atleta' ORDER BY nome";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    echo "<div class='record'>";
                    echo "<button class='toggle-info' onclick='toggleInfo(this)'>▼</button>";
                    echo "<img src='../img/avatar_padrao.png' alt='Atleta'>"; // Pode personalizar se usar upload
                    echo "<div class='record-name'>" . htmlspecialchars($row["nome"]) . "</div>";
                    echo "<div class='record-info'>";
                    echo "<p><strong>Usuário:</strong> " . htmlspecialchars($row["usuario"] ?? '-') . "</p>";
                    echo "<p><strong>CPF:</strong> " . htmlspecialchars($row["cpf"] ?? '-') . "</p>";
                    echo "<a href='../Cadastro/editar.php?id=" . $row['id_pessoa'] . "'>Editar</a> | ";
                    echo "<a href='../Cadastro/excluir.php?id=" . $row['id_pessoa'] . "' onclick=\"return confirm('Deseja excluir este atleta?')\">Excluir</a>";
                    echo "</div>";
                    echo "</div>";
                endwhile;
            else:
                echo "<p>Nenhum atleta encontrado.</p>";
            endif;

            $conn->close();
            ?>
        </div>

    </body>
</html>
