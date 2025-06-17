<?php
session_start();

// ─── Conexión a la base de datos ───
$host = "localhost";
$db   = "entrenamiento_app";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$accion = $_GET['accion'] ?? 'login';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>FitPredictor - Autenticación</title>
    <link rel="icon" href='data:image/svg+xml;utf8,
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
      <text y="0.9em" font-size="90">🏋️‍♀️</text>
    </svg>'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
<?php

switch ($accion) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                $error_login = "<div class='alert alert-danger'>❌ Credenciales incorrectas.</div>";
            }
        }
        mostrarFormularioLogin($error_login ?? null);
        break;

    case 'register':
        $mensaje_registro = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
            try {
                $stmt->execute([$username, $password]);
                $mensaje_registro = "<div class='alert alert-success'>✅ Usuario registrado correctamente. <a href='auth.php?accion=login'>Iniciar sesión</a></div>";
            } catch (PDOException $e) {
                $mensaje_registro = "<div class='alert alert-danger'>❌ Error: ese usuario ya existe.</div>";
            }
        }
        mostrarFormularioRegistro($mensaje_registro ?? null);
        break;

    case 'logout':
        session_destroy();
        header("Location: auth.php?accion=login");
        exit;

    default:
        echo "<div class='container mt-4'><div class='alert alert-warning'>⚠️ Acción no válida.</div></div>";
}


// ─── FORMULARIO LOGIN ───
function mostrarFormularioLogin($mensaje = null) {
    echo <<<HTML
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <h3 class="card-title text-center text-primary  mb-4">Iniciar Sesión</h3>
HTML;

    if ($mensaje) {
        echo $mensaje;
    }

    echo <<<HTML
                        <form method="post" action="auth.php?accion=login">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Usuario:</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Contraseña:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="auth.php?accion=register">¿No tienes cuenta? Regístrate</a><br>
                            <a href="index.php">Entrar como invitado</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML;
}


// ─── FORMULARIO REGISTRO ───
function mostrarFormularioRegistro($mensaje = null) {
    echo <<<HTML
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <h3 class="card-title text-center text-success mb-4">Crear cuenta</h3>
HTML;

    if ($mensaje) {
        echo $mensaje;
    }

    echo <<<HTML
                        <form method="post" action="auth.php?accion=register">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nuevo usuario:</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Contraseña:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Registrar</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="auth.php?accion=login">¿Ya tienes cuenta? Inicia sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML;
}
?>
</body>
</html>
