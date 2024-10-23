<?php

include '../config/database.php';
include '../config/db_functions.php';

$categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : null;
$productos = obtenerProductosPorCategoria($categoria_id);

if (!empty($productos)): 
    foreach ($productos as $producto): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="../uploads/productos/<?php echo $producto['id']; ?>.jpg" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                    <p class="card-text">€<?php echo number_format($producto['precioUnitario'], 2); ?></p>
                    <p class="card-text text-muted"><?php echo htmlspecialchars($producto['estado']); ?></p>
                    <a href="detalle_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-primary">Ver detalles</a>
                </div>
            </div>
        </div>
    <?php endforeach;
else: ?>
    <p class="text-center">No hay productos disponibles.</p>
<?php endif; ?>
