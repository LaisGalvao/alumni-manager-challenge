-- Dumping database structure and data
CREATE DATABASE IF NOT EXISTS `db_alumni_challenge`;
USE `db_alumni_challenge`;

-- Creating tables
CREATE TABLE `alunos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `turmas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `descricao` TEXT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `matriculas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `aluno_id` INT NOT NULL,
    `turma_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`aluno_id`) REFERENCES `alunos`(`id`),
    FOREIGN KEY (`turma_id`) REFERENCES `turmas`(`id`)
);

CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') DEFAULT 'user',
    PRIMARY KEY (`id`)
);

-- Inserting data
INSERT INTO `alunos` (`nome`, `email`) VALUES
('João Silva', 'joao.silva@example.com'),
('Maria Oliveira', 'maria.oliveira@example.com');

INSERT INTO `turmas` (`nome`, `descricao`) VALUES
('Turma A', 'Descrição da Turma A'),
('Turma B', 'Descrição da Turma B');

INSERT INTO `matriculas` (`aluno_id`, `turma_id`) VALUES
(1, 1),
(2, 2);

-- Inserting users with 'user' role by default
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Admin User', 'admin@example.com', 'adminpassword', 'admin'),
('Regular User', 'user@example.com', 'userpassword', 'user'),
('Another User', 'anotheruser@example.com', 'anotherpassword', 'user');
