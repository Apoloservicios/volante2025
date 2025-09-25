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
    
    <!-- Favicon - MANTENER TUS ACTUALES -->
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    
    <!-- Schema Markup       "url": "https://volante.com.ar",      -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AutoRepair",
        "name": "Volante Lubricentro",
        "description": "Lubricentro especializado en aceites, filtros y lubricantes automotrices",
        "url": " http://localhost/volante2025/",
       
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
    <!-- USAR TU HEADER ACTUAL MEJORADO -->
    <?php include 'includes/header.php'; ?>
    
    <!-- USAR TU MENÚ ACTUAL MEJORADO -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section con slider mejorado -->
    <section id="inicio" class="hero-section">
        <div id="heroCarousel" class="carousel slide carousel-fade h-100" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            
            <div class="carousel-inner h-100">
                <!-- Slide 1 -->
                <div class="carousel-item active h-100">
                    <div class="hero-bg" style="background-image: url('img/slider/slide1.jpg ');"></div>
                     <img src="img/slider/slider3.webp" class="d-block w-100" alt="...">
                    <div class="hero-overlay"></div>
                    <div class="container h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-7">
                                <div class="hero-content" data-aos="fade-up">
                                    <h1 class="hero-title">Tu Lubricentro de <span class="text-primary">Confianza</span></h1>
                                    <p class="hero-subtitle">Más de 20 años cuidando tu vehículo con productos de primera calidad y atención personalizada en San Rafael, Mendoza.</p>
                                    <div class="hero-buttons">
                                        <a href="#contacto" class="btn btn-primary btn-lg me-3">
                                            <i class="bi bi-telephone me-2"></i>Contactar Ahora
                                        </a>
                                        <a href="#servicios" class="btn btn-outline-light btn-lg">
                                            Ver Servicios
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 text-center d-none d-lg-block">
                                <!-- USAR TU LOGO ACTUAL -->
                                <img src="img/logo/gota_volante.svg" alt="Volante" class="hero-logo" data-aos="zoom-in" data-aos-delay="300">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="carousel-item h-100">
                    <div class="hero-bg" style="background-image: url('/img/slider/slide2.jpg');"></div>
                    <div class="hero-overlay"></div>
                    <div class="container h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-8 mx-auto text-center">
                                <div class="hero-content" data-aos="fade-up">
                                    <h1 class="hero-title">Precios <span class="text-primary">Mayoristas</span></h1>
                                    <p class="hero-subtitle">¿Tienes un lubricentro? Accede a nuestros precios especiales para mayoristas. La mejor calidad al mejor precio.</p>
                                    <div class="hero-buttons">
                                        <a href="#contacto" class="btn btn-primary btn-lg">
                                            <i class="bi bi-whatsapp me-2"></i>Solicitar Precios
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 3 -->
                <div class="carousel-item h-100">
                    <div class="hero-bg" style="background-image: url('img/slider/slide3.jpg');"></div>
                    <div class="hero-overlay"></div>
                    <div class="container h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-8 mx-auto text-center">
                                <div class="hero-content" data-aos="fade-up">
                                    <h1 class="hero-title">Envíos a <span class="text-primary">Todo el País</span></h1>
                                    <p class="hero-subtitle">Llegamos donde estés con nuestro sistema de envíos rápido y seguro. Tu vehículo merece lo mejor.</p>
                                    <div class="hero-buttons">
                                        <a href="#servicios" class="btn btn-primary btn-lg">
                                            <i class="bi bi-truck me-2"></i>Ver Cobertura
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- USAR TU SECCIÓN DE SERVICIOS MEJORADA -->
    <?php include 'includes/info-services.php'; ?>
    
    <!-- USAR TU SECCIÓN DE PRODUCTOS MEJORADA -->
    <?php include 'includes/productos.php'; ?>
    
    <!-- Nueva sección de blog -->
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
                <!-- Aquí se cargarían los últimos 3 posts del blog dinámicamente -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <article class="blog-card">
                        <div class="blog-image">
                            <img src="img/blog/cambio-aceite.jpg" alt="Cuándo cambiar el aceite" class="img-fluid">
                            <div class="blog-category">Mantenimiento</div>
                        </div>
                        <div class="blog-content">
                            <h3>¿Cuándo cambiar el aceite de tu auto?</h3>
                            <p>Aprende a identificar las señales que te indican cuándo es momento de cambiar el aceite...</p>
                            <a href="blog-post.php?slug=cuando-cambiar-aceite" class="btn btn-outline-primary btn-sm">Leer más</a>
                        </div>
                    </article>
                </div>
                
                <!-- Repetir para 2 posts más -->
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="blog.php" class="btn btn-primary">Ver Todos los Artículos</a>
            </div>
        </div>
    </section>

    <!-- USAR TU SECCIÓN DE CONTACTO MEJORADA -->
    <?php include 'includes/contact-section.php'; ?>

    <!-- USAR TU FOOTER ACTUAL MEJORADO -->
    <?php include 'includes/footer.php'; ?>

    <!-- WhatsApp Widget Multi-contacto -->
    <?php include 'includes/whatsapp-widget.php'; ?>

    <!-- Back to Top -->
    <a href="#inicio" class="back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="js/main.js"></script>
    
    <!-- Google Analytics - REEMPLAZAR CON TU ID -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GA_MEASUREMENT_ID');
    </script>
</body>
</html>