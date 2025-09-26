<?php
session_start();
require_once '../config/database.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title'] ?? '');
    $content = $_POST['content'] ?? ''; // No sanitizar contenido HTML
    $excerpt = sanitizeInput($_POST['excerpt'] ?? '');
    $status = sanitizeInput($_POST['status'] ?? 'draft');
    $author = getCurrentUser()['username'];
    
    if (empty($title) || empty($content)) {
        $error = 'Título y contenido son obligatorios.';
    } else {
        try {
            $pdo = getDBConnection();
            
            // Generar slug único
            $slug = generateSlug($title);
            $original_slug = $slug;
            $counter = 1;
            
            while (true) {
                $stmt = $pdo->prepare("SELECT id FROM blog_posts WHERE slug = ?");
                $stmt->execute([$slug]);
                if (!$stmt->fetch()) break;
                
                $slug = $original_slug . '-' . $counter;
                $counter++;
            }
            
            // Si no hay excerpt, crear uno automáticamente
            if (empty($excerpt)) {
                $excerpt = substr(strip_tags($content), 0, 150) . '...';
            }
            
            $sql = "INSERT INTO blog_posts (title, slug, content, excerpt, status, author, created_at, published_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
            
            $published_at = ($status === 'published') ? date('Y-m-d H:i:s') : null;
            
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$title, $slug, $content, $excerpt, $status, $author, $published_at]);
            
            if ($result) {
                $success = 'Post creado exitosamente!';
                // Limpiar formulario
                $_POST = [];
            } else {
                $error = 'Error al crear el post.';
            }
            
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Post - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Editor de texto enriquecido -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    
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
                            <a class="nav-link" href="blog-posts.php">
                                <i class="bi bi-file-earmark-text"></i> Blog Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="new-post.php">
                                <i class="bi bi-plus-lg"></i> Nuevo Post
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="messages.php">
                                <i class="bi bi-envelope"></i> Mensajes
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
                    <h1 class="h2">Crear Nuevo Post</h1>
                    <a href="blog-posts.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver a Posts
                    </a>
                </div>
                
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Contenido del Post</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Título *</label>
                                        <input type="text" class="form-control" id="title" name="title" 
                                               value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" 
                                               required maxlength="200">
                                        <div class="invalid-feedback">
                                            Por favor ingresa un título.
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="excerpt" class="form-label">Resumen</label>
                                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" 
                                                  maxlength="500" placeholder="Resumen del post (opcional - se generará automáticamente si se deja vacío)"><?php echo htmlspecialchars($_POST['excerpt'] ?? ''); ?></textarea>
                                        <div class="form-text">Máximo 500 caracteres</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Contenido *</label>
                                        <textarea class="form-control" id="content" name="content" rows="15" required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                                        <div class="invalid-feedback">
                                            Por favor ingresa el contenido del post.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Opciones de Publicación</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Estado</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="draft" <?php echo ($_POST['status'] ?? '') === 'draft' ? 'selected' : ''; ?>>
                                                Borrador
                                            </option>
                                            <option value="published" <?php echo ($_POST['status'] ?? '') === 'published' ? 'selected' : ''; ?>>
                                                Publicado
                                            </option>
                                        </select>
                                        <div class="form-text">Los borradores no se muestran en el sitio web</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Autor</label>
                                        <input type="text" class="form-control" 
                                               value="<?php echo htmlspecialchars(getCurrentUser()['username']); ?>" 
                                               readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Vista previa del slug</label>
                                        <div class="form-control bg-light" id="slug-preview">
                                            <small class="text-muted">Se generará automáticamente</small>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> Guardar Post
                                        </button>
                                        <a href="blog-posts.php" class="btn btn-outline-secondary">
                                            <i class="bi bi-x"></i> Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Ayuda -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="bi bi-info-circle"></i> Ayuda
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <small>
                                        <strong>Consejos:</strong><br>
                                        • Usa títulos descriptivos<br>
                                        • El resumen aparece en la página principal<br>
                                        • Puedes usar HTML básico en el contenido<br>
                                        • Los borradores se pueden editar después
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Inicializar TinyMCE para editor de texto enriquecido
        tinymce.init({
            selector: '#content',
            height: 400,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            language: 'es',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; line-height: 1.4; }',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
        
        // Generar slug en tiempo real
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = generateSlug(title);
            const preview = document.getElementById('slug-preview');
            
            if (title.length > 0) {
                preview.innerHTML = '<small class="text-primary">/blog/' + slug + '</small>';
            } else {
                preview.innerHTML = '<small class="text-muted">Se generará automáticamente</small>';
            }
        });
        
        function generateSlug(str) {
            return str
                .toLowerCase()
                .trim()
                .replace(/[áàäâã]/g, 'a')
                .replace(/[éèëê]/g, 'e')
                .replace(/[íìïî]/g, 'i')
                .replace(/[óòöôõ]/g, 'o')
                .replace(/[úùüû]/g, 'u')
                .replace(/ñ/g, 'n')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .substring(0, 100);
        }
        
        // Validación del formulario
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        
        // Contador de caracteres para el resumen
        const excerptTextarea = document.getElementById('excerpt');
        if (excerptTextarea) {
            const maxLength = 500;
            const counterDiv = document.createElement('div');
            counterDiv.className = 'form-text text-end';
            excerptTextarea.parentNode.appendChild(counterDiv);
            
            function updateCounter() {
                const remaining = maxLength - excerptTextarea.value.length;
                counterDiv.innerHTML = `<small>${excerptTextarea.value.length}/${maxLength} caracteres</small>`;
                
                if (remaining < 50) {
                    counterDiv.className = 'form-text text-end text-warning';
                } else {
                    counterDiv.className = 'form-text text-end text-muted';
                }
            }
            
            excerptTextarea.addEventListener('input', updateCounter);
            updateCounter();
        }
    </script>
</body>
</html>