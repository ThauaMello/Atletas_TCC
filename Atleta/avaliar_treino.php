<?php //rever pagina completaaaaaaaaaaaaaaaaaaaaaaaaa
    session_start();
    include_once("../conexao.php");

        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'atleta') {
            header("Location: ../login.php");
            exit();
        }

        $id_treino = $_GET['id'] ?? null;
        if (!$id_treino) {
            echo "Treino não especificado.";
            exit();
            }
            $id_pessoa = $_SESSION['id'];
            $sql_atleta = "SELECT id_atleta FROM atleta WHERE id_pessoa = ?";
            $stmt = $conn->prepare($sql_atleta);
            $stmt->bind_param("i", $id_pessoa);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $id_atleta = $row['id_atleta'];


            $sql = "SELECT 1 FROM treino_atletas WHERE id_treino = ? AND id_atleta = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id_treino, $id_atleta);
            $stmt->execute();

        if ($stmt->get_result()->num_rows === 0) {
            echo "⚠️ Treino não pertence ao atleta.";
            exit();
        }

?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Avaliar Treino</title>
        <link rel="stylesheet" href="../estilo/estilo.css">
    </head>

    <body>
        
        <?php include 'menu_Atl.php'; ?>

        <div class="container-treino">
            <h2 class="form-title">Avaliação do Treino</h2>

            <form class="cadastro-form" action="salvar_avaliacao.php" method="POST">
                <input type="hidden" name="id_treino" value="<?= htmlspecialchars($id_treino) ?>">
                
                
                    <label for="avaliacao">Descreva seu desempenho neste treino:</label>
                    <textarea name="avaliacao" id="avaliacao" rows="5" class="input-field" required></textarea>
                
                


                <button type="submit" class="button">Enviar Avaliação</button>
            </form>
        </div>
    </body>
</html>
