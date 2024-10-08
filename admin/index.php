<?php
session_start();
include '../includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../public/login.php");
    exit();
}

if ($_SESSION['rol'] !== 'administrador') {
    header("Location: ../public/login.php");
    exit();
}

echo "<h1>Bienvenido al Panel de Administración</h1>";
echo "<p>Usuario: " . $_SESSION['nombre'] . "</p>";
echo "<p>Rol: " . $_SESSION['rol'] . "</p>";
?>
<button><a href='listarProductos.php'>Productos</a></button>
<button><a href='listarCategorias.php'>Categorías</a></button>
<button><a href='../public/logout.php'>Cerrar Sesión</a></button>