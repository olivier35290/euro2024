<?php

namespace App\Controllers;

use App\Managers\MatchManager;
use App\Managers\PredictionManager;
use App\Managers\UserManager;

class AdminController extends AbstractController
{
    private $matchManager;
    private $predictionManager;
    private $userManager;

    // Constructeur pour initialiser les gestionnaires (managers)
    public function __construct()
    {
        $this->matchManager = new MatchManager();
        $this->predictionManager = new PredictionManager();
        $this->userManager = new UserManager();
    }

    // Vérifie si l'utilisateur est administrateur
    private function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user'] == 1;
    }

    // Affiche le panneau d'administration
    public function adminPanel()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!$this->isAdmin()) {
            header('Location: index.php?route=login');
            exit();
        }

        $matches = $this->matchManager->findAllWithTeams();
        $users = $this->userManager->findAllWithScores();
        $teams = $this->matchManager->findAllTeams(); // Récupération des équipes pour le formulaire

        $this->render('admin', ['matches' => $matches, 'users' => $users, 'teams' => $teams]);
    }

    // Met à jour le résultat d'un match
    public function updateMatchResult()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!$this->isAdmin()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }

        if (isset($_POST['match_id'], $_POST['result'])) {
            $matchId = $_POST['match_id'];
            $result = $_POST['result'];

            $this->matchManager->updateResult($matchId, $result);
            $this->predictionManager->validatePredictions($matchId, $result);

            $users = $this->userManager->findAllWithScores();
            $match = $this->matchManager->findById($matchId);

            echo json_encode(['success' => true, 'users' => $users, 'match' => $match]);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing match results.']);
            exit();
        }
    }

    // Supprime un match
    public function deleteMatch()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!$this->isAdmin()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }

        if (isset($_GET['id'])) {
            $matchId = $_GET['id'];

            $this->matchManager->resetMatchResult($matchId);
            $this->predictionManager->resetPredictions($matchId);

            $users = $this->userManager->findAllWithScores();

            echo json_encode(['success' => true, 'users' => $users, 'matchId' => $matchId]);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Match ID missing']);
            exit();
        }
    }

    // Ajoute un nouveau match
    public function addMatch()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!$this->isAdmin()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }

        if (isset($_POST['team1_id'], $_POST['team2_id'], $_POST['match_date'], $_POST['description'])) {
            $team1Id = $_POST['team1_id'];
            $team2Id = $_POST['team2_id'];
            $matchDate = $_POST['match_date'];
            $description = $_POST['description'];

            $this->matchManager->addMatch($team1Id, $team2Id, $matchDate, $description);

            $matches = $this->matchManager->findAllWithTeams();

            echo json_encode(['success' => true, 'matches' => $matches]);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing match details.']);
            exit();
        }
    }
}
