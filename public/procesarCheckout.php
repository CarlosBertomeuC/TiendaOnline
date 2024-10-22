<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../libraries/PHPMailer-master/src/Exception.php';
require '../libraries/PHPMailer-master/src/PHPMailer.php';
require '../libraries/PHPMailer-master/src/SMTP.php';
require_once '../config/db_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $direccion_envio = $_POST['direccion_envio'];
    $usuario_id = $_SESSION['usuario_id'];
    $carrito = obtenerCarrito($usuario_id); // Asumiendo que tienes una función para obtener el carrito del usuario

    // Verificar stock
    foreach ($carrito as $producto) {
        if (!verificarStock($producto['id'], $producto['cantidad'])) {
            echo "No hay suficiente stock para el producto: {$producto['nombre']}. <a href='index.php'>Volver a la tienda</a>";
            exit();
        }
    }

    // Guardar las líneas del pedido y actualizar el stock
    foreach ($carrito as $producto) {
        crearLineaPedido($pedido_id, $producto['id'], $producto['cantidad'], $producto['precio']);
        actualizarStock($producto['id'], $producto['cantidad']);
        eliminarDelCarrito($usuario_id, $producto['id']);
    }

    // Obtener los detalles del pedido y los productos
    $productos_pedido = obtenerProductosPedido($pedido_id);

    // Construir el cuerpo del correo electrónico
    $body = "<h1>Hola, $nombre</h1>";
    $body .= "<p>Gracias por tu pedido en nuestra tienda. Aquí están los detalles de tu pedido:</p>";
    $body .= "<h2>Detalles del Pedido</h2>";
    $body .= "<p>Número de Pedido: $pedido_id</p>";
    $body .= "<p>Dirección de Envío: $direccion_envio</p>";
    $body .= "<p>Total: $total €</p>";
    $body .= "<h2>Productos</h2>";
    $body .= "<ul>";

    foreach ($productos_pedido as $producto) {
        $body .= "<li>";
        $body .= "<p>Nombre: {$producto['nombre']}</p>";
        $body .= "<p>Cantidad: {$producto['cantidad']}</p>";
        $body .= "<p>Precio: {$producto['precioUnitario']} €</p>";
        $body .= "<p>Total: " . ($producto['cantidad'] * $producto['precioUnitario']) . " €</p>";
        $body .= "</li>";
    }

    $body .= "</ul>";

    // Enviar correo electrónico de confirmación de pedido
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Cambia esto por tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'carlosbertomeu44@gmail.com'; // Cambia esto por tu correo
        $mail->Password = 'djtu nctv wdoj zanf'; // Cambia esto por tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('carlosbertomeu44@gmail.com', 'MadKoi'); // Cambia esto por tu correo y nombre
        $mail->addAddress(obtenerEmailUsuario($usuario_id)); // Asumiendo que tienes una función para obtener el email del usuario

        $mail->isHTML(true);
        $mail->Subject = 'Confirmacion de Pedido';
        $mail->Body = $body;

        $mail->send();
        echo "Correo de confirmacion enviado.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }

    header('Location: pedidorealizado.php');
    exit();
}
?>