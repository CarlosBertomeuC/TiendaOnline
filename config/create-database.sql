-- Eliminar la base de datos si ya existe
DROP DATABASE IF EXISTS tienda_videojuegos;

-- Crear la base de datos
CREATE DATABASE tienda_videojuegos;
USE tienda_videojuegos;

-- Eliminar tablas si ya existen
DROP TABLE IF EXISTS ProductoCategorias;
DROP TABLE IF EXISTS Productos;
DROP TABLE IF EXISTS Categorias;
DROP TABLE IF EXISTS Usuarios;
DROP TABLE IF EXISTS Pedidos;
DROP TABLE IF EXISTS LineaPedidos;
DROP TABLE IF EXISTS Carrito;
DROP TABLE IF EXISTS Reseñas;
DROP TABLE IF EXISTS Tarjetas;

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
CREATE TABLE Carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'carrito',
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (producto_id) REFERENCES Productos(id)
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

-- Tabla Tarjetas
CREATE TABLE Tarjetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    numero_tarjeta VARCHAR(16) NOT NULL,
    fecha_expiracion VARCHAR(5) NOT NULL,
    cvv VARCHAR(3) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE
);

-- Inserts para la tabla Usuarios
INSERT INTO Usuarios (nombre, apellidos, email, contraseña, rol, telefono) VALUES
('Juan', 'Pérez', 'juan.perez@example.com', 'password123', 'cliente', '123456789'),
('María', 'Gómez', 'maria.gomez@example.com', 'password123', 'cliente', '987654321'),
('Carlos', 'López', 'carlos.lopez@example.com', 'password123', 'administrador', '456789123');

-- Inserts para la tabla Productos
INSERT INTO Productos (nombre, descripcion, precioUnitario, estado, stock, imagen) VALUES
('Camiseta', 'Camiseta de algodón', 19.99, 'nuevo', 50, 'imagenes/camiseta.jpg'),
('Pantalones', 'Pantalones de mezclilla', 39.99, 'nuevo', 30, 'imagenes/pantalones.jpg'),
('Zapatos', 'Zapatos de cuero', 59.99, 'nuevo', 20, 'imagenes/zapatos.jpg');

-- Inserts para la tabla Categorias
INSERT INTO Categorias (nombre_categoria) VALUES
('Ropa'),
('Calzado'),
('Accesorios');

-- Inserts para la tabla ProductoCategorias
INSERT INTO ProductoCategorias (producto_id, categoria_id) VALUES
(1, 1), -- Camiseta en Ropa
(2, 1), -- Pantalones en Ropa
(3, 2); -- Zapatos en Calzado

-- Inserts para la tabla Pedidos
INSERT INTO Pedidos (usuario_id, precioTotal, direccion_envio, estado) VALUES
(1, 59.97, 'Calle Falsa 123', 'carrito'),
(2, 119.97, 'Avenida Siempre Viva 742', 'enviado');

-- Inserts para la tabla LineaPedidos
INSERT INTO LineaPedidos (pedido_id, producto_id, cantidad, precioUnitario) VALUES
(1, 1, 3, 19.99), -- 3 Camisetas en el pedido 1
(2, 2, 2, 39.99), -- 2 Pantalones en el pedido 2
(2, 3, 1, 59.99); -- 1 Par de Zapatos en el pedido 2

-- Inserts para la tabla Carrito
INSERT INTO Carrito (usuario_id, producto_id, cantidad, estado) VALUES
(1, 1, 2, 'carrito'), -- 2 Camisetas en el carrito del usuario 1
(2, 2, 1, 'carrito'); -- 1 Pantalón en el carrito del usuario 2

-- Inserts para la tabla Reseñas
INSERT INTO Reseñas (usuario_id, producto_id, calificacion, comentario) VALUES
(1, 1, '5', 'Excelente calidad, muy cómoda.'),
(2, 2, '4', 'Buena calidad, pero un poco caro.'),
(1, 3, '3', 'Los zapatos son bonitos, pero no muy cómodos.');

-- Inserts para la tabla Tarjetas
INSERT INTO Tarjetas (usuario_id, numero_tarjeta, fecha_expiracion, cvv) VALUES
(1, '1234567812345678', '12/23', '123'),
(2, '8765432187654321', '11/24', '321');