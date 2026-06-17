CREATE DATABASE IF NOT EXISTS clube_desportivo;
USE clube_desportivo;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('atleta', 'rececionista', 'gestor') DEFAULT 'atleta',
    documento VARCHAR(100),
    tipo_documento ENUM('Cartao de Cidadao', 'Passaporte', 'Outro') DEFAULT 'Cartao de Cidadao',
    nif VARCHAR(9),
    estado ENUM('ativo', 'inativo') DEFAULT 'ativo'
);

CREATE TABLE IF NOT EXISTS campos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_campo VARCHAR(100),
    estado ENUM('disponivel', 'manutencao') DEFAULT 'disponivel',
    valor DECIMAL(10,2),
    descricao TEXT,
    custo_iluminacao DECIMAL(10,2) DEFAULT 0.00,
    custo_aluguer_material DECIMAL(10,2) DEFAULT 0.00
);

CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_campo INT,
    id_user INT,
    data_hora DATE,
    hora_inicio TIME,
    hora_fim TIME,
    estado ENUM('ativa', 'cancelada') DEFAULT 'ativa',
    iluminacao TINYINT(1) DEFAULT 0,
    aluguer_material TINYINT(1) DEFAULT 0,
    check_in TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_campo) REFERENCES campos(id),
    FOREIGN KEY (id_user) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS pagamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT,
    id_user INT,
    data DATE,
    montante DECIMAL(10,2),
    tipo ENUM('parcial', 'total') DEFAULT 'total',
    operador INT,
    FOREIGN KEY (id_reserva) REFERENCES reservas(id),
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (operador) REFERENCES users(id)
);

INSERT INTO campos (tipo_campo, estado, valor, descricao, custo_iluminacao, custo_aluguer_material) VALUES
('Padel Coberto', 'disponivel', 15.00, 'Campo de padel coberto', 5.00, 3.00),
('Padel Descoberto', 'disponivel', 10.00, 'Campo de padel ao ar livre', 5.00, 3.00),
('Tenis Terra Batida', 'disponivel', 12.00, 'Campo de tenis em terra batida', 5.00, 2.00),
('Tenis Rapido', 'disponivel', 12.00, 'Campo de tenis em piso rapido', 5.00, 2.00);

UPDATE campos SET estado = 'manutencao' WHERE tipo_campo = 'Padel Descoberto';

INSERT INTO users (nome, email, password, role, estado) VALUES ('Rececionista', 'rececionista@clube.pt', '$2y$10$35Ycf3gDEOC9ztoMOzu4Q.TvFuGgNC1siJgoLRSA4zKXMM2UsZifq', 'rececionista', 'ativo');
INSERT INTO users (nome, email, password, role, estado) VALUES ('Gestor', 'gestor@clube.pt', '$2y$10$35Ycf3gDEOC9ztoMOzu4Q.TvFuGgNC1siJgoLRSA4zKXMM2UsZifq', 'gestor', 'ativo');
