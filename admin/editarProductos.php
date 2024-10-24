<?php
session_start();
include '../config/db_functions.php';

if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precioUnitario = $_POST['precioUnitario'];
    $estado = $_POST['estado'];
    $stock = $_POST['stock'];

    actualizarProducto($id, $nombre, $descripcion, $precioUnitario, $estado, $stock);
    header('Location: listarProductos.php'); // Redirigir a la página de productos después de la actualización
    exit();
}

// Obtener los datos del producto para mostrarlos en el formulario
$id = $_GET['id'];
$producto = obtenerProductoPorId($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../assets/css/listarproductos.css">
</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>
        <form action="" method="post">
            <label>Nombre del producto:</label><br>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required><br>

            <label>Descripción:</label><br>
            <textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea><br>

            <label>Precio Unitario:</label><br>
            <input type="number" step="0.01" name="precioUnitario" value="<?php echo htmlspecialchars($producto['precioUnitario']); ?>" required><br>

            <label>Estado:</label><br>
            <select name="estado" required>
                <option value="nuevo" <?php if ($producto['estado'] == 'nuevo') echo 'selected'; ?>>Nuevo</option>
                <option value="usado" <?php if ($producto['estado'] == 'usado') echo 'selected'; ?>>Usado</option>
            </select><br>

            <label>Stock:</label><br>
            <input type="number" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required><br>

            <button type="submit">Actualizar Producto</button>
        </form>
    </div>
</body>
</html>