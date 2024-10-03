<?php
include '../config/db_functions.php';
session_start();

if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

$id = $_GET['id'];
$producto = obtenerProductoPorId($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precioUnitario = $_POST['precioUnitario'];
    $estado = $_POST['estado'];
    $stock = $_POST['stock'];

    if (actualizarProducto($id, $nombre, $descripcion, $precioUnitario, $estado, $stock)) {
        header('Location: listarProductos.php');
    } else {
        echo "Error al actualizar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    <form action="" method="post">
        <label>Nombre del producto:</label><br>
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea><br>

        <label>Precio Unitario:</label><br>
        <input type="number" step="0.01" name="precioUnitario" value="<?php echo $producto['precioUnitario']; ?>" required><br>

        <label>Estado:</label><br>
        <select name="estado" required>
            <option value="nuevo" <?php if ($producto['estado'] == 'nuevo') echo 'selected'; ?>>Nuevo</option>
            <option value="usado" <?php if ($producto['estado'] == 'usado') echo 'selected'; ?>>Usado</option>
        </select><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required><br>

        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>
