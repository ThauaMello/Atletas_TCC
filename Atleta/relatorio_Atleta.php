<?php
    session_start();

    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'atleta') {
        header("Location: ../login.php");
        exit();
    }

    include_once("../conexao.php");

    $id_pessoa = $_SESSION['id'];

    // Buscar id_atleta
    $sql_atleta = "SELECT id_atleta FROM atleta WHERE id_pessoa = ?";
    $stmt = $conn->prepare($sql_atleta);
    $stmt->bind_param("i", $id_pessoa);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id_atleta = $row['id_atleta'];
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
                // verificando nome do tecnico
                $sql = "SELECT t.tipo_treino, t.data_treino, a.cansaco, a.dificuldades, a.melhor_marca, a.data_avaliacao,
                            p.nome AS nome_tecnico
                        FROM avaliacoes_treino a
                        JOIN treinos t ON a.id_treino = t.id_treino
                        JOIN tecnico tec ON t.id_tecnico = tec.id_tecnico
                        JOIN pessoas p ON tec.id_pessoa = p.id_pessoa
                        WHERE a.id_atleta = ?
                        ORDER BY a.data_avaliacao DESC";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_atleta);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):

                        $melhor_marca_texto = ($row['melhor_marca'] == 1) ? 'Sim' : 'Não';

                        echo "<div class='record'>";
                        echo "<div class='record-name'>" . htmlspecialchars($row['tipo_treino']) . " - " . htmlspecialchars($row['data_treino']) . "</div>";
                        echo "<div class='record-info' style='display: block'>";
                        echo "<p><strong>Data da Avaliação:</strong> " . htmlspecialchars($row['data_avaliacao']) . "</p>";
                        echo "<p><strong>Cansaço: </strong>" . nl2br(htmlspecialchars($row['cansaco'])) . "</p>";
                        echo "<p><strong>Dificuldades: </strong>" . nl2br(htmlspecialchars($row['dificuldades'])) . "</p>";
                        echo "<p><strong>Melhor Marca: </strong>" . $melhor_marca_texto . "</p>";
                         echo "<p><strong>Técnico Responsável:</strong> " . htmlspecialchars($row['nome_tecnico']) . "</p>";
                        echo "</div></div>";
                    endwhile;
                else:
                    echo "<p>Nenhuma avaliação registrada ainda.</p>";
                endif;

                $conn->close();
            ?>
        </div>
    </body>
</html>
