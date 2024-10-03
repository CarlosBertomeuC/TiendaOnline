<?php
include '../config/db_functions.php';
session_start();

// Verificar si el usuario es administrador
if ($_SESSION['rol'] != 'administrador') {
    header('Location: ../public/login.php');
    exit();
}

$id = $_GET['id'];
$categoria = obtenerCategoriaPorId($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_categoria = $_POST['nombre_categoria'];

    if (actualizarCategoria($id, $nombre_categoria)) {
        header('Location: categorias.php');
    } else {
        echo "Error al actualizar la categoría.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
</head>
<body>
    <h1>Editar Categoría</h1>
    <form action="" method="post">
        <label>Nombre de la categoría:</label><br>
        <input type="text" name="nombre_categoria" value="<?php echo $categoria['nombre_categoria']; ?>" required><br>
        <button type="submit">Actualizar Categoría</button>
    </form>
</body>
</html>
