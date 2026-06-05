<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';

checkSessionTimeout();

if (!isAuthenticated()) {
    header('Location: /admin/login.php');
    exit;
}

$projects = getAllProjects($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des projets - Administration</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .project-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .project-table th, .project-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .project-table th {
            background-color: var(--light-color);
            font-weight: 600;
        }
        .project-table tr:hover {
            background-color: #f8f9fa;
        }
        .actions a {
            margin-right: 10px;
            color: var(--primary-color);
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
            padding: 8px 15px;
            border-radius: var(--border-radius);
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
        <h1>Liste des projets</h1>
        <a href="/admin/projects/add.php" class="btn-primary">Ajouter un projet</a>

        <table class="project-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($projects)): ?>
                    <tr>
                        <td colspan="3" style="text-align: center;">Aucun projet disponible</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($project['title']); ?></td>
                            <td><?php echo htmlspecialchars(substr($project['description'], 0, 100)) . '...'; ?></td>
                            <td class="actions">
                                <a href="/admin/projects/edit.php?id=<?php echo $project['id']; ?>"><i class="fas fa-edit"></i> Modifier</a>
                                <a href="/admin/projects/delete.php?id=<?php echo $project['id']; ?>" class="btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')"><i class="fas fa-trash"></i> Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
