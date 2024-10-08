<header>
<link rel="stylesheet" href="../assets/css/styles.css">
    <div class="navbar">
        <div class="logo">
            <h1><a href="index.php">Tienda de Videojuegos</a></h1>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <?php
                if (isset($_SESSION['rol']) && $_SESSION['rol'] != 'administrador') { ?>
                    <li><a href="carrito.php">Carrito</a></li>
                    <li><a href="checkout.php">Finalizar Compra</a></li>
                <?php }?>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li><a href="../public/logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>
