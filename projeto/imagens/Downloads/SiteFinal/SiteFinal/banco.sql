-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Jul-2022 às 01:51
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Banco de dados: `biblioteca`
--
CREATE DATABASE IF NOT EXISTS `biblioteca` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `biblioteca`;
-- --------------------------------------------------------

--
-- Estrutura da tabela `autora`
--

CREATE TABLE IF NOT EXISTS `autora` (
  `id_autora` int(11) NOT NULL AUTO_INCREMENT,
  `nome_autora` varchar(30) NOT NULL,
  PRIMARY KEY (`id_autora`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `autoraref`
--

CREATE TABLE IF NOT EXISTS `autoraref` (
  `id_autora_fk` int(11) NOT NULL,
  `id_livro_fk` int(11) NOT NULL,
  KEY `id_autora_fk` (`id_autora_fk`),
  KEY `id_livro_fk` (`id_livro_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `editora`
--

CREATE TABLE IF NOT EXISTS `editora` (
  `id_editora` int(11) NOT NULL AUTO_INCREMENT,
  `nome_editora` varchar(50) NOT NULL,
  PRIMARY KEY (`id_editora`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `emprestimo`
--

CREATE TABLE IF NOT EXISTS `emprestimo` (
  `id_emprestimo` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente_fk` int(11) NOT NULL,
  `id_exemplar_fk` int(11) NOT NULL,
  `emprestimo` date NOT NULL,
  `devolucao` date DEFAULT NULL,
  PRIMARY KEY (`id_emprestimo`),
  KEY `id_cliente_fk` (`id_cliente_fk`),
  KEY `id_exemplar_fk` (`id_exemplar_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `exemplar`
--

CREATE TABLE IF NOT EXISTS `exemplar` (
  `id_exemplar` int(11) NOT NULL AUTO_INCREMENT,
  `id_livro_fk` int(11) NOT NULL,
  `desativado` int(11) NOT NULL,
  PRIMARY KEY (`id_exemplar`),
  KEY `id_livro_fk` (`id_livro_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `genero`
--

CREATE TABLE IF NOT EXISTS `genero` (
  `id_genero` int(11) NOT NULL AUTO_INCREMENT,
  `genero` varchar(30) NOT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

CREATE TABLE IF NOT EXISTS `livro` (
  `id_livro` int(11) NOT NULL AUTO_INCREMENT,
  `id_editora_fk` int(11) NOT NULL,
  `nome_livro` varchar(40) NOT NULL,
  `sinopse` varchar(2500) NOT NULL,
  `genero_fk` int(11) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `imagem` varchar(70) NOT NULL,
  `acessos` int(11) NOT NULL,
  PRIMARY KEY (`id_livro`),
  KEY `id_editora_fk` (`id_editora_fk`),
  KEY `genero_fk` (`genero_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `multa`
--

CREATE TABLE IF NOT EXISTS `multa` (
  `id_emprestimo_fk` int(11) NOT NULL,
  `id_cliente_fk` int(11) NOT NULL,
  `valor` float NOT NULL,
  KEY `id_emprestimo_fk` (`id_emprestimo_fk`),
  KEY `id_cliente_fk` (`id_cliente_fk`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva`
--

CREATE TABLE IF NOT EXISTS `reserva` (
  `id_cliente_fk` int(11) NOT NULL,
  `id_exemplar_fk` int(11) NOT NULL,
  `reserva` date NOT NULL,
  KEY `id_cliente_fk` (`id_cliente_fk`),
  KEY `id_exemplar_fk` (`id_exemplar_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` varchar(15) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `bloqueado` int(1) DEFAULT NULL,
  `cep` int(8) NOT NULL,
  `nascimento` date NOT NULL,
  `tipo` int(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `autoraref`
--
ALTER TABLE `autoraref`
  ADD CONSTRAINT `autoraref_ibfk_1` FOREIGN KEY (`id_autora_fk`) REFERENCES `autora` (`id_autora`),
  ADD CONSTRAINT `autoraref_ibfk_2` FOREIGN KEY (`id_livro_fk`) REFERENCES `livro` (`id_livro`);

--
-- Limitadores para a tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD CONSTRAINT `emprestimo_ibfk_1` FOREIGN KEY (`id_cliente_fk`) REFERENCES `usuario` (`id_cliente`),
  ADD CONSTRAINT `emprestimo_ibfk_2` FOREIGN KEY (`id_exemplar_fk`) REFERENCES `exemplar` (`id_exemplar`);

--
-- Limitadores para a tabela `exemplar`
--
ALTER TABLE `exemplar`
  ADD CONSTRAINT `exemplar_ibfk_1` FOREIGN KEY (`id_livro_fk`) REFERENCES `livro` (`id_livro`);

--
-- Limitadores para a tabela `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `livro_ibfk_1` FOREIGN KEY (`id_editora_fk`) REFERENCES `editora` (`id_editora`),
  ADD CONSTRAINT `livro_ibfk_2` FOREIGN KEY (`genero_fk`) REFERENCES `genero` (`id_genero`);

--
-- Limitadores para a tabela `multa`
--
ALTER TABLE `multa`
  ADD CONSTRAINT `multa_ibfk_1` FOREIGN KEY (`id_emprestimo_fk`) REFERENCES `emprestimo` (`id_emprestimo`),
  ADD CONSTRAINT `multa_ibfk_2` FOREIGN KEY (`id_cliente_fk`) REFERENCES `usuario` (`id_cliente`),
  ADD CONSTRAINT `multa_ibfk_3` FOREIGN KEY (`id_cliente_fk`) REFERENCES `usuario` (`id_cliente`);

--
-- Limitadores para a tabela `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`id_cliente_fk`) REFERENCES `usuario` (`id_cliente`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`id_exemplar_fk`) REFERENCES `exemplar` (`id_exemplar`);
COMMIT;
