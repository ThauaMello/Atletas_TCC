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
            <form action="salvar_treino.php" method="POST">
                <div class="form-grid">
                    <div>
                        <label for="tipo">Tipo de treino:</label>
                        <input type="text" id="tipo" name="tipo" required>
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
                        <label for="data">Data do treino:</label>
                        <input type="date" id="data" name="data" required>
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
                        <label for="resultado">Resultado (opcional):</label>
                        <textarea id="resultado" name="resultado"></textarea>
                    </div>

                    <div class="full-width">
                        <label for="atletas">Selecionar Atletas:</label>
                        <select id="atletas" name="atletas[]" multiple size="5" required>
                            <!-- Aqui você insere os <option> dos atletas com PHP -->
                        </select>
                    </div>
                </div>

                <div class="btn-center">
                    <button type="submit">Cadastrar Treino</button>
                </div>
            </form>
         </div>
</body>
</html>
