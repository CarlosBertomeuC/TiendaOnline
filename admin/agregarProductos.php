<?php
include '../config/db_functions.php';
session_start();

if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precioUnitario = $_POST['precioUnitario'];
    $estado = $_POST['estado'];
    $stock = $_POST['stock'];
    $vendedor_id = $_SESSION['id'];

    if (agregarProducto($nombre, $descripcion, $precioUnitario, $estado, $stock, $vendedor_id)) {
        header('Location: productos.php');
    } else {
        echo "Error al agregar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
</head>
<body>
    <h1>Agregar Nuevo Producto</h1>
    <form action="" method="post">
        <label>Nombre del producto:</label><br>
        <input type="text" name="nombre" required><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" required></textarea><br>

        <label>Precio Unitario:</label><br>
        <input type="number" step="0.01" name="precioUnitario" required><br>

        <label>Estado:</label><br>
        <select name="estado" required>
            <option value="nuevo">Nuevo</option>
            <option value="usado">Usado</option>
        </select><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" required><br>

        <button type="submit">Agregar Producto</button>
    </form>
</body>
</html>
