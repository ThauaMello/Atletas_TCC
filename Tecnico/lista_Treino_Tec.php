<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}

include_once("../conexao.php");

// Buscar id_tecnico baseado no id_pessoa da sessão
$id_pessoa = $_SESSION['id'];

$sql_tecnico = "SELECT id_tecnico FROM tecnico WHERE id_pessoa = ?";
$stmt_tecnico = $conn->prepare($sql_tecnico);
$stmt_tecnico->bind_param("i", $id_pessoa);
$stmt_tecnico->execute();
$result_tecnico = $stmt_tecnico->get_result();

if ($result_tecnico && $row = $result_tecnico->fetch_assoc()) {
    $id_tecnico = $row['id_tecnico'];
} else {
    echo "<p style='color:red;'>❌ Técnico não encontrado no banco.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
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
                while ($treino = $result->fetch_assoc()):
                    $id_treino = $treino['id_treino'];

                    // Buscar atletas vinculados ao treino
                    $sqlAtletas = "SELECT p.nome FROM treino_atletas ta 
                                JOIN pessoas p ON ta.id_atleta = p.id_pessoa 
                                WHERE ta.id_treino = ?";
                    $stmtAtletas = $conn->prepare($sqlAtletas);
                    $stmtAtletas->bind_param("i", $id_treino);
                    $stmtAtletas->execute();
                    $resultAtletas = $stmtAtletas->get_result();

                    $nomes = [];
                    while ($a = $resultAtletas->fetch_assoc()) {
                        $nomes[] = $a['nome'];
                    }
                    $lista_atletas = implode(", ", $nomes);
                    ?>

                    <div class='record'>
                        <button class='toggle-info' onclick='toggleInfo(this)'>▼</button>
                        <div class='record-name'><?= htmlspecialchars($treino["tipo_treino"]) ?></div>
                        <div class='record-info' style="display: none;">
                            <p><strong>Data:</strong> <?= htmlspecialchars($treino["data_treino"]) ?></p>
                            <p><strong>Duração:</strong> <?= htmlspecialchars($treino["duracao"]) ?></p>
                            <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($treino["descricao"])) ?></p>
                            <p><strong>Atletas:</strong> <?= $lista_atletas ?: 'Nenhum atleta vinculado' ?></p>
                            <a href='editar_treino.php?id=<?= $id_treino ?>'>Editar</a> |
                            <a href='excluir_treino.php?id=<?= $id_treino ?>' onclick="return confirm('Deseja excluir este treino?')">Excluir</a>
                        </div>
                    </div>

                <?php endwhile;
            else:
                echo "<p>Nenhum treino encontrado.</p>";
            endif;

            $conn->close();
            ?>
        </div>

    </body>
</html>



