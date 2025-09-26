<?php
session_start();
require_once '../config/database.php';

// Si ya está logueado, redirigir
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Por favor completa todos los campos.';
    } else {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("
                SELECT id, username, email, password_hash, role 
                FROM users 
                WHERE (username = ? OR email = ?) AND status = 'active'
            ");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // Login exitoso
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_username'] = $user['username'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['login_time'] = time();
                
                // Actualizar último login
                $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $stmt->execute([$user['id']]);
                
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Credenciales incorrectas.';
            }
        } catch (Exception $e) {
            $error = 'Error de conexión. Intenta nuevamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Volante Lubricentro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ED3237 0%, #2A7BBE 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 3rem 2rem;
            width: 100%;
            max-width: 400px;
        }
        .login-logo {
            max-width: 120px;
            margin-bottom: 2rem;
        }
        .btn-login {
            background: linear-gradient(135deg, #ED3237, #2A7BBE);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .form-control:focus {
            border-color: #ED3237;
            box-shadow: 0 0 0 0.2rem rgba(237, 50, 55, 0.25);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center">
            <img src="../img/logo/logo_volante.svg" alt="Volante Logo" class="login-logo">
            <h3 class="mb-1">Panel de Administración</h3>
            <p class="text-muted mb-4">Ingresa tus credenciales</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario o Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-login btn-primary w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
            </button>
        </form>
        
        <div class="text-center">
            <a href="../index.php" class="text-muted">
                <i class="bi bi-arrow-left me-1"></i>Volver al sitio
            </a>
        </div>
        
        <hr class="my-4">
        
        <div class="text-center">
            <small class="text-muted">
                <strong>Credenciales por defecto:</strong><br>
                Usuario: admin | Contraseña: volante2024
            </small>
        </div>
    </div>
</body>
</html>