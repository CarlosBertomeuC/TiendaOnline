<?php
session_start();

include '../config/db_functions.php';

//Comprobaciones varias
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
    $total += $producto['precio'] * $producto['cantidad'];
}

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
<h2>Checkout</h2>
<form method="post" action="checkout.php">
    <label for="direccion_envio">Dirección de Envío:</label>
    <input type="text" name="direccion_envio" required>
    
    <p>Total a pagar: €<?php echo $total; ?></p>
    
    <button type="submit">Confirmar Pedido</button>
</form>
