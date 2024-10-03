<?php
session_start();

// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "Tu carrito está vacío.";
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
            $subtotal = $producto['precio'] * $producto['cantidad'];
            $total += $subtotal;
            ?>
            <tr>
                <td><?php echo $producto['nombre']; ?></td>
                <td>€<?php echo $producto['precio']; ?></td>
                <td>
                    <input type="number" name="cantidad[<?php echo $producto['id']; ?>]" value="<?php echo $producto['cantidad']; ?>" min="0">
                </td>
                <td>€<?php echo $subtotal; ?></td>
            </tr>
        <?php } ?>
    </table>

    <p>Total: €<?php echo $total; ?></p>

    <button type="submit" name="actualizar">Actualizar Carrito</button>
    <a href="checkout.php">Proceder al Pago</a>
</form>
