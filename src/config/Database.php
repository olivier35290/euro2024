<?php

// Fonction pour obtenir une connexion à la base de données
function getDatabaseConnection() {
    // Charger les variables d'environnement à partir du fichier .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Récupérer les informations de connexion à la base de données à partir des variables d'environnement
    $host = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASS'];

    try {
        // Créer une nouvelle instance PDO pour la connexion à la base de données
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        // Configurer PDO pour qu'il lève des exceptions en cas d'erreurs
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Retourner l'objet PDO représentant la connexion à la base de données
        return $pdo;
    } catch (PDOException $e) {
        // En cas d'échec de la connexion, afficher un message d'erreur et arrêter l'exécution du script
        die('Connection failed: ' . $e->getMessage());
    }
}
?>
