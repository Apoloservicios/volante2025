<?php
// Números de WhatsApp configurables
$whatsapp_contacts = [
    'ventas' => [
        'number' => '5492604349002',
        'name' => 'Ventas',
        'message' => 'Hola! Necesito información sobre productos.'
    ],
    'soporte' => [
        'number' => '5492604349002', // Cambiar por número real
        'name' => 'Soporte Técnico',
        'message' => 'Hola! Necesito soporte técnico.'
    ],
    'mayoristas' => [
        'number' => '5492604349002', // Cambiar por número real
        'name' => 'Mayoristas',
        'message' => 'Hola! Quiero consultar sobre precios mayoristas.'
    ]
];
?>

<!-- Botón Principal WhatsApp -->
<div class="whatsapp-float" onclick="toggleWhatsAppOptions()">
    <i class="bi bi-whatsapp"></i>
    <span class="whatsapp-counter"><?php echo count($whatsapp_contacts); ?></span>
</div>

<!-- Opciones de WhatsApp -->
<div id="whatsapp-options" class="whatsapp-options">
    <?php foreach ($whatsapp_contacts as $key => $contact): ?>
        <div class="whatsapp-option" onclick="openWhatsApp('<?php echo $contact['number']; ?>', '<?php echo urlencode($contact['message']); ?>')">
            <i class="bi bi-whatsapp"></i>
            <span><?php echo $contact['name']; ?></span>
        </div>
    <?php endforeach; ?>
</div>

<style>
/* Botón Principal */
.whatsapp-float {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 40px;
    right: 40px;
    background: #25d366;
    color: white;
    border-radius: 50%;
    text-align: center;
    font-size: 30px;
    box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    animation: whatsapp-pulse 2s infinite;
    position: relative;
}

.whatsapp-float:hover {
    transform: scale(1.1);
    animation: none;
}

.whatsapp-counter {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ED3237;
    color: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 12px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
}

/* Opciones */
.whatsapp-options {
    position: fixed;
    bottom: 110px;
    right: 40px;
    display: none;
    flex-direction: column;
    gap: 10px;
    z-index: 999;
}

.whatsapp-options.show {
    display: flex;
    animation: slideUp 0.3s ease;
}

.whatsapp-option {
    background: white;
    color: #333;
    padding: 12px 20px;
    border-radius: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
    border: 2px solid #25d366;
}

.whatsapp-option:hover {
    background: #25d366;
    color: white;
    transform: translateX(-5px);
}

.whatsapp-option i {
    font-size: 20px;
}

/* Animaciones */
@keyframes whatsapp-pulse {
    0% { box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4); }
    50% { box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4), 0 0 0 10px rgba(37, 211, 102, 0.2); }
    100% { box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4); }
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Mobile */
@media (max-width: 768px) {
    .whatsapp-float {
        width: 50px;
        height: 50px;
        bottom: 20px;
        right: 20px;
        font-size: 25px;
    }
    
    .whatsapp-options {
        bottom: 80px;
        right: 20px;
    }
    
    .whatsapp-counter {
        width: 20px;
        height: 20px;
        font-size: 11px;
    }
}
</style>

<script>
let optionsVisible = false;

function toggleWhatsAppOptions() {
    const options = document.getElementById('whatsapp-options');
    const mainBtn = document.querySelector('.whatsapp-float');
    
    if (optionsVisible) {
        options.classList.remove('show');
        mainBtn.style.transform = 'rotate(0deg)';
        optionsVisible = false;
    } else {
        options.classList.add('show');
        mainBtn.style.transform = 'rotate(45deg)';
        optionsVisible = true;
        
        // Cerrar al hacer clic fuera
        setTimeout(() => {
            document.addEventListener('click', closeOnOutsideClick);
        }, 100);
    }
}

function closeOnOutsideClick(event) {
    const options = document.getElementById('whatsapp-options');
    const mainBtn = document.querySelector('.whatsapp-float');
    
    if (!options.contains(event.target) && !mainBtn.contains(event.target)) {
        options.classList.remove('show');
        mainBtn.style.transform = 'rotate(0deg)';
        optionsVisible = false;
        document.removeEventListener('click', closeOnOutsideClick);
    }
}

function openWhatsApp(number, message) {
    const url = `https://api.whatsapp.com/send?phone=${number}&text=${message}`;
    window.open(url, '_blank');
    
    // Cerrar opciones
    const options = document.getElementById('whatsapp-options');
    const mainBtn = document.querySelector('.whatsapp-float');
    options.classList.remove('show');
    mainBtn.style.transform = 'rotate(0deg)';
    optionsVisible = false;
}
</script>