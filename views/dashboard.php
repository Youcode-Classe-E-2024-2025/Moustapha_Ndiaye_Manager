<?php
require_once '../includes/auth_functions.php';

// Vérifier si l'utilisateur est connecté
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

// Récupérer les informations de l'utilisateur depuis la session
session_start();
$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../public/assets/css/output.css">
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($user_name) ?></h1>
    <a href="../process/logout.php">Déconnexion</a>
    
    <!-- Contenu du tableau de bord -->
</body>
</html>