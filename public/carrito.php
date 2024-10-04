<?php
session_start();
include '../includes/header.php';
// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "Tu carrito está vacío. <a href='index.php'>Volver a la tienda</a>";
    exit;
}

// Actualizar cantidades o eliminar productos del carrito
if (isset($_POST['actualizar'])) {
    foreach ($_POST['cantidad'] as $producto_id => $cantidad) {
        if ($cantidad == 0) {
            unset($_SESSION['carrito'][$producto_id]); // Eliminar producto si cantidad es 0
        } else {
            $_SESSION['carrito'][$producto_id]['cantidad'] = $cantidad; // Actualizar cantidad
        }
    }
    header("Location: carrito.php");
    exit;
}
?>
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
        foreach ($_SESSION['carrito'] as $producto) {
            $precio = floatval($producto['precio']);
            $cantidad = intval($producto['cantidad']);
            $subtotal = $precio * $cantidad;
            $total += $subtotal;
        ?>
        <tr>
            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
            <td><?php echo htmlspecialchars($precio); ?></td>
            <td>
                <input type="number" name="cantidad[<?php echo $producto['id']; ?>]" value="<?php echo htmlspecialchars($cantidad); ?>" min="0">
            </td>
            <td><?php echo htmlspecialchars($subtotal); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3">Total</td>
            <td><?php echo htmlspecialchars($total); ?></td>
        </tr>
    </table>
    <button type="submit" name="actualizar">Actualizar Carrito</button>
</form>