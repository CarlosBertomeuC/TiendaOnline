<?php
session_start();
include '../includes/header.php';
include '../config/db_functions.php';

// Verificar si se ha enviado un producto para añadir al carrito
if (isset($_POST['agregar_al_carrito'])) {
    $producto_id = intval($_POST['producto_id']);
    $nombre_producto = $_POST['nombre'];
    $precio_producto = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    // Si el carrito no existe, lo creamos
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['carrito'][$producto_id])) {
        // Si el producto ya está en el carrito, actualizamos la cantidad
        $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
    } else {
        // Si no, lo añadimos al carrito
        $_SESSION['carrito'][$producto_id] = [
            'id' => $producto_id,
            'nombre' => $nombre_producto,
            'precio' => $precio_producto,
            'cantidad' => $cantidad
        ];
    }

    echo "Producto añadido al carrito.";
}

// Verificar si se ha especificado un ID de producto en la URL
if (isset($_GET['id'])) {
    $producto_id = intval($_GET['id']);
    $producto = obtenerProductoPorId($producto_id);

    if (!$producto) {
        echo "Producto no encontrado.";
        exit();
    }
} else {
    echo "ID de producto no especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
    <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
    <p>Precio: $<?php echo htmlspecialchars($producto['precioUnitario']); ?></p>
    <p>Stock: <?php echo htmlspecialchars($producto['stock']); ?></p>
    <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">

    <!-- Formulario para añadir al carrito -->
    <form method="post" action="detalle_producto.php?id=<?php echo $producto['id']; ?>">
        <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
        <input type="hidden" name="nombre" value="<?php echo $producto['nombre']; ?>">
        <input type="hidden" name="precio" value="<?php echo $producto['precioUnitario']; ?>">
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" value="1" min="1" required>
        <button type="submit" name="agregar_al_carrito">Añadir al Carrito</button>
    </form>
</body>
</html>