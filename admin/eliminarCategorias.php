<?php
session_start();

include '../config/db_functions.php';

if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

$id = $_GET['id'];

if (eliminarCategoria($id)) {
    header('Location: listarCategorias.php');
} else {
    echo "Error al eliminar la categoría.";
}
?>
