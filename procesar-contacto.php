<?php
// procesar-contacto.php - Colocar en la raíz del proyecto
session_start();

// Configuración
$to_email = "ventas@volante.com.ar"; // Cambiar por tu email
$site_name = "Volante Lubricentro";

// Verificar si es POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}

// Función para limpiar datos
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Recoger y limpiar datos
$name = clean_input($_POST['name'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$phone = clean_input($_POST['phone'] ?? '');
$subject = clean_input($_POST['msg_subject'] ?? 'Consulta General');
$message = clean_input($_POST['message'] ?? '');

// Validaciones
$errors = [];

if (empty($name)) {
    $errors[] = "El nombre es requerido";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email válido es requerido";
}

if (empty($message)) {
    $errors[] = "El mensaje es requerido";
}

// Si hay errores, regresar
if (!empty($errors)) {
    $_SESSION['contact_errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: index.php#contacto");
    exit;
}

// Preparar el email
$email_subject = "$site_name - Nuevo mensaje: $subject";

// Mensaje en formato HTML
$email_body = "
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .header { background: #ED3237; color: white; padding: 20px; text-align: center; }
        .content { background: white; padding: 20px; margin-top: 20px; }
        .field { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; color: #333; }
        .value { color: #666; margin-top: 5px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>Nuevo Mensaje de Contacto</h2>
            <p>$site_name</p>
        </div>
        <div class='content'>
            <div class='field'>
                <div class='label'>Nombre:</div>
                <div class='value'>$name</div>
            </div>
            <div class='field'>
                <div class='label'>Email:</div>
                <div class='value'>$email</div>
            </div>
            <div class='field'>
                <div class='label'>Teléfono:</div>
                <div class='value'>" . ($phone ?: 'No proporcionado') . "</div>
            </div>
            <div class='field'>
                <div class='label'>Asunto:</div>
                <div class='value'>$subject</div>
            </div>
            <div class='field'>
                <div class='label'>Mensaje:</div>
                <div class='value'>" . nl2br($message) . "</div>
            </div>
            <div style='margin-top: 30px; padding-top: 20px; border-top: 2px solid #eee; text-align: center; color: #999;'>
                <small>Mensaje enviado desde el formulario web - " . date('d/m/Y H:i:s') . "</small>
            </div>
        </div>
    </div>
</body>
</html>
";

// Headers para HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: $name <$email>" . "\r\n";
$headers .= "Reply-To: $email" . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Intentar enviar el email
$mail_sent = @mail($to_email, $email_subject, $email_body, $headers);

// Email de confirmación al cliente
$client_subject = "Gracias por contactarnos - $site_name";
$client_message = "
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; }
        .header { background: #ED3237; color: white; padding: 30px; text-align: center; }
        .content { background: #f9f9f9; padding: 30px; }
        .footer { background: #333; color: white; padding: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>¡Gracias por contactarnos!</h1>
        </div>
        <div class='content'>
            <p>Hola <strong>$name</strong>,</p>
            <p>Hemos recibido tu mensaje correctamente. Nuestro equipo se pondrá en contacto contigo a la brevedad.</p>
            <p><strong>Resumen de tu consulta:</strong></p>
            <p style='background: white; padding: 15px; border-left: 4px solid #ED3237;'>
                <strong>Asunto:</strong> $subject<br>
                <strong>Mensaje:</strong> " . substr($message, 0, 200) . "...
            </p>
            <p>Mientras tanto, puedes:</p>
            <ul>
                <li>Visitarnos en Patricias Mendocinas 370, San Rafael, Mendoza</li>
                <li>Llamarnos al (260) 434-9002</li>
                <li>Escribirnos por WhatsApp al +54 9 2604 34-9002</li>
            </ul>
        </div>
        <div class='footer'>
            <p>© " . date('Y') . " Volante Lubricentro - Todos los derechos reservados</p>
        </div>
    </div>
</body>
</html>
";

// Headers para el email del cliente
$client_headers = "MIME-Version: 1.0" . "\r\n";
$client_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$client_headers .= "From: $site_name <$to_email>" . "\r\n";

// Enviar confirmación al cliente
@mail($email, $client_subject, $client_message, $client_headers);

// Respuesta según resultado
if ($mail_sent) {
    $_SESSION['contact_success'] = "¡Mensaje enviado con éxito! Te responderemos pronto.";
    
    // Opcional: Guardar en base de datos
    try {
        // Si tienes base de datos configurada
        if (file_exists('config/database.php')) {
            require_once 'config/database.php';
            
            $pdo = getDBConnection();
            $sql = "INSERT INTO contact_messages (name, email, phone, subject, message, ip_address, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $email, $phone, $subject, $message, $_SERVER['REMOTE_ADDR']]);
        }
    } catch (Exception $e) {
        // Silenciar errores de DB, el email ya se envió
    }
    
} else {
    $_SESSION['contact_error'] = "Hubo un problema al enviar el mensaje. Por favor, intenta nuevamente o contáctanos directamente.";
}

// Limpiar datos del formulario si se envió correctamente
if ($mail_sent) {
    unset($_SESSION['form_data']);
}

// Redirigir
header("Location: index.php#contacto");
exit;

// ============================================
// CONFIGURACIÓN ESPECÍFICA PARA HOSTINGER
// ============================================
// Si el email no funciona en Hostinger, agregar estas líneas al inicio del archivo:
/*
ini_set('SMTP', 'smtp.hostinger.com');
ini_set('smtp_port', '587');
ini_set('sendmail_from', $to_email);
*/

// ============================================
// ALTERNATIVA CON PHPMAILER (RECOMENDADO)
// ============================================
// Si tienes problemas con mail(), instala PHPMailer:
// composer require phpmailer/phpmailer
/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com'; // o tu servidor SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tu-email@tu-dominio.com';
    $mail->Password   = 'tu-contraseña';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Destinatarios
    $mail->setFrom($to_email, $site_name);
    $mail->addAddress($to_email);
    $mail->addReplyTo($email, $name);

    // Contenido
    $mail->isHTML(true);
    $mail->Subject = $email_subject;
    $mail->Body    = $email_body;

    $mail->send();
    $_SESSION['contact_success'] = "¡Mensaje enviado con éxito!";
} catch (Exception $e) {
    $_SESSION['contact_error'] = "Error: {$mail->ErrorInfo}";
}
*/
?>