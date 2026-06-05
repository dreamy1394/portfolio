<?php
require_once __DIR__ . '/includes/config.php';
$homeContent = getHomeContent($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Chef de projet numérique avec 5 ans d'expérience dans la réalisation de sites web et applications digitales">
    <title><?php echo htmlspecialchars($homeContent['title'] ?? APP_NAME); ?></title>
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
                <a href="/" class="logo"><?php echo htmlspecialchars($homeContent['title'] ?? APP_NAME); ?></a>
                <ul class="nav-links">
                    <li><a href="/" class="active">Accueil</a></li>
                    <li><a href="/portfolio.php">Portfolio</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1><?php echo htmlspecialchars($homeContent['hero_title'] ?? 'Chef de projet numérique'); ?></h1>
                <p class="subtitle"><?php echo htmlspecialchars($homeContent['hero_subtitle'] ?? 'Spécialiste en transformation digitale'); ?></p>
                <div class="hero-actions">
                    <a href="#formations" class="btn-primary">Mes formations</a>
                    <a href="#parcours" class="btn-secondary">Mon parcours</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="/assets/images/portrait.jpg" alt="Portrait du chef de projet" width="400" height="500" loading="lazy">
            </div>
        </div>
    </section>

    <!-- Bio Section -->
    <section class="section bio">
        <div class="container">
            <h2>Qui suis-je ?</h2>
            <div class="bio-content">
                <p><?php echo nl2br(htmlspecialchars($homeContent['bio'] ?? 'Je suis un chef de projet numérique avec 5 ans d\'expérience dans la réalisation de sites web et applications digitales.')); ?></p>
            </div>
        </div>
    </section>

    <!-- Formations Section -->
    <section id="formations" class="section">
        <div class="container">
            <h2>Mes formations</h2>
            <div class="formations-grid">
                <?php foreach ($homeContent['formations'] ?? [] as $formation): ?>
                    <div class="formation-card">
                        <h3><?php echo htmlspecialchars($formation['title']); ?></h3>
                        <p class="year"><?php echo htmlspecialchars($formation['year']); ?></p>
                        <p><?php echo htmlspecialchars($formation['description']); ?></p>
                        <?php if (!empty($formation['link'])): ?>
                            <a href="<?php echo htmlspecialchars($formation['link']); ?>" class="btn-link" target="_blank" rel="noopener noreferrer">En savoir plus</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Parcours Section -->
    <section id="parcours" class="section">
        <div class="container">
            <h2>Mon parcours professionnel</h2>
            <div class="timeline">
                <?php foreach ($homeContent['experiences'] ?? [] as $index => $exp): ?>
                    <div class="timeline-item <?php echo $index % 2 === 0 ? 'left' : 'right'; ?>">
                        <div class="timeline-content">
                            <h3><?php echo htmlspecialchars($exp['title']); ?></h3>
                            <p class="company"><?php echo htmlspecialchars($exp['company']); ?> • <?php echo htmlspecialchars($exp['year']); ?></p>
                            <p><?php echo htmlspecialchars($exp['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section contact">
        <div class="container">
            <h2>Me contacter</h2>
            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Par email</h3>
                    <p>Vous pouvez me contacter directement à l'adresse suivante :</p>
                    <a href="mailto:contact@votresite.com" class="btn-primary">contact@votresite.com</a>

                    <h3 class="mt-4">Réseaux sociaux</h3>
                    <div class="social-links">
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="contact-form">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($homeContent['title'] ?? APP_NAME); ?>. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="/assets/js/main.js"></script>
</body>
</html>
