<section id="contacto" class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Contactanos</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    ¿Tienes alguna consulta? Estamos aquí para ayudarte
                </p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="contact-form-wrapper" data-aos="fade-up" data-aos-delay="200">
                    
                    <!-- Mostrar mensajes -->
                    <div id="alertPlaceholder">
                        <?php if (isset($_SESSION['contact_success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <?php echo $_SESSION['contact_success']; unset($_SESSION['contact_success']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['contact_error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?php echo $_SESSION['contact_error']; unset($_SESSION['contact_error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['contact_errors'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <ul class="mb-0">
                                    <?php foreach ($_SESSION['contact_errors'] as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['contact_errors']); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="text-center mb-4">
                        <h3>Escribenos y hazte cliente</h3>
                        <p>Accede a nuestra plataforma de precios mayoristas</p>
                    </div>
                    
                    <form id="contactForm" action="contact/contact-handler.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre Completo *</label>
                                <input type="text" class="form-control" id="name" name="name" required maxlength="100">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+54 260 XXX-XXXX">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="msg_subject" class="form-label">Asunto *</label>
                                <select class="form-select" id="msg_subject" name="msg_subject" required>
                                    <option value="">Selecciona un asunto</option>
                                    <option value="Consulta General">Consulta General</option>
                                    <option value="Precios Mayoristas">Precios Mayoristas</option>
                                    <option value="Productos">Consulta sobre Productos</option>
                                    <option value="Servicios">Consulta sobre Servicios</option>
                                    <option value="Envíos">Consulta sobre Envíos</option>
                                    <option value="Reclamo">Reclamo o Sugerencia</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            
                            <div class="col-12">
                                <label for="message" class="form-label">Mensaje *</label>
                                <textarea class="form-control" id="message" name="message" rows="6" required maxlength="2000" 
                                          placeholder="Cuéntanos qué necesitas..."></textarea>
                                <div class="form-text">Máximo 2000 caracteres</div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="privacy" required>
                                    <label class="form-check-label" for="privacy">
                                        Acepto que mis datos sean utilizados para responder mi consulta *
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-send me-2"></i>Enviar Mensaje
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Información de contacto -->
                    <div class="contact-info-grid mt-5">
                        <div class="row g-4">
                            <div class="col-md-4 text-center">
                                <div class="contact-info-item">
                                    <i class="bi bi-geo-alt-fill text-primary fs-2 mb-3"></i>
                                    <h5>Dirección</h5>
                                    <p>Patricias Mendocinas 370<br>San Rafael - Mendoza</p>
                                </div>
                            </div>
                            
                            <div class="col-md-4 text-center">
                                <div class="contact-info-item">
                                    <i class="bi bi-telephone-fill text-primary fs-2 mb-3"></i>
                                    <h5>Teléfono</h5>
                                    <p><a href="tel:+542604349002" class="text-decoration-none">(260) 434-9002</a></p>
                                </div>
                            </div>
                            
                            <div class="col-md-4 text-center">
                                <div class="contact-info-item">
                                    <i class="bi bi-envelope-fill text-primary fs-2 mb-3"></i>
                                    <h5>Email</h5>
                                    <p><a href="mailto:ventas@volante.com.ar" class="text-decoration-none">ventas@volante.com.ar</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CSS adicional para contacto -->
<style>
.contact-section {
    background: var(--gray-light);
    padding: 80px 0;
}

.contact-form-wrapper {
    background: white;
    padding: 3rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
}

.contact-info-item {
    padding: 2rem 1rem;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    transition: var(--transition);
    height: 100%;
}

.contact-info-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(237, 50, 55, 0.25);
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
</style>