<?php
namespace App\Controllers;

// Déclaration de la classe abstraite AbstractController
abstract class AbstractController
{
    // Méthode protégée pour rendre une vue avec un modèle de données
    protected function render(string $template, array $data = []) : void
    {
        // Ajouter la route actuelle aux données
        $data['current_route'] = $_GET['route'] ?? 'home';
        // Extraire les données en variables individuelles
        extract($data);
        // Inclure le fichier de mise en page principal
        require __DIR__ . "/../templates/layout.phtml";
    }

    // Méthode protégée pour rendre des données en format JSON
    protected function renderJson(array $data) : void
    {
        // Convertir les données en JSON et les afficher
        echo json_encode($data);
    }

    // Méthode protégée pour rediriger vers une autre route
    protected function redirect(string $route) : void
    {
        // Envoyer un en-tête HTTP de redirection
        header("Location: $route");
        // Terminer le script
        exit();
    }
}
?>
