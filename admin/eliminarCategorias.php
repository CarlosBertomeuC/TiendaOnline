<?php
include '../config/db_functions.php';
session_start();

// Verificar si el usuario es administrador
if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

$id = $_GET['id'];

if (eliminarCategoria($id)) {
    header('Location: categorias.php');
} else {
    echo "Error al eliminar la categoría.";
}
?>
