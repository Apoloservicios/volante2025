/**
 * VOLANTE LUBRICENTRO - JAVASCRIPT PRINCIPAL
 * Funcionalidades del sitio web
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Volante Lubricentro - Iniciando scripts...');
    
    // ===========================
    // VARIABLES GLOBALES
    // ===========================
    const navbar = document.querySelector('.navbar');
    const backToTop = document.querySelector('.back-to-top');
    const whatsappBtn = document.querySelector('.whatsapp-float');
    
    // ===========================
    // NAVBAR SCROLL EFFECT
    // ===========================
    function handleNavbarScroll() {
        if (window.scrollY > 100) {
            navbar?.classList.add('navbar-scrolled');
        } else {
            navbar?.classList.remove('navbar-scrolled');
        }
    }
    
    window.addEventListener('scroll', handleNavbarScroll);
    
    // ===========================
    // BACK TO TOP BUTTON
    // ===========================
    function handleBackToTop() {
        if (window.scrollY > 300) {
            backToTop?.classList.add('show');
        } else {
            backToTop?.classList.remove('show');
        }
    }
    
    window.addEventListener('scroll', handleBackToTop);
    
    // Click event for back to top
    if (backToTop) {
        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // ===========================
    // SMOOTH SCROLL FOR ANCHORS
    // ===========================
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href === '#' || href === '#0') {
                    return;
                }
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    
                    const navbarHeight = navbar ? navbar.offsetHeight : 80;
                    const targetPosition = target.offsetTop - navbarHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Cerrar menú móvil si está abierto
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse?.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                        bsCollapse.hide();
                    }
                }
            });
        });
    }
    
    initSmoothScroll();
    
    // ===========================
    // ACTIVE MENU HIGHLIGHTING
    // ===========================
    function updateActiveMenu() {
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        
        window.addEventListener('scroll', function() {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (window.scrollY >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                const href = link.getAttribute('href');
                if (href && href.includes(current) && current !== '') {
                    link.classList.add('active');
                }
            });
        });
    }
    
    updateActiveMenu();
    
    // ===========================
    // WHATSAPP BUTTON ANIMATION
    // ===========================
    function animateWhatsApp() {
        if (whatsappBtn) {
            setInterval(() => {
                whatsappBtn.style.animation = 'none';
                whatsappBtn.offsetHeight; // Trigger reflow
                whatsappBtn.style.animation = 'pulse 2s infinite';
            }, 8000);
        }
    }
    
    animateWhatsApp();
    
    // ===========================
    // CAROUSEL AUTO-INIT
    // ===========================
    function initCarousel() {
        const carousel = document.querySelector('#heroCarousel');
        if (carousel && typeof bootstrap !== 'undefined') {
            new bootstrap.Carousel(carousel, {
                interval: 6000,
                wrap: true,
                pause: 'hover'
            });
            
            // Touch support for carousel
            let startX = 0;
            let endX = 0;
            
            carousel.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });
            
            carousel.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                handleSwipe();
            });
            
            function handleSwipe() {
                const threshold = 50;
                if (startX - endX > threshold) {
                    // Swipe left - next
                    bootstrap.Carousel.getInstance(carousel)?.next();
                } else if (endX - startX > threshold) {
                    // Swipe right - prev
                    bootstrap.Carousel.getInstance(carousel)?.prev();
                }
            }
        }
    }
    
    initCarousel();
    
    // ===========================
    // FORM VALIDATION
    // ===========================
    function initFormValidation() {
        const forms = document.querySelectorAll('.needs-validation');
        
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
        
        // Contact form specific handling
        const contactForm = document.querySelector('#contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                const requiredFields = ['name', 'email', 'msg_subject', 'message'];
                let isValid = true;
                
                requiredFields.forEach(fieldName => {
                    const field = this.querySelector(`[name="${fieldName}"]`);
                    if (field && !field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else if (field) {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });
                
                const emailField = this.querySelector('[name="email"]');
                if (emailField && emailField.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(emailField.value)) {
                        isValid = false;
                        emailField.classList.add('is-invalid');
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
        }
    }
    
    initFormValidation();
    
    // ===========================
    // AUTO-HIDE ALERTS
    // ===========================
    function autoHideAlerts() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            // Solo auto-ocultar si no tiene botón de cierre
            if (!alert.querySelector('.btn-close')) {
                setTimeout(() => {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                        bsAlert?.close();
                    } else {
                        alert.style.transition = 'opacity 0.5s ease';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 5000);
            }
        });
    }
    
    autoHideAlerts();
    
    // ===========================
    // PRODUCT CARDS HOVER EFFECT
    // ===========================
    function initProductCards() {
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }
    
    initProductCards();
    
    // ===========================
    // LAZY LOADING FOR IMAGES
    // ===========================
    function initLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });
            
            images.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback for older browsers
            images.forEach(img => {
                img.src = img.dataset.src;
            });
        }
    }
    
    initLazyLoading();
    
    // ===========================
    // COUNTER ANIMATION
    // ===========================
    function initCounterAnimation() {
        const counters = document.querySelectorAll('.counter');
        
        if (counters.length > 0 && 'IntersectionObserver' in window) {
            const counterObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            counters.forEach(counter => counterObserver.observe(counter));
        }
    }
    
    function animateCounter(counter) {
        const target = parseInt(counter.dataset.target) || 0;
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                counter.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current).toLocaleString();
            }
        }, 16);
    }
    
    initCounterAnimation();
    
    // ===========================
    // AOS ANIMATION INIT
    // ===========================
    function initAOS() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1000,
                easing: 'ease-in-out',
                once: true,
                mirror: false,
                offset: 100
            });
        }
    }
    
    initAOS();
    
    // ===========================
    // LOADING SCREEN
    // ===========================
    function hideLoader() {
        const loader = document.querySelector('.loader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }
    }
    
    // Hide loader when page is fully loaded
    window.addEventListener('load', hideLoader);
    
    // ===========================
    // UTILITY FUNCTIONS
    // ===========================
    
    // Throttle function for scroll events
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
    
    // Apply throttling to scroll events
    const throttledNavbarScroll = throttle(handleNavbarScroll, 100);
    const throttledBackToTop = throttle(handleBackToTop, 100);
    
    window.removeEventListener('scroll', handleNavbarScroll);
    window.removeEventListener('scroll', handleBackToTop);
    window.addEventListener('scroll', throttledNavbarScroll);
    window.addEventListener('scroll', throttledBackToTop);
    
    // ===========================
    // ERROR HANDLING
    // ===========================
    window.addEventListener('error', function(e) {
        console.error('JavaScript Error:', e.error);
    });
    
    // ===========================
    // PERFORMANCE MONITORING
    // ===========================
    if ('performance' in window) {
        window.addEventListener('load', function() {
            setTimeout(() => {
                const perfData = performance.timing;
                const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
                console.log(`Página cargada en: ${pageLoadTime}ms`);
            }, 0);
        });
    }
    
    console.log('Volante Lubricentro - Scripts cargados correctamente ✅');
});

// ===========================
// EXTERNAL FUNCTIONS (Global scope)
// ===========================

// Function to show custom alerts
function showAlert(message, type = 'success', duration = 5000) {
    const alertContainer = document.getElementById('alertPlaceholder') || document.body;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}-fill me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    if (duration > 0) {
        setTimeout(() => {
            if (alertDiv && alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, duration);
    }
}

// Function to validate email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Function to format phone numbers
function formatPhone(phone) {
    const cleaned = phone.replace(/\D/g, '');
    const match = cleaned.match(/^(\d{2})(\d{4})(\d{4})$/);
    if (match) {
        return `+54 ${match[1]} ${match[2]}-${match[3]}`;
    }
    return phone;
}