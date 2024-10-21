<?php
session_start();
include '../config/db_functions.php';

$error = [];
$nombre = $apellidos = $email = $contraseña = $telefono = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $contraseña = trim($_POST['contraseña']);
    $telefono = trim($_POST['telefono']);
    // Validaciones
    if (empty($nombre)) {
        $error[] = "El nombre es obligatorio.";
    }
    if (empty($apellidos)) {
        $error[] = "Los apellidos son obligatorios.";
    }
    if (empty($email)) {
        $error[] = "El email es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "El formato del email no es válido.";
    }
    if (empty($contraseña)) {
        $error[] = "La contraseña es obligatoria.";
    } elseif (strlen($contraseña) < 8) {
        $error[] = "La contraseña debe tener al menos 8 caracteres.";
    }
    if (empty($telefono)) {
        $error[] = "El teléfono es obligatorio.";
    } elseif (!preg_match('/^\d{9}$/', $telefono)) {
        $error[] = "El teléfono debe tener 9 números.";
    }

    // Comprobar si el usuario ya existe
    if (usuarioExiste($email)) {
        $error[] = "El email ya está registrado.";
    }

    // Si no hay errores, registrar el usuario
    if (empty($error)) {
        registrarUsuario($nombre, $apellidos, $email, $contraseña, 'cliente', $telefono);
        echo "Registro exitoso.";
        include 'procesarRegistro.php';
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Registro de Usuarios</h2>
        <?php if (!empty($error)): ?>
            <div class="error-messages">
                <?php foreach ($error as $err): ?>
                    <p style="color: white;background-color:red;"><?php echo htmlspecialchars($err); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($apellidos); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            
            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>
            
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
            
            <button type="submit">Registrar</button>
        </form>
        <a class="register-link" href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
    </div>
</body>
</html>