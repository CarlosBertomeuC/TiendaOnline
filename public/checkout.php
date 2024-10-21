<?php
session_start();
include '../includes/header.php';
include '../config/db_functions.php';

// Comprobaciones varias
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para realizar un pedido. <a href='login.php'>Iniciar sesión</a>";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener los productos del carrito desde la base de datos
$carrito = obtenerCarrito($usuario_id);

if (empty($carrito)) {
    echo "Tu carrito está vacío. <a href='index.php'>Volver a la tienda</a>";
    exit();
}

// Obtener el total del carrito
$total = 0;
foreach ($carrito as $producto) {
    $precio = floatval($producto['precio']);
    $cantidad = intval($producto['cantidad']);
    $total += $precio * $cantidad;
}

// Mostrar los productos del carrito
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/checkout.css">
</head>
<body>
    <div class="container">
        <h1>Tu Carrito</h1>
        <table>
            <tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th></tr>
            <?php foreach ($carrito as $producto): ?>
                <?php
                $precio = floatval($producto['precio']);
                $cantidad = intval($producto['cantidad']);
                $totalProducto = $precio * $cantidad;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($precio); ?></td>
                    <td><?php echo htmlspecialchars($cantidad); ?></td>
                    <td><?php echo htmlspecialchars($totalProducto); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr><td colspan="3">Total</td><td><?php echo htmlspecialchars($total); ?></td></tr>
        </table>

        <!-- Formulario de checkout -->
        <h2>Dirección de Envío</h2>
        <form method="POST" action="">
            <label for="direccion_envio">Dirección de Envío:</label>
            <input type="text" id="direccion_envio" name="direccion_envio" required>
            <button type="submit">Realizar Pedido</button>
        </form>
    </div>
</body>
</html>

<?php
// Procesar el formulario de checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $direccion_envio = $_POST['direccion_envio'];

    // Verificar stock
    foreach ($carrito as $producto) {
        if (!verificarStock($producto['id'], $producto['cantidad'])) {
            echo "No hay suficiente stock para el producto: {$producto['nombre']}. <a href='index.php'>Volver a la tienda</a>";
            exit();
        }
    }
    
    // Crear el pedido
    $pedido_id = crearPedido($usuario_id, $total, $direccion_envio);

    // Guardar las líneas del pedido y actualizar el stock
    foreach ($carrito as $producto) {
        crearLineaPedido($pedido_id, $producto['id'], $producto['cantidad'], $producto['precio']);
        actualizarStock($producto['id'], $producto['cantidad']);
        eliminarDelCarrito($usuario_id, $producto['id']);
    }
    include 'procesarCheckout.php';
    header('Location: pedidorealizado.php');
    exit();
}
?>