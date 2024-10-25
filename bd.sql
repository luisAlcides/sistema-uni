
CREATE DATABASE IF NOT EXISTS solicitud_medios_uni;
USE solicitud_medios_uni;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'profesor') NOT NULL
);

CREATE TABLE IF NOT EXISTS medios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

CREATE TABLE IF NOT EXISTS solicitudes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    medio_id INT NOT NULL,
    fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'aprobado', 'rechazado') DEFAULT 'pendiente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (medio_id) REFERENCES medios(id)
);

ALTER TABLE solicitudes
ADD COLUMN fecha_uso DATE NULL,
ADD COLUMN hora_inicio TIME NULL,
ADD COLUMN hora_fin TIME NULL;
