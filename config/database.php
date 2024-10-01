<?php
$servername = "localhost"; 
$username = "root";         // Nombre de usuario por defecto es root
$password = "";             // Sin contraseña por defecto en XAMPP
$dbname = "tienda_videojuegos";  // Reemplaza con el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>