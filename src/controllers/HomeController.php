<?php

namespace App\Controllers;

// Déclaration de la classe HomeController qui hérite de AbstractController
class HomeController extends AbstractController
{
    // Méthode publique pour afficher la page d'accueil
    public function home()
    {
        // Rend la vue 'home' avec un modèle de données vide
        $this->render('home', []);
    }

    // Méthode publique pour afficher la page des mentions légales
    public function legal()
    {
        // Rend la vue 'legal' avec un modèle de données vide
        $this->render('legal', []);
    }
}
?>
