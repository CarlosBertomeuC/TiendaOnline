<?php
session_start();

include '../includes/header.php';
include '../config/db_functions.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para ver tu carrito. <a href='login.php'>Iniciar sesión</a>";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener los productos del carrito desde la base de datos
$carrito = obtenerCarrito($usuario_id);

// Actualizar cantidades o eliminar productos del carrito
if (isset($_POST['actualizar'])) {
    foreach ($_POST['cantidad'] as $producto_id => $cantidad) {
        if ($cantidad == 0) {
            eliminarDelCarrito($usuario_id, $producto_id); // Eliminar producto si cantidad es 0
        } else {
            actualizarCantidadCarrito($usuario_id, $producto_id, $cantidad); // Actualizar cantidad
        }
    }
    header("Location: carrito.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../assets/css/carrito.css">
</head>

<body>
    <?php
    // Verificar si el carrito está vacío
    if (empty($carrito)) {
        echo "<div class='carrito-vacio'>
                <p>Tu carrito está vacío.</p>
                <a href='index.php' class='boton-volver'>Volver a la tienda</a>
              </div>";
        exit;
    }
    ?>
    <div class="container">
        <h2>Carrito de Compras</h2>
        <form method="post">
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
                <?php
                $total = 0;
                foreach ($carrito as $producto) {
                    $precio = floatval($producto['precio']);
                    $cantidad = intval($producto['cantidad']);
                    $subtotal = $precio * $cantidad;
                    $total += $subtotal;
                    echo "<tr>";
                    echo "<td>{$producto['nombre']}</td>";
                    echo "<td>\${$precio}</td>";
                    echo "<td><input type='number' name='cantidad[{$producto['id']}]' value='{$cantidad}' min='0'></td>";
                    echo "<td>\${$subtotal}</td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td colspan="3">Total</td>
                    <td><?php echo "\${$total}"; ?></td>
                </tr>
            </table>
            <button type="submit" name="actualizar">Actualizar Carrito</button>
        </form>
        <a class="pagar" href="checkout.php">Proceder al Pago</a>
    </div>
</body>

</html>