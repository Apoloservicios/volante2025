<?php
session_start();
require_once '../config/database.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Obtener posts
try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("
        SELECT id, title, slug, status, author, views, created_at, published_at 
        FROM blog_posts 
        ORDER BY created_at DESC
    ");
    $stmt->execute();
    $posts = $stmt->fetchAll();
} catch (Exception $e) {
    $posts = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Posts - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #2A7BBE, #1e5a8a);
            min-height: 100vh;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 0;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white !important;
        }
        .status-badge {
            font-size: 0.75rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <img src="../img/logo/logo_volante_blanco.svg" alt="Logo" style="max-width: 120px;">
                        <h6 class="text-white mt-2">Panel Admin</h6>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="bi bi-house-door"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="blog-posts.php">
                                <i class="bi bi-file-earmark-text"></i> Blog Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="new-post.php">
                                <i class="bi bi-plus-lg"></i> Nuevo Post
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Gestionar Posts del Blog</h1>
                    <a href="new-post.php" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Nuevo Post
                    </a>
                </div>
                
                <?php if (empty($posts)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-file-earmark-text display-1 text-muted"></i>
                        <h4 class="mt-3">No hay posts creados</h4>
                        <p class="text-muted">Comienza creando tu primer post del blog</p>
                        <a href="new-post.php" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Crear Primer Post
                        </a>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Estado</th>
                                            <th>Autor</th>
                                            <th>Vistas</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($posts as $post): ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        Slug: <?php echo htmlspecialchars($post['slug']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <?php if ($post['status'] === 'published'): ?>
                                                        <span class="badge bg-success status-badge">Publicado</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning status-badge">Borrador</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($post['author']); ?></td>
                                                <td>
                                                    <i class="bi bi-eye me-1"></i>
                                                    <?php echo number_format($post['views']); ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo formatDate($post['created_at'], 'd/m/Y'); ?>
                                                        <?php if ($post['published_at']): ?>
                                                            <br><span class="text-success">Publicado: <?php echo formatDate($post['published_at'], 'd/m/Y'); ?></span>
                                                        <?php endif; ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <?php if ($post['status'] === 'published'): ?>
                                                            <a href="../blog-post.php?slug=<?php echo urlencode($post['slug']); ?>" 
                                                               class="btn btn-outline-primary" target="_blank" title="Ver post">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <a href="edit-post.php?id=<?php echo $post['id']; ?>" 
                                                           class="btn btn-outline-secondary" title="Editar">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <button class="btn btn-outline-danger" 
                                                                onclick="deletePost(<?php echo $post['id']; ?>, '<?php echo htmlspecialchars($post['title']); ?>')" 
                                                                title="Eliminar">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Posts Publicados</h5>
                                        <h3 class="text-success">
                                            <?php echo count(array_filter($posts, function($p) { return $p['status'] === 'published'; })); ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Borradores</h5>
                                        <h3 class="text-warning">
                                            <?php echo count(array_filter($posts, function($p) { return $p['status'] === 'draft'; })); ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function deletePost(id, title) {
            if (confirm(`¿Estás seguro de que quieres eliminar el post "${title}"?\n\nEsta acción no se puede deshacer.`)) {
                // Aquí implementarías la eliminación via AJAX
                fetch('delete-post.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({id: id})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar el post: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error de conexión: ' + error);
                });
            }
        }
    </script>
</body>
</html>