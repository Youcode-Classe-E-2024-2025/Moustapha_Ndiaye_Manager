<?php
function db_connect()
{
    $host = 'localhost';
    $dbname = 'recipeDB';
    $username = 'root';
    $password = 'L1mpi2019@!';

    try {
        $connexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connexion réussie à la base de données!";
        return $connexion;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
