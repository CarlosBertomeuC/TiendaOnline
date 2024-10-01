<?php
include 'db_functions.php';

// ------------------------
// Creación de un usuario vendedor
// ------------------------
$nombreVendedor = "Carlos";
$apellidosVendedor = "González";
$emailVendedor = "carlos.gonzalez@example.com";
$contraseñaVendedor = "vendedor123";
$rolVendedor = "administrador";
$telefonoVendedor = "987654321";

if (registrarUsuario($nombreVendedor, $apellidosVendedor, $emailVendedor, $contraseñaVendedor, $rolVendedor, $telefonoVendedor)) {
    echo "Vendedor registrado correctamente.<br>";
} else {
    echo "Error al registrar vendedor.<br>";
}

// ID del vendedor recien creado (el ultimo usuario creado)
$vendedor_id = $conn->insert_id;  // Obtenemos el último ID insertado

// ------------------------
// Creación de productos
// ------------------------
$nombreProducto1 = "PlayStation 5";
$descripcion1 = "Consola de videojuegos de nueva generación de Sony";
$precioUnitario1 = 499.99;
$estado1 = "nuevo";
$stock1 = 20;

if (agregarProducto($nombreProducto1, $descripcion1, $precioUnitario1, $estado1, $stock1, $vendedor_id)) {
    echo "Producto PlayStation 5 agregado correctamente.<br>";
} else {
    echo "Error al agregar PlayStation 5.<br>";
}

$nombreProducto2 = "Xbox Series X";
$descripcion2 = "Consola de videojuegos de nueva generación de Microsoft";
$precioUnitario2 = 499.99;
$estado2 = "nuevo";
$stock2 = 15;

if (agregarProducto($nombreProducto2, $descripcion2, $precioUnitario2, $estado2, $stock2, $vendedor_id)) {
    echo "Producto Xbox Series X agregado correctamente.<br>";
} else {
    echo "Error al agregar Xbox Series X.<br>";
}

// ------------------------
// Prueba para registrar un cliente
// ------------------------
$nombreCliente = "Juan";
$apellidosCliente = "Pérez";
$emailCliente = "juan.perez@example.com";
$contraseñaCliente = "cliente123";
$rolCliente = "cliente";
$telefonoCliente = "123456789";

if (registrarUsuario($nombreCliente, $apellidosCliente, $emailCliente, $contraseñaCliente, $rolCliente, $telefonoCliente)) {
    echo "Cliente registrado correctamente.<br>";
} else {
    echo "Error al registrar cliente.<br>";
}

// Lo mismo que antes, obtenemos el ID del cliente recien creado
$usuario_id = $conn->insert_id;

// ------------------------
// Prueba para agregar un producto al carrito del cliente
// ------------------------
$producto_id = 1;  // ID 1=PlayStation 5
$cantidad = 2;

if (agregarAlCarrito($usuario_id, $producto_id, $cantidad)) {
    echo "Producto agregado al carrito correctamente.<br>";
} else {
    echo "Error al agregar producto al carrito.<br>";
}

// ------------------------
// Prueba para obtener el carrito del cliente
// ------------------------
$carrito = obtenerCarrito($usuario_id);
if (!empty($carrito)) {
    echo "Carrito del usuario:<br>";
    foreach ($carrito as $item) {
        echo "Producto: " . $item['nombre'] . " - Cantidad: " . $item['cantidad'] . "<br>";
    }
} else {
    echo "El carrito está vacío.<br>";
}

$conn->close();
?>
