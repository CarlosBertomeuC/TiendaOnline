<?php
session_start();
include '../config/db_functions.php';

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

    <!-- Explorar por categorías -->
    <section class="categorias">
        <h2>Explora por Categorías</h2>
        <div class="categorias-lista">
            <a href="productos.php" class="boton-todas-categorias">Todas las categorías</a>
            <?php foreach ($categorias as $categoria): ?>
                <a href="productos.php?categoria=<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nombre_categoria']); ?></a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Productos por categoría -->
    <section class="productos-categoria">
        <h2>Todos los productos</h2>
        <div class="productos">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
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
</body>
</html>