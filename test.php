<?php
// Inclure le fichier contenant la fonction db_connect()
require_once 'config/database.php';  // Assure-toi que le chemin est correct

// Appeler la fonction db_connect()
$connexion = db_connect();

// Vérifier si la connexion a réussi
if ($connexion) {
    echo "Connexion réussie à la base de données!";
} else {
    echo "Échec de la connexion!";
}
