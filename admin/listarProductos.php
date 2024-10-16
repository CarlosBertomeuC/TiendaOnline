<?php
session_start();
include '../config/db_functions.php';
include '../includes/header.php';

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
    <link rel="stylesheet" href="../assets/css/listarproductos.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Productos</h1>
        <a href="agregarProductos.php">Agregar Producto</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['id']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['estado']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($producto['precioUnitario']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                    <td class="acciones">
                        <a href="editarProductos.php?id=<?php echo $producto['id']; ?>">Editar</a>
                        <a href="eliminarProductos.php?id=<?php echo $producto['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta categoría?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>