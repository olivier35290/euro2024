<?php

namespace App\Controllers;

// Importation des classes nécessaires
use App\Models\User;
use App\Managers\UserManager;

// Déclaration de la classe AuthController qui hérite de AbstractController
class AuthController extends AbstractController
{
    // Propriété privée pour stocker l'instance du gestionnaire des utilisateurs
    private $userManager;

    // Constructeur pour initialiser le gestionnaire des utilisateurs
    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    // Méthode pour gérer la connexion des utilisateurs
    public function login()
    {
        // Vérifie si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère l'email et le mot de passe depuis les données POST
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Recherche l'utilisateur par email
            $user = $this->userManager->findByEmail($email);

            // Vérifie si l'utilisateur existe et si le mot de passe est correct
            if ($user && password_verify($password, $user->getPassword())) {
                // Démarre une session et stocke l'ID de l'utilisateur dans la session
                $_SESSION['user'] = $user->getId();
                // Redirige vers la page d'accueil
                header('Location: index.php');
                exit();
            } else {
                // Rend la vue de connexion avec un message d'erreur
                $this->render('login', ['error' => 'Identifiants invalides']);
            }
        } else {
            // Rend la vue de connexion
            $this->render('login', []);
        }
    }

    // Méthode pour gérer l'inscription des utilisateurs
    public function register()
    {
        // Vérifie si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère les données depuis les données POST
            $username = $_POST['username'];
            $email = $_POST['email'];
            $confirmEmail = $_POST['confirm_email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Vérifie si les emails correspondent
            if ($email !== $confirmEmail) {
                // Rend la vue d'inscription avec un message d'erreur
                $this->render('register', ['error' => 'Les emails ne correspondent pas.']);
                return;
            }

            // Vérifie si les mots de passe correspondent
            if ($password !== $confirmPassword) {
                // Rend la vue d'inscription avec un message d'erreur
                $this->render('register', ['error' => 'Les mots de passe ne correspondent pas.']);
                return;
            }

            // Vérifie si l'email est déjà utilisé
            if ($this->userManager->emailExists($email)) {
                // Rend la vue d'inscription avec un message d'erreur
                $this->render('register', ['error' => 'Cet email est déjà utilisé.']);
                return;
            }

            // Vérifie si le nom d'utilisateur est déjà pris
            if ($this->userManager->usernameExists($username)) {
                // Rend la vue d'inscription avec un message d'erreur
                $this->render('register', ['error' => 'Ce nom d\'utilisateur est déjà pris.']);
                return;
            }

            // Hache le mot de passe avant de le stocker
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            // Crée une nouvelle instance de User
            $user = new User($username, $email, $hashedPassword);
            // Ajoute l'utilisateur à la base de données
            $this->userManager->create($user);

            // Indique que l'inscription a réussi
            $_SESSION['registration_success'] = true;
            // Redirige vers la page de connexion
            header('Location: index.php?route=login');
            exit();
        } else {
            // Rend la vue d'inscription
            $this->render('register', []);
        }
    }

    // Méthode pour gérer la déconnexion des utilisateurs
    public function logout()
    {
        // Démarre la session
        session_start();
        // Détruit la session
        session_destroy();
        // Redirige vers la page d'accueil
        header('Location: index.php');
        exit();
    }

    // Méthode pour vérifier si un nom d'utilisateur existe déjà
    public function checkUsername()
    {
        // Vérifie si le paramètre 'username' est défini dans les paramètres GET
        if (isset($_GET['username'])) {
            // Récupère le nom d'utilisateur depuis les paramètres GET
            $username = $_GET['username'];
            // Vérifie si le nom d'utilisateur existe
            $exists = $this->userManager->usernameExists($username);
            // Définit l'en-tête de la réponse en JSON
            header('Content-Type: application/json');
            // Retourne une réponse JSON indiquant si le nom d'utilisateur existe
            echo json_encode(['exists' => $exists]);
            exit();
        }
    }
}
?>
