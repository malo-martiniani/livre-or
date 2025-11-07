<?php include 'includes/config.php';
// Destroy the session to log out the user
session_destroy();
header('Location: connexion.php');