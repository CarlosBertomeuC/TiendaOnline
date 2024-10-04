<?php
session_start();
include '../includes/header.php';
include '../config/db_functions.php';

// Comprobaciones varias
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "Tu carrito está vacío. <a href='index.php'>Volver a la tienda</a>";
    exit();
}

if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para realizar un pedido. <a href='login.php'>Iniciar sesión</a>";
    exit();
}

// Obtener el total del carrito
$total = 0;
foreach ($_SESSION['carrito'] as $producto) {
    $precio = floatval($producto['precio']);
    $cantidad = intval($producto['cantidad']);
    $total += $precio * $cantidad;
}

// Mostrar los productos del carrito
echo "<h1>Tu Carrito</h1>";
echo "<table border='1'>";
echo "<tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th></tr>";
foreach ($_SESSION['carrito'] as $producto) {
    $precio = floatval($producto['precio']);
    $cantidad = intval($producto['cantidad']);
    $totalProducto = $precio * $cantidad;
    echo "<tr>";
    echo "<td>{$producto['nombre']}</td>";
    echo "<td>\${$precio}</td>";
    echo "<td>{$cantidad}</td>";
    echo "<td>\${$totalProducto}</td>";
    echo "</tr>";
}
echo "<tr><td colspan='3'>Total</td><td>\${$total}</td></tr>";
echo "</table>";

// Procesar el formulario de checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $direccion_envio = $_POST['direccion_envio'];
    $usuario_id = $_SESSION['usuario_id'];
    
    // Crear el pedido
    $pedido_id = crearPedido($usuario_id, $total, $direccion_envio);

    // Guardar las líneas del pedido
    foreach ($_SESSION['carrito'] as $producto) {
        crearLineaPedido($pedido_id, $producto['id'], $producto['cantidad'], $producto['precio']);
    }

    // Vaciar el carrito
    unset($_SESSION['carrito']);
    
    echo "Pedido realizado con éxito. <a href='index.php'>Volver a la tienda</a>";
    exit();
}
?>

<!-- Formulario de checkout -->
<h2>Dirección de Envío</h2>
<form method="POST" action="">
    <label for="direccion_envio">Dirección de Envío:</label>
    <input type="text" id="direccion_envio" name="direccion_envio" required>
    <br>
    <button type="submit">Realizar Pedido</button>
</form>