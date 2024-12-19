<?php
// public/index.php

// Démarrer la session
session_start();

// Récupérer l'URL demandée
$request_uri = $_SERVER['REQUEST_URI'];

// Routage simple
switch ($request_uri) {
    case '/login':
        require_once '../views/login.php';
        break;

    case '/register':
        require_once '../views/register.php'; 
        break;

    case '/admin':
        // Vérifier si l'utilisateur est connecté (si nécessaire)
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login'); 
            exit();
        }
        require_once 'admin.php'; 
        break;

    case '/':
        require_once '../views/login.php'; 
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page non trouvée";
        break;
}
