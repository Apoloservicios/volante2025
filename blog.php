<?php
require_once 'config/database.php';

// Paginación
$page = max(1, intval($_GET['page'] ?? 1));
$posts_per_page = 6;
$offset = ($page - 1) * $posts_per_page;

try {
    $pdo = getDBConnection();
    
    // Contar posts totales
    $count_stmt = $pdo->prepare("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'");
    $count_stmt->execute();
    $total_posts = $count_stmt->fetchColumn();
    
    $total_pages = ceil($total_posts / $posts_per_page);
    
    // Obtener posts de la página actual
    $stmt = $pdo->prepare("
        SELECT id, title, slug, excerpt, author, published_at, views 
        FROM blog_posts 
        WHERE status = 'published' 
        ORDER BY published_at DESC 
        LIMIT ? OFFSET ?
    ");
    $stmt->execute([$posts_per_page, $offset]);
    $posts = $stmt->fetchAll();
    
} catch (Exception $e) {
    $posts = [];
    $total_pages = 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Automotriz - Volante Lubricentro</title>
    <meta name="description" content="Consejos, tips y noticias sobre mantenimiento automotriz. Blog de Volante Lubricentro.">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Hero Section Blog -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Blog Automotriz</h1>
                    <p class="lead mb-4">Consejos, tips y noticias para mantener tu vehículo en perfectas condiciones</p>
                </div>
                <div class="col-lg-4 text-center">
                    <img src="img/iconos/blog_icon.svg" alt="Blog" class="img-fluid" style="max-width: 200px;">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Blog Posts -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <?php if (empty($posts)): ?>
                    <div class="col-12 text-center">
                        <div class="py-5">
                            <i class="bi bi-file-earmark-text display-1 text-muted"></i>
                            <h3 class="mt-3">No hay posts disponibles</h3>
                            <p class="text-muted">Pronto publicaremos contenido interesante sobre el mundo automotriz.</p>
                            <a href="index.php" class="btn btn-primary">Volver al Inicio</a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                            <article class="card blog-card h-100">
                                <div class="blog-image">
                                    <img src="img/blog/default-blog.jpg" alt="<?php echo htmlspecialchars($post['title']); ?>" 
                                         class="card-img-top" onerror="this.src='img/producto/producto_no_disponible.svg'">
                                    <div class="blog-category">Automotriz</div>
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                                    
                                    <p class="card-text text-muted flex-grow-1">
                                        <?php echo htmlspecialchars($post['excerpt']); ?>
                                    </p>
                                    
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <small class="text-muted">
                                                <i class="bi bi-person-fill me-1"></i>
                                                <?php echo htmlspecialchars($post['author']); ?>
                                            </small>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                <?php echo formatDateSpanish($post['published_at']); ?>
                                            </small>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="blog-post.php?slug=<?php echo urlencode($post['slug']); ?>" 
                                               class="btn btn-primary btn-sm">
                                                Leer más <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                            <small class="text-muted">
                                                <i class="bi bi-eye me-1"></i>
                                                <?php echo number_format($post['views']); ?> vistas
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Paginación -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Navegación del blog" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                                    <i class="bi bi-chevron-left"></i> Anterior
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                                    Siguiente <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Página <?php echo $page; ?> de <?php echo $total_pages; ?> 
                            (<?php echo $total_posts; ?> posts en total)
                        </small>
                    </div>
                </nav>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h3 class="mb-3">¿Necesitas asesoramiento personalizado?</h3>
                    <p class="lead text-muted mb-4">
                        Nuestros expertos están listos para ayudarte con cualquier consulta sobre el mantenimiento de tu vehículo
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="#contacto" class="btn btn-primary">
                            <i class="bi bi-envelope me-2"></i>Contactar
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=5492604349002&text=Hola%21%20Necesito%20asesoramiento%20técnico" 
                           class="btn btn-success" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp
                        </a>
                        <a href="tel:+5492604349002" class="btn btn-outline-primary">
                            <i class="bi bi-telephone me-2"></i>Llamar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <!-- WhatsApp Widget -->
    <?php include 'includes/whatsapp-widget.php'; ?>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="js/main.js"></script>
    
    <script>
        // Inicializar AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out-quart',
            once: true
        });
    </script>
</body>
</html>