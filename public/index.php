<?php
session_start();
include '../config/database.php';
include '../config/db_functions.php';

// Si hay categoría seleccionada
$categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : null;
$productos = obtenerProductosPorCategoria($categoria_id);

// Obtiene todas las categorías para mostrarlas
$categorias = obtenerCategorias();

include '../includes/header.php'; // Incluimos el header
?>

<!-- Banner promocional -->
<div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="../assets/images/banner.jpg" class="d-block w-100" alt="Promociones">
        </div>
        <!-- Más imágenes en el carrusel si lo deseas -->
    </div>
</div>

<!-- Ofertas especiales -->
<section class="mb-5">
    <h2 class="text-center mb-4">Ofertas Especiales</h2>
    <div id="productos" class="row">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
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
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay productos disponibles.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Categorías con filtro -->
<section class="mb-5">
    <h2 class="text-center mb-4">Explora por Categorías</h2>
    <div class="row">
        <?php foreach ($categorias as $categoria): ?>
            <div class="col-md-3 mb-4">
                <button class="btn btn-secondary w-100 filtro-categoria" data-id="<?php echo $categoria['id']; ?>">
                    <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Scripts para cargar los productos dinámicamente con AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.filtro-categoria').click(function() {
            var categoriaId = $(this).data('id');

            $.ajax({
                url: 'filtro_productos.php',
                type: 'GET',
                data: { categoria: categoriaId },
                success: function(response) {
                    $('#productos').html(response); // Actualiza los productos sin recargar
                }
            });
        });
    });
</script>


<?php include '../includes/footer.php'; // Incluimos el footer ?>
