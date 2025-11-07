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
        <button type="button" class="theme-toggle" id="theme-toggle" aria-pressed="false">
            <span class="theme-toggle__icon" aria-hidden="true"></span>
            <span class="theme-toggle__label">Mode sombre</span>
        </button>
    </nav>
</header>
<script>
(function () {
    const storageKey = 'livre-or-theme';
    const root = document.documentElement;
    const toggle = document.getElementById('theme-toggle');
    if (!toggle) {
        return;
    }

    const label = toggle.querySelector('.theme-toggle__label');
    const prefersDark = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;

    const getStoredTheme = () => {
        try {
            return localStorage.getItem(storageKey);
        } catch (error) {
            return null;
        }
    };

    const setButtonState = (theme) => {
        const isDark = theme === 'dark';
        toggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
        if (label) {
            label.textContent = isDark ? 'Mode clair' : 'Mode sombre';
        }
    };

    const applyTheme = (theme) => {
        const resolved = theme === 'dark' ? 'dark' : 'light';
        root.setAttribute('data-theme', resolved);
        setButtonState(resolved);
    };

    const storedTheme = getStoredTheme();
    const initialTheme = storedTheme || (prefersDark && prefersDark.matches ? 'dark' : 'light');
    applyTheme(initialTheme);

    toggle.addEventListener('click', () => {
        const current = root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
        const next = current === 'dark' ? 'light' : 'dark';
        applyTheme(next);
        try {
            localStorage.setItem(storageKey, next);
        } catch (error) {
            // Stockage indisponible, on ignore.
        }
    });

    if (prefersDark) {
        const updateFromSystem = (event) => {
            if (getStoredTheme()) {
                return;
            }
            applyTheme(event.matches ? 'dark' : 'light');
        };

        if (prefersDark.addEventListener) {
            prefersDark.addEventListener('change', updateFromSystem);
        } else if (prefersDark.addListener) {
            prefersDark.addListener(updateFromSystem);
        }
    }
})();
</script>