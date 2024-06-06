<?php

namespace App\Models;

// Déclaration de la classe Prediction pour représenter les informations sur les prédictions
class Prediction
{
    // Déclaration des propriétés privées de la classe
    private $id;
    private $user_id;
    private $match_id;
    private $prediction_result;
    private $validated;
    private $correct;
    private $created_at;
    private $updated_at;

    // Constructeur de la classe Prediction pour initialiser les propriétés nécessaires
    public function __construct(int $user_id, int $match_id, string $prediction_result)
    {
        $this->user_id = $user_id;  // Identifiant de l'utilisateur
        $this->match_id = $match_id;  // Identifiant du match
        $this->prediction_result = $prediction_result;  // Résultat prédit
        $this->validated = 0;  // Indicateur de validation, initialisé à 0 (non validé)
        $this->correct = 0;  // Indicateur de correction, initialisé à 0 (incorrect)
    }

    // Méthode pour obtenir l'ID de la prédiction
    public function getId(): int
    {
        return $this->id;
    }

    // Méthode pour obtenir l'ID de l'utilisateur
    public function getUserId(): int
    {
        return $this->user_id;
    }

    // Méthode pour obtenir l'ID du match
    public function getMatchId(): int
    {
        return $this->match_id;
    }

    // Méthode pour obtenir le résultat prédit
    public function getPredictionResult(): string
    {
        return $this->prediction_result;
    }

    // Méthode pour obtenir l'état de validation
    public function getValidated(): int
    {
        return $this->validated;
    }

    // Méthode pour obtenir l'état de correction
    public function getCorrect(): int
    {
        return $this->correct;
    }

    // Méthode pour obtenir la date de création de la prédiction
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    // Méthode pour obtenir la date de mise à jour de la prédiction
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    // Méthode pour définir l'ID de la prédiction
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Méthode pour définir l'ID de l'utilisateur
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    // Méthode pour définir l'ID du match
    public function setMatchId(int $match_id): void
    {
        $this->match_id = $match_id;
    }

    // Méthode pour définir le résultat prédit
    public function setPredictionResult(string $prediction_result): void
    {
        $this->prediction_result = $prediction_result;
    }

    // Méthode pour définir l'état de validation
    public function setValidated(int $validated): void
    {
        $this->validated = $validated;
    }

    // Méthode pour définir l'état de correction
    public function setCorrect(int $correct): void
    {
        $this->correct = $correct;
    }

    // Méthode pour définir la date de création de la prédiction
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    // Méthode pour définir la date de mise à jour de la prédiction
    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
?>
