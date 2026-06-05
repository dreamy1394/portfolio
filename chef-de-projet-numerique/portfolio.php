<?php
require_once __DIR__ . '/includes/config.php';
$projects = getAllProjects($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portfolio de réalisations web - Chef de projet numérique">
    <title>Portfolio - <?php echo htmlspecialchars(APP_NAME); ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="/" class="logo"><?php echo htmlspecialchars(APP_NAME); ?></a>
                <ul class="nav-links">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/portfolio.php" class="active">Portfolio</a></li>
                    <li><a href="#contact" class="btn-outline">Me contacter</a></li>
                </ul>
                <button class="hamburger" aria-label="Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </nav>
        </div>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Mon Portfolio</h1>
            <p>Découvrez mes réalisations web et applications digitales</p>
        </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="portfolio-grid">
        <div class="container">
            <?php if (empty($projects)): ?>
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>Aucun projet disponible pour le moment</h3>
                    <p>Revenez bientôt pour découvrir mes nouvelles réalisations !</p>
                </div>
            <?php else: ?>
                <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <div class="project-mockup">
                            <img src="<?php echo htmlspecialchars($project['mockup_path']); ?>" alt="Mockup du projet <?php echo htmlspecialchars($project['title']); ?>" loading="lazy">
                        </div>
                        <div class="project-info">
                            <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                            <p><?php echo htmlspecialchars($project['description']); ?></p>
                            <?php if (!empty($project['url'])): ?>
                                <a href="<?php echo htmlspecialchars($project['url']); ?>" class="btn-primary" target="_blank" rel="noopener noreferrer">Voir le projet</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(APP_NAME); ?>. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="/assets/js/main.js"></script>
</body>
</html>
