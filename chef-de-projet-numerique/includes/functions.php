<?php
/**
 * Fonctions utilitaires pour le site
 */

// Fonction pour récupérer le contenu de la page d'accueil
function getHomeContent(PDO $pdo) {
    $stmt = $pdo->query("SELECT * FROM home_content ORDER BY created_at DESC LIMIT 1");
    $home = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$home) {
        return [
            'title' => APP_NAME,
            'hero_title' => 'Chef de projet numérique',
            'hero_subtitle' => 'Spécialiste en transformation digitale',
            'bio' => 'Je suis un chef de projet numérique avec 5 ans d\'expérience dans la réalisation de sites web et applications digitales.',
            'formations' => [],
            'experiences' => []
        ];
    }

    $formations = $pdo->prepare("SELECT * FROM formations WHERE home_content_id = ?");
    $formations->execute([$home['id']]);
    $home['formations'] = $formations->fetchAll(PDO::FETCH_ASSOC);

    $experiences = $pdo->prepare("SELECT * FROM experiences WHERE home_content_id = ?");
    $experiences->execute([$home['id']]);
    $home['experiences'] = $experiences->fetchAll(PDO::FETCH_ASSOC);

    return $home;
}

// Fonction pour récupérer tous les projets
function getAllProjects(PDO $pdo) {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour sécuriser les entrées
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Fonction pour vérifier l'authentification
function isAuthenticated() {
    session_start();
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}
