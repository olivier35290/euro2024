<?php

namespace App\Managers;

// Utilisation de la classe PDO pour la gestion de la base de données
use PDO;

// Déclaration de la classe MatchManager qui hérite de AbstractManager
class MatchManager extends AbstractManager
{
    // Méthode pour récupérer tous les matchs avec les informations des équipes
    public function findAllWithTeams(): array
    {
        // Exécution de la requête SQL pour joindre les tables matches et teams et récupérer les données nécessaires
        $stmt = $this->db->query('
            SELECT m.*, t1.name as team1_name, t2.name as team2_name, t1.flag as team1_flag, t2.flag as team2_flag
            FROM matches m
            JOIN teams t1 ON m.team1_id = t1.id
            JOIN teams t2 ON m.team2_id = t2.id
        ');
        // Retourne toutes les lignes du résultat sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer les informations d'un match par son ID
    public function findById(int $matchId): array
    {
        // Préparation de la requête SQL pour joindre les tables matches et teams et récupérer les données pour un match spécifique
        $stmt = $this->db->prepare('
            SELECT m.*, t1.name as team1_name, t2.name as team2_name, t1.flag as team1_flag, t2.flag as team2_flag
            FROM matches m
            JOIN teams t1 ON m.team1_id = t1.id
            JOIN teams t2 ON m.team2_id = t2.id
            WHERE m.match_id = ?
        ');
        // Exécution de la requête en passant l'ID du match
        $stmt->execute([$matchId]);
        // Retourne la ligne du résultat sous forme de tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour mettre à jour le résultat d'un match
    public function updateResult(int $matchId, string $result): void
    {
        // Préparation de la requête SQL pour mettre à jour le résultat d'un match spécifique
        $stmt = $this->db->prepare('UPDATE matches SET result = ? WHERE match_id = ?');
        // Exécution de la requête en passant le nouveau résultat et l'ID du match
        $stmt->execute([$result, $matchId]);
    }

    // Méthode pour réinitialiser le résultat d'un match
    public function resetMatchResult(int $matchId): void
    {
        // Préparation de la requête SQL pour réinitialiser le résultat d'un match spécifique
        $stmt = $this->db->prepare('UPDATE matches SET result = NULL WHERE match_id = ?');
        // Exécution de la requête en passant l'ID du match
        $stmt->execute([$matchId]);
    }
}
?>
