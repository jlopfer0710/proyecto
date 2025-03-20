CREATE DATABASE MotorClick_DB;
USE MotorClick_DB;
CREATE TABLE usuarios (
id INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(100) NOT NULL,
usuario VARCHAR(100) NOT NULL,
apellidos VARCHAR(200) NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
telefono VARCHAR(20),
password VARCHAR(255) NOT NULL,
tipo ENUM('cliente', 'admin') DEFAULT 'cliente',
fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE servicios (
id INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(100) NOT NULL,
descripcion TEXT,
duracion INT NOT NULL,
precio DECIMAL(10,2) NOT NULL
);

CREATE TABLE reservas (
id INT PRIMARY KEY AUTO_INCREMENT,
usuario_id INT NOT NULL,
servicio_id INT NOT NULL,
fecha DATE NOT NULL,
hora TIME NOT NULL,
motivo TEXT NOT NULL,
estado ENUM('pendiente', 'cancelada') DEFAULT 'pendiente',
creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nombre, usuario, apellidos, email, telefono, password, tipo)
VALUES ('admin', 'admin', 'admin', 'admin@motorclick.com', '600000000', '1618', 'admin');
ALTER TABLE reservas AUTO_INCREMENT = 1;/*sentencia para reiniciar el contador del id*/
CREATE USER `admin` IDENTIFIED BY 'admin';
GRANT ALL ON `MotorClick_DB`.* TO `admin`;
INSERT INTO servicios (nombre, descripcion, duracion, precio)
VALUES ('Revision completa', 'Se realizara una revision completa del vehiculo', '1', '120');
ALTER TABLE Usuarios AUTO_INCREMENT =1;
ALTER TABLE reservas ADD localizador VARCHAR(50) AFTER hora;
mysql -u usuario -p MotorClick_DB
