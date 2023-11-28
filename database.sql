DROP DATABASE plataformascarrillo;
CREATE DATABASE plataformascarrillo;
USE plataformascarrillo;
CREATE TABLE marca(
    id_marca INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50)
);
CREATE TABLE estilo(
    id_estilo INT AUTO_INCREMENT PRIMARY KEY,
    estilo VARCHAR(50)
);
CREATE TABLE tipo(
    id_tipo INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(200),
    id_estilo INT,
    CONSTRAINT estilo_tipo_FK FOREIGN KEY (id_estilo) REFERENCES estilo(id_estilo)
);
CREATE TABLE modelo(
    id_modelo INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(50),
    descripcion TEXT,
    id_marca INT,
    imagen VARCHAR(150),
    id_tipo INT,
    CONSTRAINT marca_modelo_FK FOREIGN KEY (id_marca) REFERENCES marca(id_marca),
    CONSTRAINT tipo_modelo_FK FOREIGN KEY (id_tipo) REFERENCES tipo(id_tipo)
);
CREATE TABLE plataforma(
    no_economico VARCHAR(250) PRIMARY KEY,
    id_modelo INT,
    preventico DATE,
    id INT,
    CONSTRAINT maquina_plataforma_FK FOREIGN KEY(id_modelo) REFERENCES modelo(id_modelo)
);
CREATE TABLE rol(
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    rol VARCHAR(150)
);
CREATE TABLE usuario(
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(150) UNIQUE,
    contrasena VARCHAR(32),
    correo VARCHAR(100) UNIQUE
);
CREATE TABLE persona(
    id_persona INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    primer_apellido VARCHAR(50),
    segundo_apellido VARCHAR(50),
    telefono VARCHAR(13),
    direccion TEXT,
    id_usuario INT,
    id_rol INT,
    CONSTRAINT usuario_persona_FK FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    CONSTRAINT rol_persona_FK FOREIGN KEY (id_rol) REFERENCES rol(id_rol)
);
CREATE TABLE compra(
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    id_persona INT,
    fecha DATE,
    CONSTRAINT persona_compra_FK FOREIGN KEY (id_persona) REFERENCES persona(id_persona)
);
CREATE TABLE compra_detalle(
    id_compra INT,
    no_economico VARCHAR(250),
    cantidad INT,
    precio DECIMAL(10, 2),
    descuento DECIMAL(2, 2),
    PRIMARY KEY(id_compra, no_economico),
    CONSTRAINT compra_compra_detalle_FK FOREIGN KEY (id_compra) REFERENCES compra (id_compra),
    CONSTRAINT plataforma_compra_detalle_FK FOREIGN KEY (no_economico) REFERENCES plataforma (no_economico)
);
CREATE TABLE carrito(
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_persona INT,
    no_economico VARCHAR(250),
    cantidad INT,
    fecha DATE,
    precio DECIMAL(10, 2),
    descuento DECIMAL(2, 2),
    CONSTRAINT persona_carrito_FK FOREIGN KEY(id_persona) REFERENCES persona(id_persona),
    CONSTRAINT plataforma_carrito_FK FOREIGN KEY (no_economico) REFERENCES plataforma(no_economico)
);