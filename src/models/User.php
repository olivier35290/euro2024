<?php

namespace App\Models;

// Déclaration de la classe User pour représenter les informations sur les utilisateurs
class User
{
    // Déclaration des propriétés privées de la classe
    private $id;          // Identifiant unique de l'utilisateur
    private $username;    // Nom d'utilisateur
    private $email;       // Adresse email de l'utilisateur
    private $password;    // Hash du mot de passe de l'utilisateur

    // Constructeur de la classe User pour initialiser les propriétés nécessaires
    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;  // Initialisation du nom d'utilisateur
        $this->email = $email;        // Initialisation de l'adresse email
        $this->password = $password;  // Initialisation du mot de passe (hashé)
    }

    // Méthode pour obtenir l'ID de l'utilisateur
    public function getId(): int
    {
        return $this->id;
    }

    // Méthode pour obtenir le nom d'utilisateur
    public function getUsername(): string
    {
        return $this->username;
    }

    // Méthode pour obtenir l'adresse email de l'utilisateur
    public function getEmail(): string
    {
        return $this->email;
    }

    // Méthode pour obtenir le mot de passe (hashé) de l'utilisateur
    public function getPassword(): string
    {
        return $this->password;
    }

    // Méthode pour définir l'ID de l'utilisateur
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Méthode pour définir le nom d'utilisateur
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    // Méthode pour définir l'adresse email de l'utilisateur
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    // Méthode pour définir le mot de passe (hashé) de l'utilisateur
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
?>
