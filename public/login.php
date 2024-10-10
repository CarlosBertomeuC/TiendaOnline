<?php
include '../config/db_functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

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
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="" method="post">
            <input type="text" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <a class="register-link" href="registro.php">¿No tienes una cuenta? Regístrate</a>
    </div>
</body>
</html>
