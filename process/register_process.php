<?php
// process/register_process.php

// Inclure la connexion à la base de données
require_once '../config/database.php';


function validate_login_input($email, $password) {
    $errors = [];

    // Validation de l'email
    if (empty($email)) {
        $errors[] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    }

    // Validation du mot de passe
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis";
    } elseif (strlen($password) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
    }

    return $errors;
}

function validate_register_input($name, $email, $password, $confirm_password) {
    $errors = [];

    // Validation du nom
    if (empty($name)) {
        $errors[] = "Le nom est requis";
    }

    // Validation de l'email
    if (empty($email)) {
        $errors[] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    }

    // Validation du mot de passe
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis";
    } elseif (strlen($password) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
    }

    // Confirmation du mot de passe
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    return $errors;
}

function user_exists($email) {
    $connexion = db_connect();
    $stmt = $connexion->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->rowCount() > 0;
}

function register_user($name, $email, $password) {
    $connexion = db_connect();
    
    // Hachez le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Préparez la requête d'insertion
    $stmt = $connexion->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    
    try {
        return $stmt->execute([$name, $email, $hashed_password]);
    } catch(PDOException $e) {
        // Gérer les erreurs potentielles
        return false;
    }
}

function authenticate_user($email, $password) {
    $connexion = db_connect();
    
    // Préparez la requête de sélection
    $stmt = $connexion->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Vérifiez le mot de passe
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    
    return false;
}

function start_user_session($user) {
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
}

function is_logged_in() {
    session_start();
    return isset($_SESSION['user_id']);
}

function logout_user() {
    session_start();
    session_destroy();
    header('Location: login.php');
    exit();
}