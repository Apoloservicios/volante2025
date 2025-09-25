// js/main.js

document.addEventListener('DOMContentLoaded', function() {
    
    // ===========================
    // Navbar Scroll Effect
    // ===========================
    const navbar = document.getElementById('menu');
    const logo = document.getElementById('img_logo_menu');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
            if (logo) {
                logo.style.width = '280px';
            }
        } else {
            navbar.classList.remove('navbar-scrolled');
            if (logo) {
                logo.style.width = '350px';
            }
        }
    });
    
    // ===========================
    // Back to Top Button
    // ===========================
    const backToTop = document.querySelector('.back-to-top');
    
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // ===========================
    // Active Menu Item
    // ===========================
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('#menu_principal .nav-link');
    
    window.addEventListener('scroll', function() {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (scrollY >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').includes(current)) {
                link.classList.add('active');
            }
        });
    });
    
    // ===========================
    // Smooth Scroll for Anchor Links
    // ===========================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href !== '#' && href !== '#0') {
                e.preventDefault();
                const target = document.querySelector(href);
                
                if (target) {
                    const offset = 80; // Altura del navbar
                    const targetPosition = target.offsetTop - offset;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Cerrar menú móvil si está abierto
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        navbarCollapse.classList.remove('show');
                    }
                }
            }
        });
    });
    
    // ===========================
    // WhatsApp Button Animation
    // ===========================
    const whatsappBtn = document.querySelector('.float');
    
    if (whatsappBtn) {
        setInterval(function() {
            whatsappBtn.classList.add('pulse');
            setTimeout(function() {
                whatsappBtn.classList.remove('pulse');
            }, 1000);
        }, 3000);
    }
    
    // ===========================
    // Contact Form Validation
    // ===========================
    const contactForm = document.querySelector('.needs-validation');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            if (!contactForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            contactForm.classList.add('was-validated');
        }, false);
    }
    
    // ===========================
    // Auto Hide Alerts
    // ===========================
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // ===========================
    // Product Cards Hover Effect
    // ===========================
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // ===========================
    // Lazy Loading for Images
    // ===========================
    const images = document.querySelectorAll('img[data-lazy]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.lazy;
                img.removeAttribute('data-lazy');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // ===========================
    // Counter Animation
    // ===========================
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    
    const countUp = (counter) => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;
        const inc = target / speed;
        
        if (count < target) {
            counter.innerText = Math.ceil(count + inc);
            setTimeout(() => countUp(counter), 1);
        } else {
            counter.innerText = target;
        }
    };
    
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                countUp(entry.target);
                observer.unobserve(entry.target);
            }
        });
    });
    
    counters.forEach(counter => counterObserver.observe(counter));
    
    // ===========================
    // Carousel Touch Support
    // ===========================
    const carousel = document.querySelector('#carouselExampleCaptions');
    
    if (carousel) {
        let touchStartX = 0;
        let touchEndX = 0;
        
        carousel.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        carousel.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
        
        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                // Swipe left - next slide
                const nextButton = carousel.querySelector('.carousel-control-next');
                if (nextButton) nextButton.click();
            }
            if (touchEndX > touchStartX + 50) {
                // Swipe right - previous slide
                const prevButton = carousel.querySelector('.carousel-control-prev');
                if (prevButton) prevButton.click();
            }
        }
    }
    
    // ===========================
    // Loading Spinner
    // ===========================
    window.addEventListener('load', function() {
        const loader = document.querySelector('.loader');
        if (loader) {
            loader.style.display = 'none';
        }
    });
    
});

// ===========================
// Additional CSS for animations
// ===========================
const style = document.createElement('style');
style.textContent = `
    .pulse {
        animation: pulse-animation 1s infinite;
    }
    
    @keyframes pulse-animation {
        0% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
        }
        70% {
            box-shadow: 0 0 0 20px rgba(37, 211, 102, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
        }
    }
    
    .navbar-scrolled {
        padding: 0.5rem 0 !important;
        background: rgba(237, 50, 55, 0.95) !important;
        backdrop-filter: blur(10px);
    }
`;
document.head.appendChild(style);

console.log('Volante Lubricentro - Scripts cargados correctamente');