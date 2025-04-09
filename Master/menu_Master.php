<!-- menu.php -->
<div class="menu">
    <ul>
        <li><a href="index_Master.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index_Master.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="lista_opcoes_Master.php" class="<?= basename($_SERVER['PHP_SELF']) == 'lista_opcoes_Master.php' ? 'active' : '' ?>">Lista</a></li>
        <li><a href="cadastro_opcoes_Master.php" class="<?= basename($_SERVER['PHP_SELF']) == 'cadastro_opcoes_Master.php' ? 'active' : '' ?>">Cadastrar</a></li>
    </ul>
</div>