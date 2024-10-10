<?php
session_start();
include '../config/db_functions.php';

$error = [];

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
    }
    if (empty($contraseña)) {
        $error[] = "La contraseña es obligatoria.";
    }
    if (empty($telefono)) {
        $error[] = "El teléfono es obligatorio.";
    }

    // Si no hay errores, registrar el usuario
    if (empty($error)) {
        registrarUsuario($nombre, $apellidos, $email, $contraseña, 'cliente', $telefono);
        echo "Registro exitoso.";
        header('Location: login.php');
        exit();
    } else {
        // Mostrar errores
        foreach ($error as $err) {
            echo $err . "<br>";
        }
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
        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>
            
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>
            
            <button type="submit">Registrar</button>
        </form>
        <a class="register-link" href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
    </div>
</body>
</html>