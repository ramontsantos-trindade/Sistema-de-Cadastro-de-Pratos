CREATE DATABASE restauranteramonrebeca;
USE restauranteramonrebeca;

CREATE TABLE pratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    descricao VARCHAR(100),
    preco DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(100),
);