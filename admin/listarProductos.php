<?php
include '../config/db_functions.php';
session_start();

if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
</head>
<body>
    <h1>Lista de Productos</h1>
    <a href="agregarProductos.php">Agregar Producto</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?php echo $producto['id']; ?></td>
                <td><?php echo $producto['nombre']; ?></td>
                <td><?php echo $producto['descripcion']; ?></td>
                <td><?php echo $producto['precioUnitario']; ?> €</td>
                <td><?php echo $producto['stock']; ?></td>
                <td>
                    <a href="editarProductos.php?id=<?php echo $producto['id']; ?>">Editar</a> |
                    <a href="eliminarProductos.php?id=<?php echo $producto['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
