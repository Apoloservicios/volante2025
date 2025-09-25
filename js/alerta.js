
document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Mostrar alerta
    const alertPlaceholder = document.getElementById('alertPlaceholder');
    const alert = document.createElement('div');
    alert.className = 'alert alert-success';
    alert.role = 'alert';
    alert.innerText = 'Su mensaje ha sido enviado con éxito!!';
    alertPlaceholder.appendChild(alert);

    // Limpiar formulario
    this.reset();

    // Quitar alerta después de 3 segundos
    setTimeout(() => {
        alert.remove();
    }, 3000);
});