<?php
try {
    $pdo = new PDO('sqlite:' . DB_PATH);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création des tables si elles n'existent pas
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS home_content (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            hero_title TEXT NOT NULL,
            hero_subtitle TEXT NOT NULL,
            hero_image TEXT,
            bio TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS formations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            year TEXT NOT NULL,
            description TEXT NOT NULL,
            link TEXT,
            home_content_id INTEGER,
            FOREIGN KEY (home_content_id) REFERENCES home_content(id)
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS experiences (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            company TEXT NOT NULL,
            year TEXT NOT NULL,
            description TEXT NOT NULL,
            home_content_id INTEGER,
            FOREIGN KEY (home_content_id) REFERENCES home_content(id)
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS projects (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            description TEXT NOT NULL,
            image_path TEXT NOT NULL,
            mockup_path TEXT,
            url TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
