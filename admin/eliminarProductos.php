<?php
session_start();

include '../config/db_functions.php';

if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

$id = $_GET['id'];

if (eliminarProducto($id)) {
    header('Location: listarProductos.php');
} else {
    echo "Error al eliminar el producto.";
}
?>
