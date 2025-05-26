<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'master') {
    header("Location: ../login.php");
    exit();
}

include_once("../conexao.php");

$tipo = $_GET['tipo'] ?? null;
if (!$tipo || !in_array($tipo, ['tecnico', 'atleta'])) {
    echo "Tipo inválido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de <?= ucfirst($tipo) . 's' ?></title>
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

<?php include 'menu_Master.php'; ?>

<div class="main-container">
    <h2 class="form-title">Lista de <?= ucfirst($tipo) . 's' ?></h2>

    <?php
    $sql = "SELECT * FROM pessoas WHERE tipo = ? ORDER BY nome";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
            $id = $row['id_pessoa'] ?? null;
            $nome = htmlspecialchars($row['nome'] ?? 'Sem nome');
            $usuario = htmlspecialchars($row['usuario'] ?? '-');
            $cpf = htmlspecialchars($row['cpf'] ?? '-');

            echo "<div class='record'>";
            echo "<button class='toggle-info' onclick='toggleInfo(this)'>▼</button>";
            //echo "<img src='../img/avatar_padrao.png' alt='Foto'>";
            echo "<div class='record-name'>" . $nome . "</div>";
            echo "<div class='record-info'>";
            echo "<p><strong>Usuário:</strong> $usuario</p>";
            echo "<p><strong>CPF:</strong> $cpf</p>";

            if ($id) {
                echo "<a href='../Cadastro/editar.php?id=$id'>Editar</a> | ";
                echo "<a href='../Cadastro/excluir.php?id=$id' onclick=\"return confirm('Deseja excluir este usuário?')\">Excluir</a>";
            } else {
                echo "<p><em>Erro: ID do usuário ausente.</em></p>";
            }

            echo "</div>";
            echo "</div>";
        endwhile;
    else:
        echo "<p>Nenhum " . $tipo . " encontrado.</p>";
    endif;

    $conn->close();
    ?>
</div>

</body>
</html>
