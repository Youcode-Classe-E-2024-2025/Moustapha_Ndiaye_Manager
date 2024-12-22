<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/auth_functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Appel de la fonction de validation
    $validation_errors = validate_register_input($fname, $lname, $email, $password, $confirm_password);

    // Fusionner les erreurs de validation
    $errors = array_merge($errors, $validation_errors);

    if (empty($errors)) {
        try {
            $connexion = db_connect(); // Connexion à la base de données

            if (register_user($fname, $lname, $email, $password, $connexion)) {
                // Redirection vers la page de connexion en cas de succès
                header('Location: login?registered=1');
                exit;
            } else {
                $errors[] = "Failed registration.";
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }

    // Redirection avec les erreurs
    if (!empty($errors)) {
        $errors_query = http_build_query(['errors' => $errors]);
        header("Location: register?registerIN=1&" . $errors_query);
        exit;
    }
}