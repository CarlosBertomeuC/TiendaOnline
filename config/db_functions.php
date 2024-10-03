<?php
include 'database.php';

// Los if estan para comprabar si la consulta se ejecuto correctamente
// Función para registrar un nuevo usuario
function registrarUsuario($nombre, $apellidos, $email, $contraseña, $rol, $telefono) {
    global $conn;  // lo mismo que pasarlo como parametro

    $stmt = $conn->prepare("INSERT INTO Usuarios (nombre, apellidos, email, contraseña, rol, telefono) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);  // Encriptamos la contraseña
        $stmt->bind_param("ssssss", $nombre, $apellidos, $email, $hashed_password, $rol, $telefono);
        return $stmt->execute(); 
    } else {
        return false;
    }
}

// Función para agregar un producto
function agregarProducto($nombre, $descripcion, $precioUnitario, $estado, $stock, $vendedor_id) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO Productos (nombre, descripcion, precioUnitario, estado, stock, vendedor_id) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssdsii", $nombre, $descripcion, $precioUnitario, $estado, $stock, $vendedor_id);
        return $stmt->execute();
    } else {
        return false;
    }
}

// Función para obtener productos
function obtenerProductos() {
    global $conn;

    $result = $conn->query("SELECT * FROM Productos");
    return $result->fetch_all(MYSQLI_ASSOC);
}
//Funcion para obtener productos por categoria
function obtenerProductosPorCategoria($categoria_id = null) {
    global $conn;
    if ($categoria_id) {
        $sql = "SELECT * FROM Productos 
                JOIN ProductoCategorias ON Productos.id = ProductoCategorias.producto_id
                WHERE ProductoCategorias.categoria_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        return obtenerProductos();
    }
}

// Función para obtener productos por vendedor
function obtenerProductoPorId($id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Productos WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } else {
        return [];
    }
}

// Función para actualizar un producto
function actualizarProducto($id, $nombre, $descripcion, $precioUnitario, $estado, $stock) {
    global $conn;

    $stmt = $conn->prepare("UPDATE Productos SET nombre = ?, descripcion = ?, precioUnitario = ?, estado = ?, stock = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ssdsi", $nombre, $descripcion, $precioUnitario, $estado, $stock);
        return $stmt->execute();
    } else {
        return false;
    }
}

// Función para eliminar un producto
function eliminarProducto($id) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM Productos WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    } else {
        return false;
    }
}

// Función para agregar un producto al carrito
function agregarAlCarrito($usuario_id, $producto_id, $cantidad) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO Carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("iii", $usuario_id, $producto_id, $cantidad);
        return $stmt->execute();
    } else {
        return false;
    }
}

// Función para obtener el carrito de un usuario
function obtenerCarrito($usuario_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT Productos.nombre, Carrito.cantidad FROM Carrito INNER JOIN Productos ON Carrito.producto_id = Productos.id WHERE Carrito.usuario_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Obtener todas las categorías
function obtenerCategorias() {
    global $conn;
    $sql = "SELECT * FROM Categorias";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Obtener una categoría por ID
function obtenerCategoriaPorId($id) {
    global $conn;
    $sql = "SELECT * FROM Categorias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Agregar una nueva categoría
function agregarCategoria($nombre_categoria) {
    global $conn;
    $sql = "INSERT INTO Categorias (nombre_categoria) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $nombre_categoria);
    return $stmt->execute();
}

// Actualizar una categoría existente
function actualizarCategoria($id, $nombre_categoria) {
    global $conn;
    $sql = "UPDATE Categorias SET nombre_categoria = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $nombre_categoria, $id);
    return $stmt->execute();
}

// Eliminar una categoría
function eliminarCategoria($id) {
    global $conn;
    $sql = "DELETE FROM Categorias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}
// Función para obtener un usuario por email
function obtenerUsuarioPorEmail($email) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();//hacerlo asi porque devuelve un objeto, no un booleano
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function guardarCarritoEnBD($usuario_id, $carrito) {
    global $conn;
    foreach ($carrito as $producto_id => $producto) {
        $sql = "INSERT INTO Carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE cantidad = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $usuario_id, $producto_id, $producto['cantidad'], $producto['cantidad']);
        $stmt->execute();
    }
}

// Función para crear un pedido
function crearPedido($usuario_id, $precioTotal, $direccion_envio) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO Pedidos (usuario_id, precioTotal, direccion_envio, estado) VALUES (?, ?, ?, 'pendiente')");
    $stmt->bind_param("ids", $usuario_id, $precioTotal, $direccion_envio);
    
    if ($stmt->execute()) {
        return $stmt->insert_id; // Devolver el ID del pedido recién creado
    } else {
        die("Error al crear el pedido: " . $stmt->error);
    }
}

// Función para crear una línea de pedido
function crearLineaPedido($pedido_id, $producto_id, $cantidad, $precioUnitario) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO LineaPedidos (pedido_id, producto_id, cantidad, precioUnitario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $pedido_id, $producto_id, $cantidad, $precioUnitario);
    
    if (!$stmt->execute()) {
        die("Error al crear la línea de pedido: " . $stmt->error);
    }
}

?>
