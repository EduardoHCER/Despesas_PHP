CREATE DATABASE IF NOT EXISTS controle_despesas;

USE controle_despesas;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL, -- Armazena o hash da senha
    email VARCHAR(100) NOT NULL UNIQUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de itens (despesas)
CREATE TABLE IF NOT EXISTS itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    valor DECIMAL(10, 2) NOT NULL,
    data_criacao DATE NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);