<?php

// Enregistre une fonction anonyme comme implémentation de l'autoload
spl_autoload_register(function ($class) {
    // Préfixe de l'espace de noms spécifique à notre projet
    $prefix = 'App\\';
    // Répertoire de base où se trouvent les classes de notre projet
    $base_dir = __DIR__ . '/../src/';

    // Longueur du préfixe
    $len = strlen($prefix);
    // Vérifie si la classe utilise le préfixe de notre projet
    if (strncmp($prefix, $class, $len) !== 0) {
        // Si le préfixe ne correspond pas, ne pas continuer
        return;
    }

    // Récupère le nom de la classe relative sans le préfixe
    $relative_class = substr($class, $len);
    // Remplace les séparateurs de namespace par des séparateurs de répertoire et ajoute l'extension .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Si le fichier correspondant existe, le requiert
    if (file_exists($file)) {
        require $file;
    }
});
?>
