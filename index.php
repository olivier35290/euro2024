<?php

// Charger automatiquement les classes nécessaires grâce à Composer
require __DIR__ . '/vendor/autoload.php';

// Utilisation des namespaces pour accéder aux classes Dotenv et Router
use Dotenv\Dotenv;
use App\Config\Router;

// Chargement des variables d'environnement à partir d'un fichier .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Démarrage de la session pour pouvoir utiliser $_SESSION
session_start();

// Création d'une instance de la classe Router
$router = new Router();

// Appel de la méthode handleRequest du routeur pour gérer la requête actuelle
$router->handleRequest($_GET, $_POST);

?>
