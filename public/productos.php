<?php
session_start();
include '../config/db_functions.php';
include '../includes/header.php';

$categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : null;
$precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : 0;
$precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : 1000;

$productos = obtenerProductosPorCategoriaYPrecio($categoria_id, $precio_min, $precio_max);
$categorias = obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="../assets/css/productos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css">
</head>
<body>
    <section class="filtros">
        <h2>Filtros</h2>
        <a href="productos.php">Limpiar Filtros</a>
        <!-- Explorar por categorías -->
        <section class="categorias">
            <h2>Explora por Categorías</h2>
            <div class="categorias-lista">
                <select id="categoria-select">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nombre_categoria']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </section>

        <!-- Explorar por precio -->
        <section class="precio">
            <h2>Filtrar por Precio</h2>
            <div class="filtro-precio">
                <div id="rango-precio" data-min="<?php echo $precio_min; ?>" data-max="<?php echo $precio_max; ?>"></div>
                <p>Rango de precio: <span id="rango-precio-valor"><?php echo $precio_min; ?> - <?php echo $precio_max; ?></span>€</p>
            </div>
        </section>

        <button id="aplicar-filtros">Aplicar Filtros</button>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js"></script>
    <script src="../assets/js/precio.js"></script>
</body>
</html>