<?php

// Charger automatiquement les classes nécessaires grâce à Composer
require __DIR__ . '/vendor/autoload.php';

// Utilisation du namespace pour accéder à la classe Dotenv
use Dotenv\Dotenv;

// Chargement des variables d'environnement à partir d'un fichier .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Récupération des informations de connexion à la base de données depuis les variables d'environnement
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

try {
    // Création d'une instance de PDO pour se connecter à la base de données MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    // Configuration de PDO pour lancer des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Message de succès si la connexion est réussie
    echo "Connexion à la base de données réussie.";
} catch (PDOException $e) {
    // Affichage d'un message d'erreur si la connexion échoue
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
