<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'tecnico') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Treino</title>
    <link rel="stylesheet" href="../estilo/estilo.css">
</head>
<body>
    <?php include 'menu_Tec.php'; ?>

    <div class="container-treino">
        <h2>Cadastro de Treino</h2>

        <form action="processar_cadastro_treino.php" method="POST">
            <div class="form-grid">

                <div>
                    <label for="tipo_treino">Tipo de treino:</label>
                    <input type="text" id="tipo_treino" name="tipo_treino" required>
                </div>

                <div>
                    <label for="dia_semana">Dia da Semana:</label>
                    <select id="dia_semana" name="dia_semana" required>
                        <option value="">Selecione</option>
                        <option value="Segunda">Segunda</option>
                        <option value="Terça">Terça</option>
                        <option value="Quarta">Quarta</option>
                        <option value="Quinta">Quinta</option>
                        <option value="Sexta">Sexta</option>
                        <option value="Sábado">Sábado</option>
                        <option value="Domingo">Domingo</option>
                    </select>
                </div>

                <div>
                    <label for="data_treino">Data do treino:</label>
                    <input type="date" id="data_treino" name="data_treino" required>
                </div>

                <div>
                    <label for="duracao">Duração (ex: 01:30h):</label>
                    <input type="text" id="duracao" name="duracao" required>
                </div>

                <div class="full-width">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" required></textarea>
                </div>

                <div class="full-width">
                    <label>Selecionar Atletas:</label>
                    <?php
                        include_once("../conexao.php");

                        $sql = "SELECT a.id_atleta, p.nome 
                                FROM atleta a
                                JOIN pessoas p ON a.id_pessoa = p.id_pessoa";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            echo "<div style='display: flex; flex-wrap: wrap; gap: 10px;'>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<label style='flex: 1 1 200px;'>
                                        <input type='checkbox' name='id_atleta[]' value='{$row['id_atleta']}'> {$row['nome']}
                                    </label>";
                            }
                            echo "</div>";
                        } else {
                            echo "<p style='color:red;'>Nenhum atleta encontrado.</p>";
                        }
                    ?>
                </div>


            </div>

            <div class="btn-center">
                <button type="submit">Cadastrar Treino</button>
            </div>
        </form>
    </div>
</body>
</html>
