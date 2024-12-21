<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('MIN_PASSWORD_LENGTH', 8);
define('PASSWORD_HASH_ALGO', PASSWORD_DEFAULT);

require_once __DIR__ . '/../config/database.php';

// login
function validate_login_input($email, $password)
{
    $errors = [];

    if (empty($email)) {
        $errors[] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    }

    if (empty($password)) {
        $errors[] = "Le mot de passe est requis";
    }

    return $errors;
}

function user_exists($email, $connexion)
{
    try {
        $stmt = $connexion->prepare("SELECT 1 FROM USERS WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() !== false;
    } catch (PDOException $e) {
        error_log("Erreur lors de la vérification de l'existence de l'utilisateur: " . $e->getMessage());
        throw new Exception("Une erreur est survenue lors de la vérification de l'email");
    }
}

function authenticate_user($email, $password, $connexion)
{
    try {
        $stmt = $connexion->prepare("SELECT * FROM USERS WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        // Mise à jour du hash si nécessaire
        if (password_needs_rehash($user['password_hash'], PASSWORD_HASH_ALGO)) {
            $new_hash = password_hash($password, PASSWORD_HASH_ALGO);
            $update = $connexion->prepare("UPDATE USERS SET password_hash = ? WHERE user_id = ?");
            $update->execute([$new_hash, $user['user_id']]);
        }

        return $user;
    } catch (PDOException $e) {
        error_log("Erreur lors de l'authentification: " . $e->getMessage());
        throw new Exception("Une erreur est survenue lors de la connexion");
    }
}


//register
function validate_register_input($fname, $lname, $email, $password, $confirm_password)
{
    $errors = [];

    // Validation du prénom
    if (empty($fname)) {
        $errors[] = "Le prénom est requis";
    } elseif (strlen($fname) > 100) {
        $errors[] = "Le prénom ne doit pas dépasser 100 caractères";
    }

    // Validation du nom
    if (empty($lname)) {
        $errors[] = "Le nom est requis";
    } elseif (strlen($lname) > 100) {
        $errors[] = "Le nom ne doit pas dépasser 100 caractères";
    }

    // Validation de l'email
    if (empty($email)) {
        $errors[] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    } elseif (strlen($email) > 255) {
        $errors[] = "L'email ne doit pas dépasser 255 caractères";
    }

    // Validation du mot de passe
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis";
    } elseif (strlen($password) < MIN_PASSWORD_LENGTH) {
        $errors[] = "Le mot de passe doit contenir au moins " . MIN_PASSWORD_LENGTH . " caractères";
    }

    // Confirmation du mot de passe
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    return $errors;
}



function is_first_user($connexion)
{
    try {
        $stmt = $connexion->query("SELECT COUNT(*) FROM users");
        // On vérifie si la table est vide
        return $stmt->fetchColumn() == 0; // renvoie true si aucun utilisateur
    } catch (PDOException $e) {
        error_log("Erreur lors de la vérification du premier utilisateur: " . $e->getMessage());
        return false;
    }
}



function register_user($fname, $lname, $email, $password, $connexion)
{
    try {
        // Vérifie si l'email existe déjà
        if (user_exists($email, $connexion)) {
            throw new Exception("Cet email est déjà utilisé");
        }

        // Détermine si c'est le premier utilisateur
        $is_admin = is_first_user($connexion);
         
        $role = $is_admin ? 'admin' : 'user';

        // Hash le mot de passe
        $password_hash = password_hash($password, PASSWORD_HASH_ALGO);

        if ($password_hash === false) {
            throw new Exception("Erreur lors du hashage du mot de passe");
        }

        // Préparation de la requête SQL
        $stmt = $connexion->prepare("
            INSERT INTO USERS (Fname, Lname, email, password_hash, role) 
            VALUES (?, ?, ?, ?, ?)
        ");

        // Exécution de la requête
        $result = $stmt->execute([
            htmlspecialchars($fname, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($lname, ENT_QUOTES, 'UTF-8'),
            $email,
            $password_hash,
            $role
        ]);

        // Vérification de l'exécution de la requête
        if ($result) {
            return "Utilisateur inscrit avec succès en tant que " . $role;
        } else {
            throw new Exception("L'inscription a échoué, veuillez réessayer. Si le problème persiste, contactez le support.");
        }
    } catch (PDOException $e) {
        error_log("Erreur lors de l'inscription: " . $e->getMessage());
        throw new Exception("Une erreur est survenue lors de l'inscription");
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}


function display_registration_success() {
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


function sanitize_input($input) {
    if (is_array($input)) {
        return array_map('sanitize_input', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function show_error($message) {
    echo "<div class='error'>" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</div>";
}