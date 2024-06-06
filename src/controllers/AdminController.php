<?php

namespace App\Controllers;

// Importation des gestionnaires nécessaires
use App\Managers\MatchManager;
use App\Managers\PredictionManager;
use App\Managers\UserManager;

// Déclaration de la classe AdminController qui hérite de AbstractController
class AdminController extends AbstractController
{
    // Propriétés privées pour les gestionnaires
    private $matchManager;
    private $predictionManager;
    private $userManager;

    // Constructeur pour initialiser les gestionnaires
    public function __construct()
    {
        $this->matchManager = new MatchManager();
        $this->predictionManager = new PredictionManager();
        $this->userManager = new UserManager();
    }

    // Méthode privée pour vérifier si l'utilisateur est un administrateur
    private function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user'] == 1;
    }

    // Méthode pour afficher le panneau d'administration
    public function adminPanel()
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Rediriger vers la page de login si l'utilisateur n'est pas admin
        if (!$this->isAdmin()) {
            header('Location: index.php?route=login');
            exit();
        }

        // Récupérer les matchs et les utilisateurs
        $matches = $this->matchManager->findAllWithTeams();
        $users = $this->userManager->findAllWithScores();
        // Rendre la vue admin avec les données récupérées
        $this->render('admin', ['matches' => $matches, 'users' => $users]);
    }

    // Méthode pour mettre à jour le résultat d'un match
    public function updateMatchResult()
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier si l'utilisateur est admin
        if (!$this->isAdmin()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }

        // Vérifier si les données nécessaires sont présentes
        if (isset($_POST['match_id'], $_POST['result'])) {
            $matchId = $_POST['match_id'];
            $result = $_POST['result'];

            // Réinitialiser les prédictions du match
            $this->predictionManager->resetPredictions($matchId);

            // Mettre à jour le résultat du match
            $this->matchManager->updateResult($matchId, $result);

            // Valider les nouvelles prédictions
            $this->predictionManager->validatePredictions($matchId, $result);

            // Récupérer le nouveau classement et le match modifié
            $users = $this->userManager->findAllWithScores();
            $match = $this->matchManager->findById($matchId);

            // Retourner une réponse JSON avec le succès de l'opération
            echo json_encode(['success' => true, 'users' => $users, 'match' => $match]);
            exit();
        } else {
            // Retourner une réponse JSON indiquant que des informations sont manquantes
            echo json_encode(['success' => false, 'message' => 'Missing match results.']);
            exit();
        }
    }

    // Méthode pour supprimer un match
    public function deleteMatch()
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier si l'utilisateur est admin
        if (!$this->isAdmin()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }

        // Vérifier si l'ID du match est fourni
        if (isset($_GET['id'])) {
            $matchId = $_GET['id'];

            // Réinitialiser les prédictions et le résultat du match
            $this->matchManager->resetMatchResult($matchId);
            $this->predictionManager->resetPredictions($matchId);

            // Récupérer le nouveau classement
            $users = $this->userManager->findAllWithScores();

            // Retourner une réponse JSON avec le succès de l'opération
            echo json_encode(['success' => true, 'users' => $users, 'matchId' => $matchId]);
            exit();
        } else {
            // Retourner une réponse JSON indiquant que l'ID du match est manquant
            echo json_encode(['success' => false, 'message' => 'Match ID missing']);
            exit();
        }
    }
}
?>
