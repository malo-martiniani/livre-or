<?php
include 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main class="main">
        <section class="hero-card">
            <h1>Bienvenue dans le Livre d'Or</h1>
            <p>
                Ce livre d'or rassemble les souvenirs, impressions et messages laissés par les visiteurs.
                Prenez un instant pour vous imprégner de l'ambiance, puis ajoutez votre trace pour prolonger la mémoire des lieux.
            </p>
        </section>

        <section class="welcome-card">
            <h2>Comment contribuer&nbsp;?</h2>
            <p>
                1. Créez un compte ou connectez-vous pour pouvoir publier un message.<br>
                2. Rendez-vous sur la page <em>Livre d'Or</em> pour découvrir les mots déjà partagés.<br>
                3. Laissez un commentaire personnalisé et soigné dans l'espace dédié.
            </p>
        </section>

        <section class="hero-card">
            <h2>Un écrin doré et argenté</h2>
            <p>
                Le thème raffiné met en lumière des nuances dorées et argentées, offrant une expérience à la fois chaleureuse et élégante.
                Selon vos préférences, alternez entre le mode clair et sombre pour profiter pleinement de la navigation.
            </p>
        </section>

        <section class="welcome-card">
            <h2>Vos messages comptent</h2>
            <p>
                Chaque témoignage enrichit la mémoire collective. Vos mots sont précieux&nbsp;: prenez le temps de les choisir.
                Merci de faire vivre ce livre d'or avec respect et générosité.
            </p>
            <p>
                <a class="cta-link" href="livre-or.php">Explorer le Livre d'Or</a>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a class="cta-link" href="connexion.php">Se connecter</a>
                    <a class="cta-link" href="inscription.php">Créer un compte</a>
                <?php else: ?>
                    <a class="cta-link" href="commentaire.php">Écrire un commentaire</a>
                <?php endif; ?>
            </p>
        </section>
    </main>
</body>
</html>