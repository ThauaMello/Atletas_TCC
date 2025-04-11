<!-- menu.php -->
<div class="menu">
    <ul>
        <li><a href="/TCC/Master/index_Master.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index_Master.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="/TCC/Master/lista_opcoes_Master.php" class="<?= basename($_SERVER['PHP_SELF']) == 'lista_opcoes_Master.php' ? 'active' : '' ?>">Lista</a></li>
        <li><a href="/TCC/Master/cadastro_opcoes_Master.php" class="<?= basename($_SERVER['PHP_SELF']) == 'cadastro_opcoes_Master.php' ? 'active' : '' ?>">Cadastrar</a></li>
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