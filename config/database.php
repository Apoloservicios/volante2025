<?php
// =================================================================
// config/database.php - CONFIGURACIÓN DE BASE DE DATOS
// =================================================================

$host = 'localhost';
$dbname = 'volante_db';
$username = 'root'; // CAMBIAR por tu usuario
$password = '';     // CAMBIAR por tu contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        die("Error de conexión: " . $e->getMessage());
    } else {
        die("Error de conexión a la base de datos. Contacte al administrador.");
    }
}

// Funciones helper globales
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function generateSlug($string) {
    $slug = strtolower(trim($string));
    // Convertir caracteres especiales
    $slug = preg_replace('/[áàäâ]/u', 'a', $slug);
    $slug = preg_replace('/[éèëê]/u', 'e', $slug);
    $slug = preg_replace('/[íìïî]/u', 'i', $slug);
    $slug = preg_replace('/[óòöô]/u', 'o', $slug);
    $slug = preg_replace('/[úùüû]/u', 'u', $slug);
    $slug = preg_replace('/[ñ]/u', 'n', $slug);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    return trim($slug, '-');
}

function getSiteSettings($pdo) {
    static $settings = null;
    
    if ($settings === null) {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    
    return $settings;
}

function getSetting($key, $default = '') {
    global $pdo;
    $settings = getSiteSettings($pdo);
    return $settings[$key] ?? $default;
}
?>