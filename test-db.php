<?php
/**
 * VOLANTE LUBRICENTRO - TEST DE BASE DE DATOS
 * Archivo para probar la conexión y crear las tablas necesarias
 */

// Configuración de errores para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Volante Lubricentro - Test de Base de Datos</h1>";
echo "<hr>";

// Verificar si existe el archivo de configuración
if (!file_exists('config/database.php')) {
    echo "<div style='color: red; padding: 10px; background: #ffebee; border: 1px solid red; border-radius: 5px;'>";
    echo "❌ <strong>ERROR:</strong> El archivo config/database.php no existe.<br>";
    echo "Por favor, crea el archivo con la configuración de tu base de datos.";
    echo "</div>";
    exit;
}

require_once 'config/database.php';

echo "<h2>📊 Información de Conexión</h2>";
echo "<ul>";
echo "<li><strong>Host:</strong> " . DB_HOST . "</li>";
echo "<li><strong>Base de Datos:</strong> " . DB_NAME . "</li>";
echo "<li><strong>Usuario:</strong> " . DB_USER . "</li>";
echo "<li><strong>Charset:</strong> " . DB_CHARSET . "</li>";
echo "</ul>";

echo "<h2>🔌 Probando Conexión...</h2>";

try {
    $pdo = getDBConnection();
    echo "<div style='color: green; padding: 10px; background: #e8f5e8; border: 1px solid green; border-radius: 5px;'>";
    echo "✅ <strong>ÉXITO:</strong> Conexión a la base de datos establecida correctamente.";
    echo "</div>";
    
    // Obtener información del servidor
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "<p><strong>Versión de MySQL:</strong> $version</p>";
    
} catch (Exception $e) {
    echo "<div style='color: red; padding: 10px; background: #ffebee; border: 1px solid red; border-radius: 5px;'>";
    echo "❌ <strong>ERROR de Conexión:</strong> " . $e->getMessage();
    echo "</div>";
    echo "<h3>🛠️ Posibles Soluciones:</h3>";
    echo "<ol>";
    echo "<li>Verifica que MySQL/MariaDB esté ejecutándose</li>";
    echo "<li>Comprueba las credenciales en config/database.php</li>";
    echo "<li>Asegúrate que la base de datos '" . DB_NAME . "' exista</li>";
    echo "<li>Verifica los permisos del usuario '" . DB_USER . "'</li>";
    echo "</ol>";
    exit;
}

echo "<hr>";
echo "<h2>🗂️ Creando/Verificando Tablas...</h2>";

// SQL para crear las tablas necesarias
$tables = [
    'settings' => "
        CREATE TABLE IF NOT EXISTS settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) UNIQUE NOT NULL,
            value TEXT,
            description VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ",
    
    'contact_messages' => "
        CREATE TABLE IF NOT EXISTS contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL,
            phone VARCHAR(20),
            subject VARCHAR(200) NOT NULL,
            message TEXT NOT NULL,
            ip_address VARCHAR(45),
            status ENUM('new', 'read', 'replied') DEFAULT 'new',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status),
            INDEX idx_created_at (created_at),
            INDEX idx_email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ",
    
    'blog_posts' => "
        CREATE TABLE IF NOT EXISTS blog_posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(200) NOT NULL,
            slug VARCHAR(250) UNIQUE NOT NULL,
            excerpt TEXT,
            content LONGTEXT,
            featured_image VARCHAR(255),
            status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
            author VARCHAR(100),
            meta_title VARCHAR(200),
            meta_description VARCHAR(300),
            views INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            published_at TIMESTAMP NULL,
            INDEX idx_status (status),
            INDEX idx_slug (slug),
            INDEX idx_created_at (created_at),
            FULLTEXT idx_search (title, content)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ",
    
    'users' => "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(150) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            role ENUM('admin', 'editor') DEFAULT 'editor',
            status ENUM('active', 'inactive') DEFAULT 'active',
            last_login TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_username (username),
            INDEX idx_email (email),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    "
];

$tablesCreated = 0;
$tablesExists = 0;

foreach ($tables as $tableName => $sql) {
    try {
        $pdo->exec($sql);
        
        // Verificar si la tabla existe y tiene registros
        $stmt = $pdo->query("SHOW TABLES LIKE '$tableName'");
        if ($stmt->rowCount() > 0) {
            $countStmt = $pdo->query("SELECT COUNT(*) FROM $tableName");
            $recordCount = $countStmt->fetchColumn();
            
            echo "<div style='color: green; padding: 5px;'>";
            echo "✅ Tabla '<strong>$tableName</strong>' ✓ ($recordCount registros)";
            echo "</div>";
            
            $tablesExists++;
        }
        $tablesCreated++;
        
    } catch (Exception $e) {
        echo "<div style='color: red; padding: 5px;'>";
        echo "❌ Error creando tabla '$tableName': " . $e->getMessage();
        echo "</div>";
    }
}

echo "<hr>";
echo "<h2>📝 Insertando Configuraciones Básicas...</h2>";

// Configuraciones por defecto
$defaultSettings = [
    'site_name' => 'Volante Lubricentro',
    'contact_email' => 'ventas@volante.com.ar',
    'phone' => '(260) 434-9002',
    'address' => 'Patricias Mendocinas 370, San Rafael, Mendoza',
    'business_hours' => 'Lun-Vie: 8:00-18:00 | Sáb: 8:00-13:00',
    'whatsapp_number' => '5492604349002',
    'facebook_url' => '',
    'instagram_url' => '',
    'google_analytics_id' => '',
    'maps_embed_url' => '',
    'maintenance_mode' => '0'
];

$settingsInserted = 0;

foreach ($defaultSettings as $key => $value) {
    try {
        $stmt = $pdo->prepare("INSERT IGNORE INTO settings (setting_key, value) VALUES (?, ?)");
        $result = $stmt->execute([$key, $value]);
        
        if ($stmt->rowCount() > 0) {
            echo "<span style='color: green;'>✅ $key</span><br>";
            $settingsInserted++;
        } else {
            echo "<span style='color: orange;'>⚠️ $key (ya existe)</span><br>";
        }
        
    } catch (Exception $e) {
        echo "<span style='color: red;'>❌ $key: " . $e->getMessage() . "</span><br>";
    }
}

echo "<hr>";
echo "<h2>👤 Creando Usuario Administrador...</h2>";

// Crear usuario admin por defecto
try {
    $adminUsername = 'admin';
    $adminEmail = 'admin@volante.com.ar';
    $adminPassword = 'volante2024'; // Cambiar después del primer login
    $passwordHash = password_hash($adminPassword, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, email, password_hash, role) VALUES (?, ?, ?, 'admin')");
    $result = $stmt->execute([$adminUsername, $adminEmail, $passwordHash]);
    
    if ($stmt->rowCount() > 0) {
        echo "<div style='color: green; padding: 10px; background: #e8f5e8; border: 1px solid green; border-radius: 5px;'>";
        echo "✅ <strong>Usuario administrador creado:</strong><br>";
        echo "<strong>Usuario:</strong> $adminUsername<br>";
        echo "<strong>Email:</strong> $adminEmail<br>";
        echo "<strong>Contraseña:</strong> $adminPassword<br>";
        echo "<em>⚠️ Cambia la contraseña después del primer login</em>";
        echo "</div>";
    } else {
        echo "<div style='color: orange; padding: 10px; background: #fff8e1; border: 1px solid orange; border-radius: 5px;'>";
        echo "⚠️ <strong>Usuario administrador ya existe</strong>";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "<div style='color: red; padding: 10px; background: #ffebee; border: 1px solid red; border-radius: 5px;'>";
    echo "❌ <strong>Error creando usuario admin:</strong> " . $e->getMessage();
    echo "</div>";
}

echo "<hr>";
echo "<h2>🧪 Probando Funciones del Sistema...</h2>";

// Test función getSetting
try {
    $siteName = getSetting('site_name', 'Default');
    echo "<div style='color: green; padding: 5px;'>";
    echo "✅ Función getSetting(): '$siteName'";
    echo "</div>";
} catch (Exception $e) {
    echo "<div style='color: red; padding: 5px;'>";
    echo "❌ Error en getSetting(): " . $e->getMessage();
    echo "</div>";
}

// Test función sanitizeInput
try {
    $testInput = "<script>alert('test')</script>";
    $sanitized = sanitizeInput($testInput);
    echo "<div style='color: green; padding: 5px;'>";
    echo "✅ Función sanitizeInput(): '$sanitized'";
    echo "</div>";
} catch (Exception $e) {
    echo "<div style='color: red; padding: 5px;'>";
    echo "❌ Error en sanitizeInput(): " . $e->getMessage();
    echo "</div>";
}

echo "<hr>";
echo "<h2>📊 Resumen de la Instalación</h2>";

echo "<div style='padding: 15px; background: #f5f5f5; border-radius: 5px;'>";
echo "<h3>✅ Estado del Sistema:</h3>";
echo "<ul>";
echo "<li><strong>Conexión a DB:</strong> ✅ Exitosa</li>";
echo "<li><strong>Tablas creadas:</strong> $tablesCreated de " . count($tables) . "</li>";
echo "<li><strong>Configuraciones:</strong> $settingsInserted nuevas insertadas</li>";
echo "<li><strong>Usuario Admin:</strong> ✅ Disponible</li>";
echo "</ul>";

echo "<h3>🔗 Enlaces Útiles:</h3>";
echo "<ul>";
echo "<li><a href='index.php'>🏠 Página Principal</a></li>";
echo "<li><a href='admin/login.php'>🔐 Panel de Administración</a></li>";
echo "<li><a href='contact/test-contact.php'>📧 Test de Contacto</a></li>";
echo "</ul>";

echo "<h3>⚙️ Próximos Pasos:</h3>";
echo "<ol>";
echo "<li>Cambiar la contraseña del usuario admin</li>";
echo "<li>Configurar las variables en config/database.php para producción</li>";
echo "<li>Subir imágenes reales a la carpeta img/</li>";
echo "<li>Configurar el envío de emails</li>";
echo "<li>Configurar Google Analytics</li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<h2>🔍 Información del Servidor</h2>";

echo "<div style='font-family: monospace; background: #f8f9fa; padding: 15px; border-radius: 5px;'>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'N/A') . "<br>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>Script Path:</strong> " . __FILE__ . "<br>";
echo "<strong>Current Time:</strong> " . date('Y-m-d H:i:s') . "<br>";
echo "<strong>Memory Limit:</strong> " . ini_get('memory_limit') . "<br>";
echo "<strong>Max Execution Time:</strong> " . ini_get('max_execution_time') . "s<br>";
echo "<strong>Upload Max Size:</strong> " . ini_get('upload_max_filesize') . "<br>";
echo "</div>";

// Test de escritura de archivos
echo "<hr>";
echo "<h2>📁 Test de Permisos de Archivos</h2>";

$testDirs = ['uploads', 'img/uploads', 'logs', 'cache'];
foreach ($testDirs as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "<span style='color: green;'>✅ Directorio '$dir' creado</span><br>";
        } else {
            echo "<span style='color: red;'>❌ No se pudo crear '$dir'</span><br>";
        }
    } else {
        echo "<span style='color: blue;'>ℹ️ Directorio '$dir' ya existe</span><br>";
    }
    
    if (is_writable($dir)) {
        echo "<span style='color: green;'>✅ '$dir' es escribible</span><br>";
    } else {
        echo "<span style='color: red;'>❌ '$dir' no es escribible</span><br>";
    }
}

echo "<hr>";
echo "<div style='text-align: center; padding: 20px; background: linear-gradient(135deg, #ED3237, #c02328); color: white; border-radius: 10px;'>";
echo "<h2>🎉 ¡Instalación Completada!</h2>";
echo "<p>El sistema Volante Lubricentro está listo para usar</p>";
echo "<p><strong>Fecha:</strong> " . date('d/m/Y H:i:s') . "</p>";
echo "</div>";

// Botón para eliminar este archivo (seguridad)
echo "<hr>";
echo "<div style='text-align: center; padding: 15px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 5px;'>";
echo "<h3>⚠️ Seguridad</h3>";
echo "<p>Por seguridad, elimina este archivo después de completar la instalación:</p>";
echo "<p><code>rm test-db.php</code></p>";
echo "<p>O renómbralo para evitar accesos no autorizados</p>";
echo "</div>";

?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #f8f9fa;
}

h1 {
    color: #ED3237;
    text-align: center;
    margin-bottom: 30px;
}

h2 {
    color: #2A7BBE;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

div, span, p, li {
    line-height: 1.6;
}

a {
    color: #ED3237;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    color: #c02328;
    text-decoration: underline;
}

code {
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
}

hr {
    margin: 30px 0;
    border: none;
    height: 2px;
    background: linear-gradient(to right, #ED3237, #2A7BBE);
}
</style>