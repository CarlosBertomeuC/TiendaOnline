<header>
<link rel="stylesheet" href="../assets/css/header.css">
    <div class="navbar">
        <img class="logo" src="../assets/images/logo.png" alt="Logo de la tienda">
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            
            <?php
                if (isset($_SESSION['rol']) && $_SESSION['rol'] != 'administrador') { ?>
                    <li><a href="productos.php">Tienda</a></li>
                    <li><a href="carrito.php">Carrito</a></li>
                <?php } ?>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="user-icon">
                    <img src="../assets/images/user-icon.jpg" alt="Usuario" id="user-icon">
                    <div class="user-menu" id="user-menu">
                        <a href="perfil.php">Ver Perfil</a>
                        <a href="../public/logout.php">Cerrar Sesión</a>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <source><script src="../assets/js/header.js"></script>
</header>
