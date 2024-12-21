<?php
// public/index.php

session_start();

// Récupérer l'URL et la méthode HTTP
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];

// Fonction pour inclure les vues
function safeRequire($path) {
    if (file_exists($path)) {
        require_once $path;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "Page non trouvée";
        exit();
    }
}

// Gérer les requêtes POST
if ($request_method === 'POST') {
    if ($request_uri === '/login') {
        require_once '../process/login_process.php';
        exit();
    } elseif ($request_uri === '/register') {
        require_once '../process/register_process.php';
        exit();
    }
}

// Gérer les requêtes GET
switch ($request_uri) {
    case '/login':
        safeRequire('../views/login.php');
        break;

    case '/register':
        safeRequire('../views/register.php');
        break;

    case '/dashboard':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        safeRequire('../views/dashboard.php');
        break;

        case '/homePage':
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit();
            }
            safeRequire('../views/homePage.php');
            break;

    case '/':
        header('Location: /login');
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page non trouvée";
        break;
}
