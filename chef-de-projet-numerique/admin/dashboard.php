<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

checkSessionTimeout();

if (!isAuthenticated()) {
    header('Location: /admin/login.php');
    exit;
}

$homeContent = getHomeContent($pdo);
$projects = getAllProjects($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administration</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            margin-bottom: 40px;
        }
        .admin-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .admin-nav a {
            color: white;
        }
        .admin-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            margin-bottom: 30px;
        }
        .card h3 {
            margin-bottom: 20px;
            color: var(--primary-color);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-card {
            background-color: var(--light-color);
            padding: 25px;
            border-radius: var(--border-radius);
            text-align: center;
        }
        .stat-card i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        .stat-card h4 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-nav">
            <a href="/admin/dashboard.php" class="logo">Administration</a>
            <div>
                <a href="/admin/logout.php" class="btn-outline" style="color: white; border-color: white;">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="admin-content">
        <h1>Tableau de bord</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-file-alt"></i>
                <h4><?php echo count($homeContent['formations'] ?? []); ?></h4>
                <p>Formations</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-briefcase"></i>
                <h4><?php echo count($homeContent['experiences'] ?? []); ?></h4>
                <p>Expériences</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-project-diagram"></i>
                <h4><?php echo count($projects); ?></h4>
                <p>Projets</p>
            </div>
        </div>

        <div class="card">
            <h3>Contenu de la page d'accueil</h3>
            <p>Titre : <?php echo htmlspecialchars($homeContent['title'] ?? 'Non défini'); ?></p>
            <p>Sous-titre : <?php echo htmlspecialchars($homeContent['hero_subtitle'] ?? 'Non défini'); ?></p>
            <a href="/admin/pages/home-edit.php" class="btn-primary">Modifier</a>
        </div>

        <div class="card">
            <h3>Gestion des projets</h3>
            <a href="/admin/projects/add.php" class="btn-primary">Ajouter un projet</a>
            <a href="/admin/projects/list.php" class="btn-secondary" style="margin-left: 15px;">Voir tous les projets</a>
        </div>
    </div>
</body>
</html>
