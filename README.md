# La Team Pronostics

Une application simple et intuitive pour gérer les pronostics de l'EURO 2024, développée avec PHP pour l'API et un front-end en HTML/CSS/JS.

## Fonctionnalités

- Inscription et connexion des utilisateurs
- Faire des pronostics sur les matchs de l'EURO 2024
- Voir les résultats des matchs pronostiquer
- Voir le classement des utilisateurs
- Panel administrateur pour gérer les matchs et les utilisateurs

## Technologies utilisées

- **Front-end :** HTML, CSS (Flexbox), JavaScript
- **Back-end :** PHP avec PDO pour la gestion de la base de données
- **Base de données :** MySQL
- **Autres :** Composer pour la gestion des dépendances, PHP Dotenv pour la gestion des variables d'environnement

## Installation et Configuration

### Pré-requis

- PHP 8.0.3 ou plus
- MySQL 5.7 ou plus
- Composer

### Étapes d'installation

1. Cloner le dépôt :

```bash
git clone https://github.com/votre-repo.git
cd votre-repo

2. Installer les dépendances :
composer install

3. Configurer les variables d'environnement :
Créer un fichier .env à la racine du projet et y ajouter les informations suivantes et les mettres à jours:
DB_HOST=
DB_NAME=
DB_USER=
DB_PASS=

4.Importer la base de données :
Utiliser phpMyAdmin ou un autre outil pour importer le fichier SQL dans votre base de données MySQL.

5. Lancer le serveur de développement PHP :
php -S localhost:8000

### Utilisation

Pour utiliser l'application, ouvrez votre navigateur et rendez-vous à l'adresse http://localhost:8000.

    Page d'accueil : Présente une introduction et des instructions sur l'utilisation du site.
    Inscription : Permet aux utilisateurs de créer un compte.
    Connexion : Permet aux utilisateurs de se connecter.
    Pronostics : Permet aux utilisateurs connectés de faire des pronostics sur les matchs.
    Classement : Affiche le classement des utilisateurs en fonction de leurs pronostics.
    Admin : Accessible uniquement aux administrateurs pour gérer les matchs et les utilisateurs.

### Licence

Ce projet est distribué sous la licence MIT.

### Contact

Pour plus d'informations ou des questions, vous pouvez contacter Olivier Charlet à olivier.charlet@3wa.io.
