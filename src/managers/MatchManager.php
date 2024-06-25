<?php

namespace App\Managers;

use PDO;

class MatchManager extends AbstractManager
{
    // Récupère tous les matchs avec les informations des équipes
    public function findAllWithTeams()
    {
        $stmt = $this->db->query('
            SELECT m.*, t1.name as team1_name, t2.name as team2_name, t1.flag as team1_flag, t2.flag as team2_flag
            FROM matches m
            JOIN teams t1 ON m.team1_id = t1.id
            JOIN teams t2 ON m.team2_id = t2.id
        ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un match par son identifiant avec les informations des équipes
    public function findById($matchId)
    {
        $stmt = $this->db->prepare('
            SELECT m.*, t1.name as team1_name, t2.name as team2_name, t1.flag as team1_flag, t2.flag as team2_flag
            FROM matches m
            JOIN teams t1 ON m.team1_id = t1.id
            JOIN teams t2 ON m.team2_id = t2.id
            WHERE m.match_id = ?
        ');
        $stmt->execute([$matchId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Met à jour le résultat d'un match
    public function updateResult($matchId, $result)
    {
        $stmt = $this->db->prepare('UPDATE matches SET result = ? WHERE match_id = ?');
        $stmt->execute([$result, $matchId]);
    }

    // Réinitialise le résultat d'un match
    public function resetMatchResult($matchId)
    {
        $stmt = $this->db->prepare('UPDATE matches SET result = NULL WHERE match_id = ?');
        $stmt->execute([$matchId]);
    }

    // Ajoute un nouveau match
    public function addMatch($team1Id, $team2Id, $matchDate, $description)
    {
        $stmt = $this->db->prepare('INSERT INTO matches (team1_id, team2_id, match_date, description) VALUES (?, ?, ?, ?)');
        $stmt->execute([$team1Id, $team2Id, $matchDate, $description]);
    }

    // Récupère toutes les équipes
    public function findAllTeams()
    {
        $stmt = $this->db->query('SELECT * FROM teams');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
