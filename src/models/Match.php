<?php
namespace App\Models;

// Déclaration de la classe Matches pour représenter les informations sur les matchs
class Matches {
    // Déclaration des propriétés privées de la classe
    private $id;
    private $team1_id;
    private $team2_id;
    private $match_date;
    private $result_team1;
    private $result_team2;
    private $description;

    // Méthode pour obtenir l'ID du match
    public function getId(): int {
        return $this->id;
    }

    // Méthode pour définir l'ID du match
    public function setId(int $id): void {
        $this->id = $id;
    }

    // Méthode pour obtenir l'ID de la première équipe
    public function getTeam1Id(): int {
        return $this->team1_id;
    }

    // Méthode pour définir l'ID de la première équipe
    public function setTeam1Id(int $team1_id): void {
        $this->team1_id = $team1_id;
    }

    // Méthode pour obtenir l'ID de la deuxième équipe
    public function getTeam2Id(): int {
        return $this->team2_id;
    }

    // Méthode pour définir l'ID de la deuxième équipe
    public function setTeam2Id(int $team2_id): void {
        $this->team2_id = $team2_id;
    }

    // Méthode pour obtenir la date du match
    public function getMatchDate(): string {
        return $this->match_date;
    }

    // Méthode pour définir la date du match
    public function setMatchDate(string $match_date): void {
        $this->match_date = $match_date;
    }

    // Méthode pour obtenir le résultat de la première équipe (peut être null)
    public function getResultTeam1(): ?int {
        return $this->result_team1;
    }

    // Méthode pour définir le résultat de la première équipe (peut être null)
    public function setResultTeam1(?int $result_team1): void {
        $this->result_team1 = $result_team1;
    }

    // Méthode pour obtenir le résultat de la deuxième équipe (peut être null)
    public function getResultTeam2(): ?int {
        return $this->result_team2;
    }

    // Méthode pour définir le résultat de la deuxième équipe (peut être null)
    public function setResultTeam2(?int $result_team2): void {
        $this->result_team2 = $result_team2;
    }

    // Méthode pour obtenir la description du match
    public function getDescription(): string {
        return $this->description;
    }

    // Méthode pour définir la description du match
    public function setDescription(string $description): void {
        $this->description = $description;
    }
}
?>
