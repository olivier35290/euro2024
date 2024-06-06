<?php

namespace App\Controllers;

// Importation de la classe UserManager
use App\Managers\UserManager;

// Déclaration de la classe LeaderboardController qui hérite de AbstractController
class LeaderboardController extends AbstractController
{
    // Propriété privée pour stocker l'instance du gestionnaire des utilisateurs
    private $userManager;

    // Constructeur pour initialiser le gestionnaire des utilisateurs
    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    // Méthode pour afficher le classement des utilisateurs
    public function showLeaderboard()
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: index.php?route=login');
            exit();
        }

        // Récupérer tous les utilisateurs avec leurs scores
        $users = $this->userManager->findAllWithScores();
        // Rendre la vue 'leaderboard' avec les données des utilisateurs
        $this->render('leaderboard', ['users' => $users]);
    }

    // Méthode pour obtenir les données du classement des utilisateurs en format JSON
    public function getLeaderboardData()
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Définir l'en-tête de la réponse en JSON pour s'assurer que la réponse est au format JSON
        header('Content-Type: application/json');

        // Récupérer tous les utilisateurs avec leurs scores
        $users = $this->userManager->findAllWithScores();
        // Convertir les données en JSON et les afficher
        echo json_encode($users);
        exit();
    }
}
?>
