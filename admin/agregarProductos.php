<?php
include '../config/db_functions.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precioUnitario = $_POST['precioUnitario'];
    $estado = $_POST['estado'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];

    // Procesar la imagen
    $imagen = $_FILES['imagen'];
    $imagenRuta = '../uploads/productos/' . basename($imagen['name']);
    move_uploaded_file($imagen['tmp_name'], $imagenRuta);

    // Guardar la ruta de la imagen en la base de datos
    $imagenRutaDB = 'uploads/productos/' . basename($imagen['name']);

    // Insertar el producto en la base de datos
    if (agregarProducto($nombre, $descripcion, $precioUnitario, $estado, $stock, $imagenRutaDB)) {
        // Obtener el ID del producto insertado
        $producto_id = $conn->insert_id;

        // Insertar la relación con la categoría
        $stmt = $conn->prepare("INSERT INTO ProductoCategorias (producto_id, categoria_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $producto_id, $categoria_id);
        $stmt->execute();

        echo "Producto subido exitosamente.";
    } else {
        echo "Error al subir el producto.";
    }
}

$categorias = obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
</head>
<body>
    <h1>Agregar Nuevo Producto</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Nombre del producto:</label><br>
        <input type="text" name="nombre" required><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" required></textarea><br>

        <label>Precio Unitario:</label><br>
        <input type="number" step="0.01" name="precioUnitario" required><br>

        <label>Estado:</label><br>
        <select name="estado" required>
            <option value="nuevo">Nuevo</option>
            <option value="usado">Usado</option>
        </select><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" required><br>

        <label for="categoria">Categoría:</label><br>
        <select name="categoria_id" required>
            <?php
            foreach ($categorias as $categoria) {
                echo "<option value='{$categoria['id']}'>{$categoria['nombre_categoria']}</option>";
            }
            ?>
        </select><br>

        <label for="imagen">Imagen del Producto:</label>
        <input type="file" id="imagen" name="imagen" required><br>

        <button type="submit">Agregar Producto</button>
    </form>
</body>
</html>
