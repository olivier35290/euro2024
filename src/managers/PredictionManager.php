<?php

namespace App\Managers;

use App\Models\Prediction;
use PDO;

// Déclaration de la classe PredictionManager qui hérite de AbstractManager
class PredictionManager extends AbstractManager
{
    // Méthode pour créer une nouvelle prédiction
    public function create(Prediction $prediction): void
    {
        // Préparation de la requête SQL pour insérer une nouvelle prédiction dans la base de données
        $stmt = $this->db->prepare('INSERT INTO predictions (user_id, match_id, prediction_result, validated, correct, updated_at) VALUES (?, ?, ?, ?, ?, NOW())');
        // Exécution de la requête en passant les données de la prédiction
        $stmt->execute([
            $prediction->getUserId(),
            $prediction->getMatchId(),
            $prediction->getPredictionResult(),
            $prediction->getValidated(),
            $prediction->getCorrect()
        ]);
    }

    // Méthode pour mettre à jour une prédiction existante
    public function update(Prediction $prediction): void
    {
        // Préparation de la requête SQL pour mettre à jour une prédiction existante dans la base de données
        $stmt = $this->db->prepare('UPDATE predictions SET user_id = ?, match_id = ?, prediction_result = ?, validated = ?, correct = ?, updated_at = NOW() WHERE prediction_id = ?');
        // Exécution de la requête en passant les nouvelles données de la prédiction
        $stmt->execute([
            $prediction->getUserId(),
            $prediction->getMatchId(),
            $prediction->getPredictionResult(),
            $prediction->getValidated(),
            $prediction->getCorrect(),
            $prediction->getId()
        ]);
    }

    // Méthode pour valider les prédictions d'un match donné
    public function validatePredictions(int $matchId, string $result): void
    {
        // Préparation de la requête SQL pour sélectionner les prédictions non validées d'un match donné
        $stmt = $this->db->prepare('SELECT * FROM predictions WHERE match_id = ? AND validated = 0');
        // Exécution de la requête en passant l'ID du match
        $stmt->execute([$matchId]);
        // Récupération des prédictions sous forme de tableau associatif
        $predictions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Boucle sur chaque prédiction pour la valider
        foreach ($predictions as $prediction) {
            // Vérifie si la prédiction est correcte
            $correct = ($prediction['prediction_result'] == $result) ? 1 : 0;

            // Préparation de la requête SQL pour mettre à jour la prédiction
            $stmtUpdate = $this->db->prepare('UPDATE predictions SET validated = 1, correct = ?, updated_at = NOW() WHERE prediction_id = ?');
            // Exécution de la requête en passant le statut de la prédiction (correcte ou non) et l'ID de la prédiction
            $stmtUpdate->execute([$correct, $prediction['prediction_id']]);
        }
    }

    // Méthode pour récupérer les dernières prédictions d'un utilisateur
    public function findLastPredictionsByUserId(int $userId): array
    {
        // Préparation de la requête SQL pour sélectionner les prédictions d'un utilisateur, triées par date de création décroissante
        $stmt = $this->db->prepare('
            SELECT p.match_id, p.prediction_result
            FROM predictions p
            WHERE p.user_id = ?
            ORDER BY p.created_at DESC
        ');
        // Exécution de la requête en passant l'ID de l'utilisateur
        $stmt->execute([$userId]);
        // Récupération des prédictions sous forme de tableau associatif
        $predictions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Tableau pour stocker les dernières prédictions par match
        $lastPredictions = [];
        // Boucle sur chaque prédiction pour ne conserver que la dernière prédiction par match
        foreach ($predictions as $prediction) {
            $matchId = $prediction['match_id'];
            if (!isset($lastPredictions[$matchId])) {
                $lastPredictions[$matchId] = $prediction['prediction_result'];
            }
        }

        // Retourne les dernières prédictions par match
        return $lastPredictions;
    }

    // Méthode pour réinitialiser les prédictions d'un match donné
    public function resetPredictions(int $matchId): void
    {
        // Préparation de la requête SQL pour réinitialiser les prédictions d'un match donné
        $stmt = $this->db->prepare('UPDATE predictions SET validated = 0, correct = NULL WHERE match_id = ?');
        // Exécution de la requête en passant l'ID du match
        $stmt->execute([$matchId]);
    }

    // Méthode pour supprimer une prédiction existante pour un utilisateur et un match donnés
    public function deleteExistingPrediction(int $userId, int $matchId): void
    {
        // Préparation de la requête SQL pour supprimer une prédiction existante
        $stmt = $this->db->prepare('DELETE FROM predictions WHERE user_id = ? AND match_id = ?');
        // Exécution de la requête en passant l'ID de l'utilisateur et l'ID du match
        $stmt->execute([$userId, $matchId]);
    }
}
?>
