<?php
session_start();

// Verificar si se ha enviado un producto para añadir al carrito
if (isset($_POST['agregar_al_carrito'])) {
    $producto_id = $_POST['producto_id'];
    $nombre_producto = $_POST['nombre'];
    $precio_producto = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

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
?>

<!-- Formulario en detalle_producto.php -->
<form method="post" action="detalle_producto.php">
    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
    <input type="hidden" name="nombre" value="<?php echo $producto['nombre']; ?>">
    <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
    
    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" value="1" min="1">
    
    <button type="submit" name="agregar_al_carrito">Añadir al Carrito</button>
</form>
