<?php

namespace App\Config;

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\PredictionController;
use App\Controllers\LeaderboardController;
use App\Controllers\AdminController;

class Router
{
    public function handleRequest(array $get, array $post)
    {
        $route = $get['route'] ?? 'home';
        $controller = null;

        switch ($route) {
            // Routes pour l'authentification
            case 'login':
                $controller = new AuthController();
                $controller->login();
                break;
            case 'register':
                $controller = new AuthController();
                $controller->register();
                break;
            case 'logout':
                $controller = new AuthController();
                $controller->logout();
                break;
            case 'verify-email':
                $controller = new AuthController();
                $controller->verifyEmail();
                break;
            case 'check-username':
                $controller = new AuthController();
                $controller->checkUsername();
                break;

            // Routes pour les prédictions
            case 'predictions':
                $controller = new PredictionController();
                $controller->index();
                break;
            case 'submit-prediction':
                $controller = new PredictionController();
                $controller->submitPrediction($post);
                break;

            // Routes pour le classement
            case 'leaderboard':
                $controller = new LeaderboardController();
                $controller->showLeaderboard();
                break;
            case 'leaderboard-data':
                $controller = new LeaderboardController();
                $controller->getLeaderboardData();
                break;

            // Routes pour l'administration
            case 'admin':
                $controller = new AdminController();
                $controller->adminPanel();
                break;
            case 'update-match-result':
                $controller = new AdminController();
                $controller->updateMatchResult();
                break;
            case 'delete-match':
                $controller = new AdminController();
                $controller->deleteMatch();
                break;
            case 'add-match': // Nouvelle route pour ajouter un match
                $controller = new AdminController();
                $controller->addMatch();
                break;

            // Routes pour les pages légales et d'accueil
            case 'legal':
                $controller = new HomeController();
                $controller->legal();
                break;
            case 'home':
            default:
                $controller = new HomeController();
                $controller->home();
                break;
        }
    }
}
