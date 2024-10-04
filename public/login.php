<?php
include '../config/db_functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['contraseña'];

    $usuario = obtenerUsuarioPorEmail($email);
    if ($usuario) {
        echo "Usuario encontrado: " . $usuario['nombre'] . "<br>";
        echo "Hash almacenado: " . $usuario['contraseña'] . "<br>";
        echo "Contraseña ingresada: " . $password . "<br>";

        if (password_verify($password, $usuario['contraseña'])) {
            // Iniciar sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // Obtener el carrito de la sesión
            $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

            // Guardar el carrito en la base de datos
            try {
                guardarCarritoEnBD($usuario['id'], $carrito);
                echo "Carrito guardado exitosamente.";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }

            // Redirigir según el rol
            if ($usuario['rol'] == 'administrador') {
                header('Location: ../admin/index.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Email o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Inicio de Sesión</h1>
    <form action="" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Contraseña:</label><br>
        <input type="password" name="contraseña" required><br>
        <button type="submit">Iniciar Sesión</button>
        <button type="button" onclick="location.href='registro.php'">Registrarse</button>
    </form>
</body>
</html>
