<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$isLoggedIn = isset($_SESSION['user_id']);
?>
<header class="header">
    <h1>Le Livre d'Or</h1>
    <nav class="nav">
        <a class="<?= $currentPage === 'index.php' ? 'is-active' : '' ?>" href="index.php">Accueil</a>
        <a class="<?= $currentPage === 'livre-or.php' ? 'is-active' : '' ?>" href="livre-or.php">Livre d'Or</a>
        <?php if ($isLoggedIn): ?>
            <a class="<?= $currentPage === 'commentaire.php' ? 'is-active' : '' ?>" href="commentaire.php">Commentaire</a>
            <a class="<?= $currentPage === 'profil.php' ? 'is-active' : '' ?>" href="profil.php">Profil</a>
            <a href="deconnexion.php">Déconnexion</a>
        <?php else: ?>
            <a class="<?= $currentPage === 'connexion.php' ? 'is-active' : '' ?>" href="connexion.php">Connexion</a>
            <a class="<?= $currentPage === 'inscription.php' ? 'is-active' : '' ?>" href="inscription.php">Inscription</a>
        <?php endif; ?>
    </nav>
</header>