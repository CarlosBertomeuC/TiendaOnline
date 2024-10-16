<?php
include '../config/db_functions.php';

$nombres = obtenerNombresProductos();
echo json_encode($nombres);

function obtenerNombresProductos() {
    global $conn;
    $sql = "SELECT nombre FROM Productos";
    $result = $conn->query($sql);
    $nombres = [];
    while ($row = $result->fetch_assoc()) {
        $nombres[] = $row['nombre'];
    }
    return $nombres;
}
?>