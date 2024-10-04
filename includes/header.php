<header>
    <div class="navbar">
        <div class="logo">
            <h1><a href="index.php">Tienda de Videojuegos</a></h1>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="carrito.php">Carrito</a></li>
            <li><a href="checkout.php">Finalizar Compra</a></li>
            <?php if (isset($_SESSION['usuario'])): ?>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>
