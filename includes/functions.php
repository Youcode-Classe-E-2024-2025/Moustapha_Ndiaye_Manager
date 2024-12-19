<?php
// functions.php

// Fonction pour valider une adresse email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Fonction pour valider si un mot de passe est sécurisé (longueur minimum, etc.)
function validate_password($password) {
    return strlen($password) >= 6; // Exemple de validation de longueur minimale
}

// Fonction pour échapper les entrées utilisateur pour éviter les injections SQL
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Fonction pour afficher un message d'erreur
function show_error($message) {
    echo "<div class='error'>$message</div>";
}
