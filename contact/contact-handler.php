<?php
// =================================================================
// contact/contact-handler.php - MANEJO MEJORADO DEL FORMULARIO
// =================================================================
session_start();
require_once '../config/database.php';

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

// Rate limiting básico
$ip = $_SERVER['REMOTE_ADDR'];
$rate_limit_file = sys_get_temp_dir() . "/rate_limit_contact_{$ip}.txt";
$max_attempts = 5; // 5 intentos por hora
$time_window = 3600; // 1 hora

if (file_exists($rate_limit_file)) {
    $data = json_decode(file_get_contents($rate_limit_file), true);
    if (time() - $data['timestamp'] < $time_window && $data['attempts'] >= $max_attempts) {
        $_SESSION['contact_error'] = 'Demasiados intentos. Intenta nuevamente en una hora.';
        header('Location: ../index.php#contacto');
        exit;
    }
    
    if (time() - $data['timestamp'] >= $time_window) {
        $data = ['attempts' => 0, 'timestamp' => time()];
    }
} else {
    $data = ['attempts' => 0, 'timestamp' => time()];
}

$data['attempts']++;
file_put_contents($rate_limit_file, json_encode($data));

// Validar campos requeridos
$required_fields = ['name', 'email', 'msg_subject', 'message'];
$errors = [];

foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $errors[] = "El campo " . ucfirst($field) . " es requerido";
    }
}

// Validaciones específicas
if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "El formato del email no es válido";
}

if (!empty($_POST['name']) && strlen($_POST['name']) > 100) {
    $errors[] = "El nombre es demasiado largo (máximo 100 caracteres)";
}

if (!empty($_POST['message']) && strlen($_POST['message']) > 2000) {
    $errors[] = "El mensaje es demasiado largo (máximo 2000 caracteres)";
}

// Validación anti-spam básica
$spam_words = ['viagra', 'casino', 'loan', 'bitcoin', 'crypto'];
$message_lower = strtolower($_POST['message'] ?? '');
foreach ($spam_words as $spam_word) {
    if (strpos($message_lower, $spam_word) !== false) {
        $errors[] = "Mensaje detectado como spam";
        break;
    }
}

// Si hay errores, regresar
if (!empty($errors)) {
    $_SESSION['contact_errors'] = $errors;
    header('Location: ../index.php#contacto');
    exit;
}

// Sanitizar datos
$name = sanitizeInput($_POST['name']);
$email = sanitizeInput($_POST['email']);
$phone = sanitizeInput($_POST['phone'] ?? '');
$subject = sanitizeInput($_POST['msg_subject']);
$message = sanitizeInput($_POST['message']);

try {
    // Guardar en base de datos
    $sql = "INSERT INTO contact_messages (name, email, phone, subject, message, ip_address, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $phone, $subject, $message, $ip]);
    
    // Enviar email de notificación
    $to = getSetting('contact_email', 'ventas@volante.com.ar');
    $email_subject = "Nuevo contacto - " . $subject;
    
    $email_body = "
=== NUEVO MENSAJE DE CONTACTO ===

Nombre: {$name}
Email: {$email}
Teléfono: {$phone}
Asunto: {$subject}

Mensaje:
{$message}

---
IP: {$ip}
Fecha: " . date('d/m/Y H:i:s') . "
Sitio: " . getSetting('site_name', 'Volante Lubricentro') . "

Para responder, envía un email directamente a: {$email}
";
    
    $headers = [
        "From: " . getSetting('contact_email', 'ventas@volante.com.ar'),
        "Reply-To: {$email}",
        "Content-Type: text/plain; charset=UTF-8",
        "X-Mailer: PHP/" . phpversion()
    ];
    
    mail($to, $email_subject, $email_body, implode("\r\n", $headers));
    
    // Email de confirmación al cliente
    $client_subject = "Gracias por contactarnos - Volante Lubricentro";
    $client_body = "
Hola {$name},

Gracias por contactarnos. Hemos recibido tu mensaje:

\"{$subject}\"

Te responderemos a la brevedad en el email: {$email}

Saludos cordiales,
Equipo Volante Lubricentro
Patricias Mendocinas 370 - San Rafael - Mendoza
(260) 434-9002
";
    
    $client_headers = [
        "From: " . getSetting('contact_email', 'ventas@volante.com.ar'),
        "Content-Type: text/plain; charset=UTF-8"
    ];
    
    mail($email, $client_subject, $client_body, implode("\r\n", $client_headers));
    
    $_SESSION['contact_success'] = "¡Mensaje enviado con éxito! Te responderemos pronto.";
    
    // Limpiar rate limit en caso de éxito
    if (file_exists($rate_limit_file)) {
        unlink($rate_limit_file);
    }
    
} catch (Exception $e) {
    error_log("Error en formulario de contacto: " . $e->getMessage());
    $_SESSION['contact_error'] = "Hubo un error al enviar tu mensaje. Por favor intenta nuevamente.";
}

header('Location: ../index.php#contacto');
exit;
?>