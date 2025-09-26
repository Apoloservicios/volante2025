<?php
session_start();
require_once '../config/database.php';

// Verificar login
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Volante Lubricentro</title>
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
        .stats-card {
            border-left: 4px solid #ED3237;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
                            <a class="nav-link active" href="dashboard.php">
                                <i class="bi bi-house-door"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blog-posts.php">
                                <i class="bi bi-file-earmark-text"></i> Blog Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="new-post.php">
                                <i class="bi bi-plus-lg"></i> Nuevo Post
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="messages.php">
                                <i class="bi bi-envelope"></i> Mensajes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="settings.php">
                                <i class="bi bi-gear"></i> Configuración
                            </a>
                        </li>
                        <hr class="text-white">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php" target="_blank">
                                <i class="bi bi-box-arrow-up-right"></i> Ver Sitio
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
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="new-post.php" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Nuevo Post
                        </a>
                    </div>
                </div>
                
                <!-- Welcome -->
                <div class="alert alert-info">
                    <i class="bi bi-person-circle me-2"></i>
                    Bienvenido, <strong><?php echo htmlspecialchars($user['username']); ?></strong>!
                </div>
                
                <!-- Stats -->
                <div class="row mb-4">
                    <?php
                    try {
                        $pdo = getDBConnection();
                        
                        // Mensajes nuevos
                        $stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'new'");
                        $new_messages = $stmt->fetchColumn();
                        
                        // Posts publicados
                        $stmt = $pdo->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'");
                        $published_posts = $stmt->fetchColumn();
                        
                        // Mensajes hoy
                        $stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE DATE(created_at) = CURDATE()");
                        $today_messages = $stmt->fetchColumn();
                    } catch (Exception $e) {
                        $new_messages = $published_posts = $today_messages = 0;
                    }
                    ?>
                    
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card stats-card h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Mensajes Nuevos
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold">
                                            <?php echo $new_messages; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-envelope-fill fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card stats-card h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Posts Publicados
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold">
                                            <?php echo $published_posts; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-file-earmark-text-fill fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card stats-card h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Mensajes Hoy
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold">
                                            <?php echo $today_messages; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-chat-dots-fill fa-2x text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones Rápidas -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-lightning-charge me-2"></i>Acciones Rápidas
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="new-post.php" class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-2"></i>Crear Nuevo Post
                                    </a>
                                    <a href="blog-posts.php" class="btn btn-outline-primary">
                                        <i class="bi bi-list-ul me-2"></i>Gestionar Posts
                                    </a>
                                    <a href="messages.php" class="btn btn-outline-success">
                                        <i class="bi bi-envelope me-2"></i>Ver Mensajes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-info-circle me-2"></i>Estado del Sistema
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <small class="text-muted">Base de Datos:</small>
                                    <span class="float-end text-success">Conectada</span>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">PHP Version:</small>
                                    <span class="float-end"><?php echo phpversion(); ?></span>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Modo Debug:</small>
                                    <span class="float-end <?php echo DEBUG_MODE ? 'text-warning' : 'text-success'; ?>">
                                        <?php echo DEBUG_MODE ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Último acceso:</small>
                                    <span class="float-end"><?php echo formatDate($user['last_login'], 'd/m H:i'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>