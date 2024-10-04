<?php
include '../config/db_functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contraseña = $_POST['contraseña'];
    $telefono = trim($_POST['telefono']);
    $error = [];

    // Validar que no estén vacíos
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($contraseña) || empty($telefono)) {
        $error[] = "Todos los campos son obligatorios.";
    }

    // Validar el formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Formato de email no válido.";
    }

    // Validar la longitud de la contraseña (mínimo 8 caracteres)
    if (strlen($contraseña) < 8) {
        $error[] = "La contraseña debe tener al menos 8 caracteres.";
    }

    // Si no hay errores, procesamos el registro
    if (empty($error)) {
        registrarUsuario($nombre, $apellidos, $email, $contraseña, 'cliente', $telefono);
        echo "Registro exitoso.";
        header('Location: login.php');
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
</head>
<body>
    <h1>Registro de Usuarios</h1>
    <form action="" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br>
        <label>Apellidos:</label><br>
        <input type="text" name="apellidos" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Contraseña:</label><br>
        <input type="password" name="contraseña" required><br>
        <label>Teléfono:</label><br>
        <input type="text" name="telefono"><br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
