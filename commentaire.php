<?php
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentaire = trim($_POST['content'] ?? '');

    if ($commentaire === '') {
        $errors[] = 'Veuillez écrire un commentaire avant de valider.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (?, ?, NOW())');

        if ($stmt->execute([$commentaire, $_SESSION['user_id']])) {
            header('Location: livre-or.php');
            exit();
        }

        $errors[] = "Impossible d'enregistrer votre commentaire pour le moment.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un commentaire</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main class="main">
        <h1>Ajouter un commentaire</h1>

        <?php if ($errors): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="form">
            <div>
                <label for="content">Votre message :</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <div>
                <button type="submit">Publier</button>
            </div>
        </form>
    </main>
</body>
</html>
