<?php
include 'includes/config.php';

$stmt = $pdo->prepare('SELECT c.commentaire, c.date, u.login FROM commentaires c JOIN utilisateurs u ON c.id_utilisateur = u.id ORDER BY c.date DESC');
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Livre d\'or</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php include 'includes/header.php'; ?>
	<main class="main">
		<h1>Livre d'or</h1>

		<?php if (isset($_SESSION['user_id'])): ?>
			<p><a class="cta-link" href="commentaire.php">Écrire un nouveau commentaire</a></p>
		<?php else: ?>
			<p class="welcome-message">Connectez-vous pour laisser une trace de votre passage.</p>
		<?php endif; ?>

		<?php if ($comments): ?>
			<ul class="comment-list">
				<?php foreach ($comments as $comment): ?>
					<li class="comment">
						<p><?php echo nl2br(htmlspecialchars($comment['commentaire'])); ?></p>
						<small>Posté le <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($comment['date']))); ?> par <?php echo htmlspecialchars($comment['login']); ?></small>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p>Aucun commentaire pour le moment. Soyez le premier à vous exprimer !</p>
		<?php endif; ?>
	</main>
</body>
</html>