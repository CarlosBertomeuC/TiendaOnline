<?php
session_start();
include '../config/database.php';
include '../config/db_functions.php';

// Obtener productos y categorías
$categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : null;
$productos = obtenerProductosPorCategoria($categoria_id);
$categorias = obtenerCategorias();
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

    <!-- Banner promocional -->
    <div class="banner">
        <img src="../assets/images/banner.jpg" alt="Promociones">
    </div>

    <!-- Ofertas especiales -->
    <section class="ofertas-especiales">
        <h2>Ofertas Especiales</h2>
        <div class="productos">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <img src="../uploads/productos/<?php echo $producto['imagen']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                        <p>€<?php echo number_format($producto['precioUnitario'], 2); ?></p>
                        <a href="detalle_producto.php?id=<?php echo $producto['id']; ?>">Ver detalles</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Explorar por categorías -->
    <section class="categorias">
        <h2>Explora por Categorías</h2>
        <div class="categorias-lista">
            <?php foreach ($categorias as $categoria): ?>
                <a href="index.php?categoria=<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nombre_categoria']); ?></a>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
