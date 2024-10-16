<?php
session_start();
include '../config/db_functions.php';
include '../includes/header.php';

if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

// Obtener todas las categorías
$categorias = obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Categorías</title>
    <link rel="stylesheet" href="../assets/css/listarproductos.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Categorías</h1>
        <a href="agregarCategorias.php">Agregar Categoría</a>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?php echo $categoria['id']; ?></td>
                    <td><?php echo $categoria['nombre_categoria']; ?></td>
                    <td class="acciones">
                        <a href="editarCategorias.php?id=<?php echo $categoria['id']; ?>">Editar</a>
                        <a href="eliminarCategorias.php?id=<?php echo $categoria['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta categoría?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
