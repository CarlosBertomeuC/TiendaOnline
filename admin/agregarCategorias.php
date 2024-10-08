<?php
include '../config/db_functions.php';
session_start();

if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_categoria = $_POST['nombre_categoria'];

    if (agregarCategoria($nombre_categoria)) {
        header('Location: ListarCategorias.php');
    } else {
        echo "Error al agregar la categoría.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Categoría</title>
</head>
<body>
    <h1>Agregar Nueva Categoría</h1>
    <form action="" method="post">
        <label>Nombre de la categoría:</label><br>
        <input type="text" name="nombre_categoria" required><br>
        <button type="submit">Agregar Categoría</button>
    </form>
</body>
</html>
