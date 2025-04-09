<?php
session_start();
$id_atleta = $_SESSION['id_atleta']; // Ajuste para o login real

include __DIR__ . '/../db_connect.php';

// Carregar modalidades
$modalidades = [];
$modal_query = "SELECT DISTINCT modalidade FROM treinos WHERE id_atleta = $id_atleta";
$modal_result = $conn->query($modal_query);
while ($row = $modal_result->fetch_assoc()) {
    $modalidades[] = $row['modalidade'];
}

// Filtrando a modalidade
$filtro = isset($_GET['modalidade']) ? $_GET['modalidade'] : '';
$sql = "SELECT * FROM treinos WHERE id_atleta = $id_atleta";
if ($filtro) {
    $sql .= " AND modalidade = '" . $conn->real_escape_string($filtro) . "'";
}
$sql .= " ORDER BY data DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Histórico de Treinos</title>
  <link rel="stylesheet" href="../estilo/estilo.css">
  <script>
    function toggleInfo(button) {
      const info = button.closest('.record').querySelector('.record-info');
      if (info.style.display === 'none') {
        info.style.display = 'block';
        button.textContent = '▲';
      } else {
        info.style.display = 'none';
        button.textContent = '▼';
      }
    }

    function abrirAvaliacao(idTreino) {
      const modal = document.getElementById('modalAvaliacao');
      document.getElementById('id_treino_input').value = idTreino;
      modal.style.display = 'block';
    }

    function fecharAvaliacao() {
      document.getElementById('modalAvaliacao').style.display = 'none';
    }
  </script>
    
</head>
<body>

<?php include 'menu_Atl.php'; ?>

<div class="main-container">
  <h2 class="form-title">Histórico de Treinos</h2>

  <form method="GET" style="margin-bottom: 20px;">
    <label>Filtrar por Modalidade:</label>
    <select name="modalidade" onchange="this.form.submit()">
      <option value="">Todas</option>
      <?php
        foreach ($modalidades as $mod) {
            $selected = ($mod == $filtro) ? 'selected' : '';
            echo "<option value='$mod' $selected>$mod</option>";
        }
      ?>
    </select>
  </form>

  <?php
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<div class='record'>";
        echo "<button class='toggle-info' onclick='toggleInfo(this)'>▼</button>";
        echo "<div class='record-name'>Treino em " . date('d/m/Y', strtotime($row["data"])) . "</div>";
        echo "<div class='record-info'>";
        echo "<p><strong>Descrição:</strong> " . $row["descricao"] . "</p>";
        echo "<p><strong>Modalidade:</strong> " . $row["modalidade"] . "</p>";
        echo "<p><strong>Marca/Tempo:</strong> " . $row["marca"] . "</p>";
        echo "<p><strong>Observações:</strong> " . $row["observacoes"] . "</p>";
        echo "<button onclick='abrirAvaliacao(" . $row["id"] . ")'>Avaliar</button>";
        echo "</div>";
        echo "</div>";
      }
    } else {
      echo "<p>Nenhum treino encontrado.</p>";
    }
    $conn->close();
  ?>
</div>

<!-- Modal para avaliação -->
<div id="modalAvaliacao" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="fecharAvaliacao()">X</span>
    <h3>Avaliação do Treino</h3>
    <form method="POST" action="salvar_avaliacao.php">
      <input type="hidden" name="id_treino" id="id_treino_input">
      <label for="cansaco">Cansaço (1 a 5):</label>
      <input type="number" name="cansaco" min="1" max="5" required><br>
      <label for="dificuldades">Dificuldades:</label>
      <textarea name="dificuldades"></textarea><br>
      <label><input type="checkbox" name="melhor_marca"> Melhor Marca Pessoal</label><br>
      <button type="submit">Enviar</button>
    </form>
  </div>
</div>

</body>
</html>
