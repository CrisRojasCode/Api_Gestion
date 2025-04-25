DROP DATABASE if exists VivePuntarenasAzul;

create DATABASE VivePuntarenasAzul;

use VivePuntarenasAzul;


CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    clave VARCHAR(255) NOT NULL
);

CREATE TABLE galeria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
    categoria VARCHAR(50),
    archivo VARCHAR(255)
);

CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
    descripcion TEXT,
    fecha DATE,
    hora_inicio TIME,
    hora_fin TIME,
    lugar VARCHAR(255),
    categoria VARCHAR(50),
    participantes INT DEFAULT 0,
    imagen VARCHAR(255)
);