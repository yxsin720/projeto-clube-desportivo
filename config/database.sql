CREATE DATABASE IF NOT EXISTS clube_desportivo;
USE clube_desportivo;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE campos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_campo VARCHAR(100) NOT NULL,
    estado VARCHAR(50) DEFAULT 'disponivel',
    valor DECIMAL(10,2) NOT NULL
);

CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_campo INT NOT NULL,
    id_user INT NOT NULL,
    data_hora DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,
    estado VARCHAR(50) DEFAULT 'ativa',
    FOREIGN KEY (id_campo) REFERENCES campos(id),
    FOREIGN KEY (id_user) REFERENCES users(id)
);

CREATE TABLE pagamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT NOT NULL,
    id_user INT NOT NULL,
    data DATE NOT NULL,
    montante DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_reserva) REFERENCES reservas(id),
    FOREIGN KEY (id_user) REFERENCES users(id)
);
