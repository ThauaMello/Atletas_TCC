<!-- menu.php -->
<div class="menu">
    <ul>
        <li><a href="index_Tec.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index_Tec.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="lista_opcoes_Tec.php" class="<?= basename($_SERVER['PHP_SELF']) == 'lista_opcoes_Tec.php' ? 'active' : '' ?>">Lista</a></li>
        <li><a href="cadastrar_OP_Tec.php" class="<?= basename($_SERVER['PHP_SELF']) == 'cadastrar_OP_Tec.php' ? 'active' : '' ?>">Cadastrar</a></li>
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