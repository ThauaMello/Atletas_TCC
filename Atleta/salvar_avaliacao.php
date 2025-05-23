<?php
    session_start();
    include_once("../conexao.php");

        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'atleta') {
            header("Location: ../login.php");
            exit();
        }

        $id_treino = $_POST['id_treino'] ?? null;
        $id_atleta = $_POST['id_atleta'] ?? null;
        $cansaco = $_POST['cansaco'] ?? null;
        $dificuldades = trim($_POST['dificuldades'] ?? '');
        $melhor_marca = $_POST['melhor_marca'] ?? null;

        if ($id_treino && $id_atleta && $cansaco !== null && $melhor_marca !== null) {
            $sql = "INSERT INTO avaliacoes_treino (id_treino, id_atleta, cansaco, dificuldades, melhor_marca)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiisi", $id_treino, $id_atleta, $cansaco, $dificuldades, $melhor_marca);

            if ($stmt->execute()) {
                echo "<p style='text-align:center; color:green;'>✅ Avaliação enviada com sucesso!</p>";
                echo "<script>setTimeout(() => window.location.href = 'lista_treinos_Atl.php', 2000);</script>";
            } else {
                echo "❌ Erro ao salvar avaliação: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "<p style='color:red;'>⚠️ Preencha todos os campos obrigatórios.</p>";
        }

        $conn->close();

