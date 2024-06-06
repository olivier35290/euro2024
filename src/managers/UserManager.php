<?php

namespace App\Managers;

use App\Models\User;
use PDO;

// Déclaration de la classe UserManager qui hérite de AbstractManager
class UserManager extends AbstractManager
{
    // Méthode pour trouver un utilisateur par son adresse e-mail
    public function findByEmail(string $email): ?User
    {
        // Préparation de la requête SQL pour sélectionner un utilisateur par son e-mail
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        // Exécution de la requête en passant l'adresse e-mail
        $stmt->execute([$email]);
        // Récupération des données de l'utilisateur sous forme de tableau associatif
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si l'utilisateur existe, crée un objet User et le retourne
        if ($user) {
            $userObj = new User($user['username'], $user['email'], $user['password_hash']);
            $userObj->setId($user['user_id']);
            return $userObj;
        }

        // Si l'utilisateur n'existe pas, retourne null
        return null;
    }

    // Méthode pour trouver un utilisateur par son ID
    public function findById(int $userId): array
    {
        // Préparation de la requête SQL pour sélectionner un utilisateur par son ID
        $stmt = $this->db->prepare('SELECT * FROM users WHERE user_id = ?');
        // Exécution de la requête en passant l'ID de l'utilisateur
        $stmt->execute([$userId]);
        // Retourne les données de l'utilisateur sous forme de tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour créer un nouvel utilisateur
    public function create(User $user): void
    {
        // Préparation de la requête SQL pour insérer un nouvel utilisateur dans la base de données
        $stmt = $this->db->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
        // Exécution de la requête en passant les données de l'utilisateur
        $stmt->execute([$user->getUsername(), $user->getEmail(), $user->getPassword()]);
        // Mise à jour de l'ID de l'utilisateur avec l'ID généré par la base de données
        $user->setId($this->db->lastInsertId());
    }

    // Méthode pour vérifier si une adresse e-mail existe déjà dans la base de données
    public function emailExists(string $email): bool
    {
        // Préparation de la requête SQL pour compter le nombre d'utilisateurs avec une adresse e-mail donnée
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        // Exécution de la requête en passant l'adresse e-mail
        $stmt->execute([$email]);
        // Retourne true si au moins un utilisateur a cette adresse e-mail, false sinon
        return $stmt->fetchColumn() > 0;
    }

    // Méthode pour vérifier si un nom d'utilisateur existe déjà dans la base de données
    public function usernameExists(string $username): bool
    {
        // Préparation de la requête SQL pour compter le nombre d'utilisateurs avec un nom d'utilisateur donné
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
        // Exécution de la requête en passant le nom d'utilisateur
        $stmt->execute([$username]);
        // Retourne true si au moins un utilisateur a ce nom d'utilisateur, false sinon
        return $stmt->fetchColumn() > 0;
    }

    // Méthode pour récupérer tous les utilisateurs avec leur score
    public function findAllWithScores(): array
    {
        // Exécution de la requête SQL pour sélectionner tous les utilisateurs et compter le nombre de prédictions correctes pour chaque utilisateur
        $stmt = $this->db->query('
            SELECT u.user_id, u.username, COUNT(p.correct) as score
            FROM users u
            LEFT JOIN predictions p ON u.user_id = p.user_id AND p.correct = 1
            GROUP BY u.user_id, u.username
            ORDER BY score DESC
        ');
        // Retourne les utilisateurs et leurs scores sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
