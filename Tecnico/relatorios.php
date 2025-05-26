<?php 
    session_start();

    include_once("../conexao.php");

    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
    }
?>


<!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../estilo/estilo.css">

        <script>
            function toggleInfo(button) {
                const recordInfo = button.closest('.record').querySelector('.record-info');
                recordInfo.style.display = recordInfo.style.display === 'none' ? 'block' : 'none';
                button.textContent = button.textContent === '▼' ? '▲' : '▼';
            }
        </script>
        
        <title>Relatorios treinos</title>
    </head>

    <body>
        <?php include 'menu_Tec.php'; ?>

        <div class="main-container">
            <h2 class="form-title">Relatorio de treinos</h2>

            <?php
                include_once("../conexao.php");

                // Buscar avaliações agrupadas por atleta
                $sql = "SELECT 
                            p.nome AS nome_atleta,
                            t.tipo_treino,
                            t.data_treino,
                            a.cansaco,
                            a.dificuldades,
                            a.melhor_marca,
                            a.data_avaliacao,
                            a.id_atleta,
                            a.id_treino
                        FROM avaliacoes_treino a
                        JOIN treinos t ON a.id_treino = t.id_treino
                        JOIN atleta at ON a.id_atleta = at.id_atleta
                        JOIN pessoas p ON at.id_pessoa = p.id_pessoa
                        ORDER BY p.nome ASC, a.data_avaliacao DESC";

                $result = $conn->query($sql);
                $dados_por_atleta = [];

                while ($row = $result->fetch_assoc()) {
                    $id_atleta = $row['id_atleta'];
                    $dados_por_atleta[$id_atleta]['nome'] = $row['nome_atleta'];
                    $dados_por_atleta[$id_atleta]['avaliacoes'][] = $row;
                }
            ?>

            <script>
                function toggleById(id, iconId) {
                    const section = document.getElementById(id);
                    const icon = document.getElementById(iconId);
                    const isVisible = section.style.display === 'block';
                    section.style.display = isVisible ? 'none' : 'block';
                    icon.textContent = isVisible ? '▼' : '▲';
                }
            </script>

            <?php
                foreach ($dados_por_atleta as $id_atleta => $atleta) {
                    $atletaCardId = "card_body_{$id_atleta } ";
                    $atletaIconId = "icon_atleta_{$id_atleta } ";
                    echo "<div class='card-atleta '> ";
                    echo "<div class='card-header' onclick=\"toggleById('$atletaCardId', '$atletaIconId')\">";
                    echo "<span>{$atleta['nome']}</span>";
                    echo "<span id='$atletaIconId'> ▼</span>";
                    echo "</div>";
                    echo "<div class='card-body' id='$atletaCardId'>";

                    foreach ($atleta['avaliacoes'] as $avaliacao) {
                        $treinoId = $avaliacao['id_treino'];
                        $treinoToggleId = "treino_info_{$id_atleta}_{$treinoId}";
                        $treinoIconId = "icon_treino_{$id_atleta}_{$treinoId}";
                        $melhor_marca = $avaliacao['melhor_marca'] ? 'Sim' : 'Não';

                        echo "<div class='treino-header' onclick=\"toggleById('$treinoToggleId', '$treinoIconId')\">";
                        echo "<span>{$avaliacao['tipo_treino']} - {$avaliacao['data_treino']}</span>";
                        echo "<span id='$treinoIconId'>▼</span>";
                        echo "</div>";

                        echo "<div class='treino-info' id='$treinoToggleId'>";
                        echo "<p><strong>Data da Avaliação:</strong> {$avaliacao['data_avaliacao']}</p>";
                        echo "<p><strong>Cansaço:</strong> {$avaliacao['cansaco']}</p>";
                        echo "<p><strong>Dificuldades:</strong><br>" . nl2br(htmlspecialchars($avaliacao['dificuldades'])) . "</p>";
                        echo "<p><strong>Melhor Marca:</strong> {$melhor_marca}</p>";
                        echo "</div>";
                    }

                    echo "</div></div>";
                }
            ?>


        </div>
        
    </body>
</html>