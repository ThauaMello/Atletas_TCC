<div class="menu">
    <ul>
        <li><a href="/TCC/Atleta/intex_Atleta.php" class="<?= basename($_SERVER['PHP_SELF']) == 'intex_Atleta.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="/TCC/Atleta/lista_treinos_Atl.php" class="<?= basename($_SERVER['PHP_SELF']) == 'lista_treinos_Atl.php' ? 'active' : '' ?>">Lista treinos</a></li>
        <li><a href="/TCC/Atleta/relatorio_Atleta.php" class="<?= basename($_SERVER['PHP_SELF']) == 'relatorio_Atleta.php' ? 'active' : '' ?>">Relatorios</a></li>
        <li><a href="#" onclick="confirmLogout()">Sair</a></li>
    </ul>
</div>

<script>
function confirmLogout() {
    if (confirm("Deseja realmente sair do sistema?")) {
        window.location.href = "../logout.php";
    }
}
</script>