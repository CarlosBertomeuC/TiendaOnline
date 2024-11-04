DROP DATABASE IF EXISTS tienda_videojuegos;
CREATE DATABASE tienda_videojuegos;
USE tienda_videojuegos;

DROP TABLE IF EXISTS ProductoCategorias;
DROP TABLE IF EXISTS Productos;
DROP TABLE IF EXISTS Categorias;
DROP TABLE IF EXISTS Usuarios;

-- Tabla Usuarios
CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    rol ENUM('cliente', 'administrador') NOT NULL,
    telefono VARCHAR(15)
);

-- Tabla Productos
CREATE TABLE Productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precioUnitario FLOAT NOT NULL,
    estado ENUM('nuevo', 'usado') NOT NULL,
    stock INT NOT NULL,
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    imagen VARCHAR(255) NOT NULL
);

-- Tabla Categorias
CREATE TABLE Categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL
);

-- Tabla ProductoCategorias (relación muchos a muchos entre Productos y Categorias)
CREATE TABLE ProductoCategorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT,
    categoria_id INT,
    FOREIGN KEY (producto_id) REFERENCES Productos(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id) ON DELETE CASCADE
);

-- Tabla Pedidos
CREATE TABLE Pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    precioTotal FLOAT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    direccion_envio VARCHAR(255),
    estado ENUM('carrito', 'enviado', 'entregado') NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE SET NULL
);

-- Tabla LineaPedidos
CREATE TABLE LineaPedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    producto_id INT,
    cantidad INT NOT NULL,
    precioUnitario FLOAT NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES Pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES Productos(id) ON DELETE CASCADE
);

-- Tabla Carrito
CREATE TABLE carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'carrito',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Tabla Reseñas
CREATE TABLE Reseñas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    producto_id INT,
    calificacion ENUM('1', '2', '3', '4', '5') NOT NULL,
    comentario TEXT,
    fecha_resena DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES Productos(id) ON DELETE CASCADE
);

--Tabla Tarjetas
CREATE TABLE Tarjetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    numero_tarjeta VARCHAR(16) NOT NULL,
    fecha_expiracion VARCHAR(5) NOT NULL,
    cvv VARCHAR(3) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE
);