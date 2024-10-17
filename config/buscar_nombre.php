<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'tienda_videojuegos';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM productos");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($productos)) {
        echo json_encode(['error' => 'No se encontraron productos.']);
    } else {
        header('Content-Type: application/json');
        echo json_encode($productos);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => "Error: " . $e->getMessage()]);
}