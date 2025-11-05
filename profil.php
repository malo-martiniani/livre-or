<?php
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

$errors = [];
$success = '';

$stmt = $pdo->prepare('SELECT id, login, password FROM utilisateurs WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_unset();
    session_destroy();
    header('Location: connexion.php');
    exit();
}

$loginValue = $user['login'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newLogin = trim($_POST['login'] ?? '');
    $newPassword = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if ($newLogin === '') {
        $errors[] = 'Le login ne peut pas être vide.';
    }

    if ($newPassword !== '') {
        if ($newPassword !== $confirmPassword) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        } elseif (strlen($newPassword) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM utilisateurs WHERE login = ? AND id <> ?');
        $stmt->execute([$newLogin, $user['id']]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Ce login est déjà utilisé par un autre utilisateur.';
        }
    }

    if (!$errors) {
        $params = [$newLogin, $user['id']];
        $sql = 'UPDATE utilisateurs SET login = ?';

        if ($newPassword !== '') {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $sql .= ', password = ?';
            $params = [$newLogin, $hashedPassword, $user['id']];
        }

        $sql .= ' WHERE id = ?';
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute($params)) {
            $_SESSION['login'] = $newLogin;
            $loginValue = $newLogin;
            $success = $newPassword !== ''
                ? 'Profil mis à jour avec un nouveau mot de passe.'
                : 'Profil mis à jour.';
        } else {
            $errors[] = 'Une erreur est survenue lors de la mise à jour.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main class="main">
        <p class="welcome-message">Bienvenue, <?php echo htmlspecialchars($_SESSION['login']); ?> !</p>

        <?php if ($success !== ''): ?>
            <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

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
                <label for="login">Login :</label>
                <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($loginValue); ?>" required>
            </div>
            <div>
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="Laisser vide pour ne pas changer">
            </div>
            <div>
                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Laisser vide si inchangé">
            </div>
            <button type="submit">Mettre à jour</button>
        </form>
    </main>
</body>
</html>
