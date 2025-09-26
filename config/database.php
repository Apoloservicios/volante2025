<?php
// config/database.php

// Configuración de la base de datos
define('DB_HOST', 'http://volante.com.ar/new');
define('DB_NAME', 'u822816010_volante_db');
define('DB_USER', 'u822816010_superapolo'); // Cambiar por tu usuario
define('DB_PASS', 'b0C12KgN^'); // Cambiar por tu contraseña
define('DB_CHARSET', 'utf8mb4');

// Configuración del sitio
define('SITE_URL', 'http://volante.com.ar/new'); // Cambiar por tu URL
define('SITE_NAME', 'Volante Lubricentro');
define('SITE_EMAIL', 'ventas@volante.com.ar');
define('SITE_PHONE', '(260) 434-9002');

// Zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Configuración de errores (cambiar a false en producción)
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Función de conexión a la base de datos
function getDBConnection() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
        
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die('Error de conexión: ' . $e->getMessage());
        } else {
            die('Error de conexión a la base de datos. Por favor, intente más tarde.');
        }
    }
}

// Función para obtener configuraciones
function getSetting($key, $default = '') {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT value FROM settings WHERE setting_key = ? LIMIT 1");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        
        return $result ? $result['value'] : $default;
        
    } catch (Exception $e) {
        return $default;
    }
}

// Función para sanitizar inputs
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Función para validar email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Función para generar token CSRF
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Función para validar token CSRF
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>