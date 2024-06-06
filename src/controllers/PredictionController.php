<?php

namespace App\Controllers;

// Importation des classes nécessaires
use App\Managers\MatchManager;
use App\Managers\PredictionManager;
use App\Managers\UserManager;
use App\Models\Prediction;

// Déclaration de la classe PredictionController qui hérite de AbstractController
class PredictionController extends AbstractController
{
    // Propriétés privées pour stocker les instances des gestionnaires
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

    // Méthode pour afficher la page des prédictions
    public function index()
    {
        // Démarre la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: index.php?route=login');
            exit();
        }

        // Récupère l'ID de l'utilisateur connecté
        $userId = $_SESSION['user'];
        // Récupère les informations de l'utilisateur
        $user = $this->userManager->findById($userId);

        // Récupère tous les matchs avec les informations des équipes
        $matches = $this->matchManager->findAllWithTeams();
        // Récupère les dernières prédictions de l'utilisateur
        $lastPredictions = $this->predictionManager->findLastPredictionsByUserId($userId);

        // Rend la vue 'predictions' avec les données nécessaires
        $this->render('predictions', [
            'matches' => $matches,
            'username' => $user['username'],
            'lastPredictions' => $lastPredictions
        ]);
    }

    // Méthode pour soumettre une prédiction
    public function submitPrediction($post)
    {
        // Démarre la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: index.php?route=login');
            exit();
        }

        // Vérifie si les données nécessaires sont présentes dans la requête POST
        if (isset($post['match_id'], $post['prediction_result'])) {
            $matchId = $post['match_id'];
            $predictionResult = $post['prediction_result'];

            // Récupère les informations du match
            $match = $this->matchManager->findById($matchId);
            // Crée des objets DateTime pour l'heure actuelle et l'heure du match
            $currentDateTime = new \DateTime();
            $matchDateTime = new \DateTime($match['match_date']);
            // Calcule la différence entre l'heure actuelle et l'heure du match
            $interval = $currentDateTime->diff($matchDateTime);

            // Vérifie si le match a déjà commencé ou est sur le point de commencer
            if ($interval->invert == 1 || ($interval->h < 1 && $interval->d == 0 && $interval->m == 0)) {
                // Récupère l'ID de l'utilisateur connecté
                $userId = $_SESSION['user'];
                // Récupère les informations de l'utilisateur
                $user = $this->userManager->findById($userId);

                // Rend la vue 'predictions' avec un message d'erreur
                $this->render('predictions', [
                    'matches' => $this->matchManager->findAllWithTeams(),
                    'username' => $user['username'],
                    'error' => 'Vous ne pouvez plus faire de pronostic sur ce match.'
                ]);
                return;
            }

            // Récupère l'ID de l'utilisateur connecté
            $userId = $_SESSION['user'];

            // Supprime l'ancienne prédiction de l'utilisateur pour ce match
            $this->predictionManager->deleteExistingPrediction($userId, $matchId);

            // Crée une nouvelle prédiction
            $prediction = new Prediction($userId, $matchId, $predictionResult);
            // Ajoute la nouvelle prédiction à la base de données
            $this->predictionManager->create($prediction);

            // Indique que la soumission de la prédiction a réussi
            $_SESSION['prediction_success'] = true;
            // Redirige vers la page des prédictions
            header('Location: index.php?route=predictions');
            exit();
        } else {
            // Récupère l'ID de l'utilisateur connecté
            $userId = $_SESSION['user'];
            // Récupère les informations de l'utilisateur
            $user = $this->userManager->findById($userId);

            // Rend la vue 'predictions' avec un message d'erreur
            $this->render('predictions', [
                'matches' => $this->matchManager->findAllWithTeams(),
                'username' => $user['username'],
                'error' => 'Veuillez sélectionner un match et un résultat.'
            ]);
        }
    }
}
?>
