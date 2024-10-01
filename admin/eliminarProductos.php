<?php
include '../config/db_functions.php';
session_start();
if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

$id = $_GET['id'];

if (eliminarProducto($id)) {
    header('Location: productos.php');
} else {
    echo "Error al eliminar el producto.";
}
?>
