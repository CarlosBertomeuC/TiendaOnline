<?php
session_start();

include '../config/db_functions.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$usuario = obtenerUsuarioPorId($usuario_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    // Verificar si el email ya existe en la base de datos
    if (emailExiste($email, $usuario_id)) {
        $error = "El email ya está registrado.";
    } else {
        actualizarUsuario($usuario_id, $nombre, $apellidos, $email, $telefono);
        header('Location: perfil.php');
        exit();
    }
}

function obtenerUsuarioPorId($id) {
    global $conn;
    $sql = "SELECT * FROM Usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function emailExiste($email, $usuario_id) {
    global $conn;
    $sql = "SELECT id FROM Usuarios WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $email, $usuario_id);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

function actualizarUsuario($id, $nombre, $apellidos, $email, $telefono) {
    global $conn;
    $sql = "UPDATE Usuarios SET nombre = ?, apellidos = ?, email = ?, telefono = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $nombre, $apellidos, $email, $telefono, $id);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../assets/css/perfil.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="main">
    <h1>Perfil de Usuario</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="perfil.php">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
        
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
        
        <button type="submit">Actualizar</button>
    </form>
    </div>
</body>
</html>