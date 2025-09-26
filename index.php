<?php
// Iniciar sesión para manejo de mensajes
session_start();

// Incluir configuración si existe
if (file_exists('config/database.php')) {
    require_once 'config/database.php';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volante Lubricentro | Más de 20 años cuidando tu vehículo - San Rafael, Mendoza</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Lubricentro Volante en San Rafael, Mendoza. Más de 20 años de experiencia. Aceites, filtros, lubricantes, refrigerantes. Envíos a todo el país. Precios mayoristas.">
    <meta name="keywords" content="lubricentro, aceites, filtros, San Rafael, Mendoza, lubricantes, refrigerantes, cambio aceite, precios mayoristas">
    <meta name="author" content="Volante Lubricentro">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Volante Lubricentro - San Rafael, Mendoza">
    <meta property="og:description" content="Más de 20 años cuidando tu vehículo. Aceites, filtros y lubricantes de primera calidad.">
    <meta property="og:image" content="https://volante.com.ar/img/logo/logo_volante.svg">
    <meta property="og:url" content="https://volante.com.ar">
    <meta property="og:type" content="business.business">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    
    <!-- Schema Markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AutoRepair",
        "name": "Volante Lubricentro",
        "description": "Lubricentro especializado en aceites, filtros y lubricantes automotrices",
        "url": "https://volante.com.ar",
        "telephone": "(260) 434-9002",
        "email": "ventas@volante.com.ar",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Patricias Mendocinas 370",
            "addressLocality": "San Rafael",
            "addressRegion": "Mendoza",
            "postalCode": "5600",
            "addressCountry": "AR"
        },
        "openingHours": ["Mo-Fr 08:00-18:00", "Sa 08:00-13:00"],
        "priceRange": "$$",
        "areaServed": "Argentina"
    }
    </script>
</head>

<body>
    <!-- Loading Screen -->
    <div class="loader" id="loader" style="display: none;">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    </div>

    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section con Carousel Funcional -->
    <section id="inicio" class="hero-section">
        <div id="heroCarousel" class="carousel slide carousel-fade h-100" data-bs-ride="carousel" data-bs-interval="6000">
            
            <!-- Indicadores -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            
            <div class="carousel-inner h-100">
                <!-- Slide 1: Lubricentro de Confianza -->
                <div class="carousel-item active h-100">
                    <div class="hero-bg" style="background-image: linear-gradient(135deg, #ED3237 0%, #c02328 100%);"></div>
                    <div class="hero-overlay"></div>
                    <div class="container h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-7">
                                <div class="hero-content" data-aos="fade-up">
                                    <h1 class="hero-title">Tu Lubricentro de <span class="text-warning">Confianza</span></h1>
                                    <p class="hero-subtitle">Más de 20 años cuidando tu vehículo con productos de primera calidad y atención personalizada en San Rafael, Mendoza.</p>
                                    <div class="hero-buttons">
                                        <a href="#contacto" class="btn btn-warning btn-lg me-3">
                                            <i class="bi bi-telephone-fill me-2"></i>Contactar Ahora
                                        </a>
                                        <a href="#servicios" class="btn btn-outline-light btn-lg">
                                            <i class="bi bi-arrow-down me-2"></i>Ver Servicios
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 text-center d-none d-lg-block">
                                <img src="img/logo/gota_volante.svg" alt="Volante Logo" class="hero-logo" data-aos="zoom-in" data-aos-delay="300">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 2: Precios Mayoristas -->
                <div class="carousel-item h-100">
                    <div class="hero-bg" style="background-image: linear-gradient(135deg, #2A7BBE 0%, #1e5a8a 100%);"></div>
                    <div class="hero-overlay"></div>
                    <div class="container h-100">
                        <div class="row align-items-center h-100 text-center">
                            <div class="col-12">
                                <div class="hero-content" data-aos="fade-up">
                                    <h1 class="hero-title">Precios <span class="text-warning">Mayoristas</span></h1>
                                    <p class="hero-subtitle">¿Tienes un lubricentro? Accede a nuestros precios especiales para mayoristas. La mejor calidad al mejor precio del mercado.</p>
                                    <div class="hero-buttons">
                                        <a href="https://api.whatsapp.com/send?phone=5492604349002&text=Hola%21%20Quiero%20informaci%C3%B3n%20sobre%20precios%20mayoristas" target="_blank" class="btn btn-success btn-lg">
                                            <i class="bi bi-whatsapp me-2"></i>Solicitar Precios
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 3: Envíos Nacionales -->
                <div class="carousel-item h-100">
                    <div class="hero-bg" style="background-image: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);"></div>
                    <div class="hero-overlay"></div>
                    <div class="container h-100">
                        <div class="row align-items-center h-100 text-center">
                            <div class="col-12">
                                <div class="hero-content" data-aos="fade-up">
                                    <h1 class="hero-title">Envíos a <span class="text-warning">Todo el País</span></h1>
                                    <p class="hero-subtitle">Llegamos donde estés con nuestro sistema de envíos rápido y seguro. Tu vehículo merece lo mejor sin importar tu ubicación.</p>
                                    <div class="hero-buttons">
                                        <a href="#servicios" class="btn btn-light btn-lg">
                                            <i class="bi bi-truck me-2"></i>Ver Cobertura
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Controles del carousel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </section>

    <!-- Sección de Información Rápida -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="img/iconos/envios_m0_r.svg" alt="Envíos" width="40" class="me-3">
                        <div class="text-start">
                            <h6 class="mb-0 fw-bold">Envíos Nacionales</h6>
                            <small class="text-muted">Rápidos y seguros</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="img/iconos/confianza_m0_r.svg" alt="Experiencia" width="40" class="me-3">
                        <div class="text-start">
                            <h6 class="mb-0 fw-bold">+20 Años Experiencia</h6>
                            <small class="text-muted">Calidad garantizada</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="img/iconos/atencion_m0_r.svg" alt="Atención" width="40" class="me-3">
                        <div class="text-start">
                            <h6 class="mb-0 fw-bold">Atención Personalizada</h6>
                            <small class="text-muted">Asesoramiento experto</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <?php include 'includes/info-services.php'; ?>
    
    <!-- Productos -->
    <?php include 'includes/productos.php'; ?>
    
    <!-- Blog Preview -->
    <section class="blog-preview section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title" data-aos="fade-up">Blog Automotriz</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        Consejos y tips para mantener tu vehículo en perfectas condiciones
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <article class="blog-card">
                        <div class="blog-image">
                            <img src="img/producto/producto_no_disponible.svg" alt="Cuándo cambiar el aceite" class="img-fluid">
                            <div class="blog-category">Mantenimiento</div>
                        </div>
                        <div class="blog-content">
                            <h3>¿Cuándo cambiar el aceite de tu auto?</h3>
                            <p>Aprende a identificar las señales que te indican cuándo es momento de cambiar el aceite de tu vehículo...</p>
                            <a href="blog.php" class="btn btn-outline-primary btn-sm">Leer más</a>
                        </div>
                    </article>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <article class="blog-card">
                        <div class="blog-image">
                            <img src="img/producto/producto_no_disponible.svg" alt="Filtros de auto" class="img-fluid">
                            <div class="blog-category">Filtros</div>
                        </div>
                        <div class="blog-content">
                            <h3>Importancia de los filtros en tu vehículo</h3>
                            <p>Descubre por qué los filtros son fundamentales para el buen funcionamiento de tu auto...</p>
                            <a href="blog.php" class="btn btn-outline-primary btn-sm">Leer más</a>
                        </div>
                    </article>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <article class="blog-card">
                        <div class="blog-image">
                            <img src="img/producto/producto_no_disponible.svg" alt="Refrigerante auto" class="img-fluid">
                            <div class="blog-category">Refrigeración</div>
                        </div>
                        <div class="blog-content">
                            <h3>Sistema de refrigeración: clave en verano</h3>
                            <p>Todo lo que necesitas saber sobre el mantenimiento del sistema de refrigeración...</p>
                            <a href="blog.php" class="btn btn-outline-primary btn-sm">Leer más</a>
                        </div>
                    </article>
                </div>
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="blog.php" class="btn btn-primary">Ver Todos los Artículos</a>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <?php include 'includes/contact-section.php'; ?>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- WhatsApp Button -->
    <?php include 'includes/whatsapp-widget.php'; ?>

    <!-- Back to Top Button -->
    <a href="#inicio" class="back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="js/main.js"></script>
    
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GA_MEASUREMENT_ID');
    </script>
</body>
</html>