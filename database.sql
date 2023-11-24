-- Criação do banco de dados
CREATE DATABASE sistema_de_frequencia_atualizado;

-- Seleciona o banco de dados
USE sistema_de_frequencia_atualizado;

-- Criação da tabela de alunos
CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    students_nome VARCHAR(100) NOT NULL,
    students_data_nascimento DATE NOT NULL,
    students_email VARCHAR(100),
    students_telefone VARCHAR(20)
);

-- Criação da tabela de responsaveis
CREATE TABLE responsaveis (
    guardian_id INT AUTO_INCREMENT PRIMARY KEY,
    guardian_nome VARCHAR(100) NOT NULL,
    guardian_data_nascimento DATE NOT NULL,
    guardian_email VARCHAR(100),
    guardian_telefone VARCHAR(20),
    guardian_endereco VARCHAR(200),
    aluno_id INT,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id)
);

-- Criação da tabela de frequencias
CREATE TABLE frequencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,
    presenca ENUM('presenca', 'falta') NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id)
);