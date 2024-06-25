La Team Pronostics

Une application simple et intuitive pour gérer les pronostics de l'EURO 2024, développée avec PHP pour l'API et un front-end en HTML/CSS/JS.
Fonctionnalités

    Inscription et connexion des utilisateurs
    Faire des pronostics sur les matchs de l'EURO 2024
    Voir les résultats des matchs pronostiquer
    Voir le classement des utilisateurs
    Panel administrateur pour gérer les matchs et les utilisateurs

Technologies utilisées

    Front-end : HTML, CSS (Flexbox), JavaScript
    Back-end : PHP avec PDO pour la gestion de la base de données
    Base de données : MySQL
    Autres : Composer pour la gestion des dépendances, PHP Dotenv pour la gestion des variables d'environnement

Installation et Configuration
Pré-requis

    PHP 8.0.3 ou plus
    MySQL 5.7 ou plus
    Composer

Étapes d'installation

    Cloner le dépôt :

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

CREATE TABLE `matches` (
  `match_id` int(11) NOT NULL,
  `team1_id` int(11) NOT NULL,
  `team2_id` int(11) NOT NULL,
  `match_date` datetime NOT NULL,
  `result_team1` int(11) DEFAULT NULL,
  `result_team2` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `result` enum('1','N','2') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `predictions` (
  `prediction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL,
  `prediction_result` enum('1','N','2') NOT NULL,
  `validated` tinyint(1) DEFAULT '0',
  `correct` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `flag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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

