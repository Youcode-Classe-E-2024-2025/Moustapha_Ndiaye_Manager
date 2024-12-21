<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Inclure la connexion à la base de données
require_once __DIR__ . '/../config/database.php';
require_once '../includes/auth_functions.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Se connecter à la base de données
    $pdo = db_connect();

    if ($pdo) {
        // Requête SQL pour récupérer l'utilisateur par email
        $stmt = $pdo->prepare("SELECT user_id, email, password_hash, role FROM USERS WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Connexion réussie, démarrer la session
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            if ($_SESSION['role'] == 'admin') {
                // Rediriger l'utilisateur vers le tableau de bord ou page admin
                header("Location: /dashboard");
                exit();
            } else {
                // Rediriger l'utilisateur vers le tableau de bord ou page admin
                header("Location: /homePage");
                exit();
            }
        } else {
            //echo "Nom d'utilisateur ou mot de passe incorrect.";
            header('Location: login?loginIn=1');
                exit;
        }
    } else {
        echo "Erreur de connexion à la base de données.";
    }
}

function start_user_session($user)
{
    session_start();

    // Régénération de l'ID de session pour prévenir la fixation de session
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['fname'] = htmlspecialchars($user['Fname'], ENT_QUOTES, 'UTF-8');
    $_SESSION['lname'] = htmlspecialchars($user['Lname'], ENT_QUOTES, 'UTF-8');
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['last_activity'] = time();
}


function is_logged_in()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return isset($_SESSION['user_id']);
}

function is_admin()
{
    if (!is_logged_in()) {
        return false;
    }

    return $_SESSION['role'] === 'admin';
}

function logout_user()
{
    session_start();
    session_destroy();
    header('Location: login.php');
    exit();
}

function display_registration_success()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['registration_success'])) {
        $message = $_SESSION['registration_success'];
        unset($_SESSION['registration_success']); // On supprime le message après l'avoir affiché
        return "<div class='success-message'>" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</div>";
    }
    return '';
}
