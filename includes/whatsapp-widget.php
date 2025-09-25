<!-- Botón flotante de WhatsApp simple -->
<a href="https://api.whatsapp.com/send?phone=5492604349002&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20sus%20productos%20y%20servicios." 
   class="whatsapp-float" 
   target="_blank"
   aria-label="Contactar por WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>

<!-- Widget de WhatsApp con múltiples contactos (opcional) -->
<div id="whatsapp-widget" style="display: none;">
    <div class="whatsapp-widget-container">
        <div class="whatsapp-header">
            <i class="bi bi-x-lg close-whatsapp"></i>
            <h5>💬 ¿En qué podemos ayudarte?</h5>
        </div>
        <div class="whatsapp-body">
            <p>Selecciona un departamento:</p>
            
            <a href="https://api.whatsapp.com/send?phone=5492604349002&text=Hola%21%20Necesito%20informaci%C3%B3n%20sobre%20productos." 
               class="whatsapp-option" target="_blank">
                <i class="bi bi-box-seam"></i>
                <div>
                    <strong>Ventas</strong>
                    <small>Consultas sobre productos y precios</small>
                </div>
            </a>
            
            <a href="https://api.whatsapp.com/send?phone=5492604349002&text=Hola%21%20Necesito%20soporte%20t%C3%A9cnico." 
               class="whatsapp-option" target="_blank">
                <i class="bi bi-tools"></i>
                <div>
                    <strong>Soporte Técnico</strong>
                    <small>Asesoramiento y consultas técnicas</small>
                </div>
            </a>
            
            <a href="https://api.whatsapp.com/send?phone=5492604349002&text=Hola%21%20Quiero%20consultar%20sobre%20precios%20mayoristas." 
               class="whatsapp-option" target="_blank">
                <i class="bi bi-shop"></i>
                <div>
                    <strong>Mayoristas</strong>
                    <small>Precios especiales para revendedores</small>
                </div>
            </a>
        </div>
        <div class="whatsapp-footer">
            <small>Horario: Lun-Vie 8:00-18:00 | Sáb 8:00-13:00</small>
        </div>
    </div>
</div>

<!-- Trigger para abrir el widget (opcional) -->
<button id="whatsapp-trigger" class="whatsapp-trigger" style="display: none;">
    <i class="bi bi-chat-dots-fill"></i>
    <span>¿Necesitas ayuda?</span>
</button>

<style>
/* Estilos para el widget de WhatsApp */
#whatsapp-widget {
    position: fixed;
    bottom: 100px;
    right: 40px;
    width: 350px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.15);
    z-index: 999;
    display: none;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.whatsapp-header {
    background: #25d366;
    color: white;
    padding: 15px;
    border-radius: 15px 15px 0 0;
    position: relative;
}

.whatsapp-header h5 {
    margin: 0;
    font-size: 16px;
}

.close-whatsapp {
    position: absolute;
    right: 15px;
    top: 15px;
    cursor: pointer;
    font-size: 20px;
}

.whatsapp-body {
    padding: 20px;
}

.whatsapp-body p {
    margin-bottom: 15px;
    color: #666;
}

.whatsapp-option {
    display: flex;
    align-items: center;
    padding: 12px;
    margin-bottom: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
}

.whatsapp-option:hover {
    background: #e9ecef;
    transform: translateX(5px);
    text-decoration: none;
    color: #333;
}

.whatsapp-option i {
    font-size: 24px;
    margin-right: 12px;
    color: #25d366;
}

.whatsapp-option strong {
    display: block;
    margin-bottom: 2px;
}

.whatsapp-option small {
    color: #666;
    font-size: 12px;
}

.whatsapp-footer {
    padding: 10px 20px;
    background: #f8f9fa;
    border-radius: 0 0 15px 15px;
    text-align: center;
}

.whatsapp-trigger {
    position: fixed;
    bottom: 120px;
    right: 40px;
    background: #25d366;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 25px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    cursor: pointer;
    z-index: 998;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.whatsapp-trigger:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

/* Responsive */
@media (max-width: 768px) {
    #whatsapp-widget {
        width: 90%;
        right: 5%;
        left: 5%;
        bottom: 80px;
    }
    
    .whatsapp-float {
        width: 50px;
        height: 50px;
        bottom: 20px;
        right: 20px;
        font-size: 25px;
    }
    
    .whatsapp-trigger {
        bottom: 80px;
        right: 20px;
    }
}
</style>

<script>
// JavaScript para el widget de WhatsApp (opcional)
document.addEventListener('DOMContentLoaded', function() {
    const widget = document.getElementById('whatsapp-widget');
    const trigger = document.getElementById('whatsapp-trigger');
    const closeBtn = document.querySelector('.close-whatsapp');
    
    // Si quieres usar el widget expandible, descomenta estas líneas:
    /*
    trigger.style.display = 'flex';
    
    trigger.addEventListener('click', function() {
        widget.style.display = widget.style.display === 'none' ? 'block' : 'none';
    });
    
    if(closeBtn) {
        closeBtn.addEventListener('click', function() {
            widget.style.display = 'none';
        });
    }
    */
    
    // Mensaje de bienvenida después de 5 segundos (opcional)
    setTimeout(function() {
        const welcomeMsg = document.createElement('div');
        welcomeMsg.className = 'whatsapp-welcome';
        welcomeMsg.innerHTML = '👋 ¡Hola! ¿Necesitas ayuda?';
        welcomeMsg.style.cssText = `
            position: fixed;
            bottom: 110px;
            right: 40px;
            background: white;
            padding: 10px 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            z-index: 997;
            animation: slideIn 0.3s ease;
        `;
        document.body.appendChild(welcomeMsg);
        
        // Remover mensaje después de 5 segundos
        setTimeout(function() {
            welcomeMsg.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => welcomeMsg.remove(), 300);
        }, 5000);
    }, 5000);
});

// Animaciones CSS adicionales
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideOut {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(20px); }
    }
`;
document.head.appendChild(style);
</script>