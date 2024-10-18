<?php
session_start();
include '../config/db_functions.php';

$categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : null;
$productos = obtenerProductosPorCategoria($categoria_id);
$categorias = obtenerCategorias();
$productosRecientes = obtenerProductosRecientes();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Videojuegos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <div class="main">
        <!-- Banner promocional -->
        <div class="banner">
            <img src="../uploads/extra/baner.png" alt="Promociones">
        </div>

        <!-- Ofertas especiales -->
        <section class="ofertas-especiales">
            <h2>Ofertas Especiales</h2>
            <div class="productos">
                <?php if (!empty($productosRecientes)): ?>
                    <?php foreach ($productosRecientes as $producto): ?>
                        <div class="producto">
                            <img src="../<?php echo $producto['imagen']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p><?php echo number_format($producto['precioUnitario'], 2); ?>€</p>
                            <a href="detalle_producto.php?id=<?php echo $producto['id']; ?>">Ver detalles</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay productos disponibles.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>

</html>