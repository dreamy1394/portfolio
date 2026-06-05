<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';

checkSessionTimeout();

if (!isAuthenticated()) {
    header('Location: /admin/login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    $url = sanitizeInput($_POST['url'] ?? '');

    // Upload de l'image
    $imagePath = '';
    $mockupPath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = ASSETS_PATH . '/images/projects/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'project_' . time() . '.' . $ext;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $imagePath = '/assets/images/projects/' . $filename;
        } else {
            $error = 'Erreur lors du téléchargement de l\'image';
        }
    }

    if (isset($_FILES['mockup']) && $_FILES['mockup']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = ASSETS_PATH . '/images/mockups/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($_FILES['mockup']['name'], PATHINFO_EXTENSION);
        $filename = 'mockup_' . time() . '.' . $ext;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['mockup']['tmp_name'], $destination)) {
            $mockupPath = '/assets/images/mockups/' . $filename;
        } else {
            $error = 'Erreur lors du téléchargement du mockup';
        }
    }

    if (empty($error) && !empty($title) && !empty($imagePath)) {
        $stmt = $pdo->prepare("INSERT INTO projects (title, description, image_path, mockup_path, url) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $description, $imagePath, $mockupPath, $url])) {
            $success = 'Projet ajouté avec succès !';
            // Réinitialiser les champs
            $title = $description = $url = '';
        } else {
            $error = 'Erreur lors de l\'ajout du projet';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un projet - Administration</title>
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
        .admin-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-family: inherit;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }
        .preview {
            margin-top: 20px;
            border: 1px dashed #ddd;
            padding: 20px;
            text-align: center;
            border-radius: var(--border-radius);
        }
        .preview img {
            max-width: 100%;
            max-height: 300px;
        }
        .error-message {
            color: var(--danger-color);
            background-color: #f8d7da;
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }
        .success-message {
            color: var(--success-color);
            background-color: #d4edda;
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
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
        <h1>Ajouter un projet</h1>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Titre du projet</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image du projet (capture d'écran)</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                <div class="preview">
                    <p>Prévisualisation de l'image (optionnel)</p>
                    <img id="image-preview" src="#" alt="Prévisualisation" style="display: none;">
                </div>
            </div>

            <div class="form-group">
                <label for="mockup">Mockup du site (fichier image)</label>
                <input type="file" id="mockup" name="mockup" accept="image/*">
                <div class="preview">
                    <p>Prévisualisation du mockup (optionnel)</p>
                    <img id="mockup-preview" src="#" alt="Prévisualisation" style="display: none;">
                </div>
            </div>

            <div class="form-group">
                <label for="url">URL du projet (si en ligne)</label>
                <input type="url" id="url" name="url" value="<?php echo htmlspecialchars($url ?? ''); ?>">
            </div>

            <button type="submit" class="btn btn-primary">Ajouter le projet</button>
            <a href="/admin/projects/list.php" class="btn-secondary" style="margin-left: 15px;">Annuler</a>
        </form>
    </div>

    <script>
        // Prévisualisation de l'image
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Prévisualisation du mockup
        document.getElementById('mockup').addEventListener('change', function(e) {
            const preview = document.getElementById('mockup-preview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
</body>
</html>
