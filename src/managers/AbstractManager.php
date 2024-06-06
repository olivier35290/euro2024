<?php

namespace App\Managers;

// Utilisation de la classe PDO pour la gestion de la base de données
use PDO;

// Déclaration de la classe abstraite AbstractManager
abstract class AbstractManager
{
    // Propriété protégée pour stocker l'instance de la connexion à la base de données
    protected $db;

    // Constructeur de la classe qui initialise la connexion à la base de données
    public function __construct()
    {
        // Appelle la méthode getDatabaseConnection pour établir la connexion
        $this->db = $this->getDatabaseConnection();
    }

    // Méthode privée pour obtenir la connexion à la base de données
    private function getDatabaseConnection()
    {
        // Récupère les informations de connexion à partir des variables d'environnement
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        try {
            // Création d'une nouvelle instance de PDO avec les informations de connexion
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            // Définit le mode d'erreur de PDO pour lancer des exceptions en cas d'erreur
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Retourne l'instance de PDO
            return $pdo;
        } catch (PDOException $e) {
            // Arrête l'exécution du script et affiche un message d'erreur en cas de problème de connexion
            die('Connection failed: ' . $e->getMessage());
        }
    }
}
?>
