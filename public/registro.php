<?php
include '../config/db_functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $password = $_POST['contraseña'];
    $rol = 'cliente'; // Por defecto todos los usuarios son clientes
    $telefono = $_POST['telefono'];

    if (registrarUsuario($nombre, $apellidos, $email, $password, $rol, $telefono)) {
        header('Location: login.php');
        exit();
    } else {
        echo "Error al registrar el usuario.";
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
