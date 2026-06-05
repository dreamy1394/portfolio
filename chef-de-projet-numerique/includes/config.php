<?php
// Configuration de base
define('APP_NAME', 'Chef de projet numérique');
define('ADMIN_EMAIL', 'admin@votresite.com');
define('ADMIN_PASSWORD', password_hash('votre_mot_de_passe_securise', PASSWORD_DEFAULT)); // Changez ce mot de passe !

// Chemins
define('ROOT_PATH', __DIR__ . '/..');
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('ADMIN_PATH', ROOT_PATH . '/admin');

// Base de données
define('DB_PATH', ROOT_PATH . '/db.sqlite');

// Initialisation de la base de données
require_once __DIR__ . '/database.php';

// Fonctions utilitaires
require_once __DIR__ . '/functions.php';
