-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Fev-2023 às 15:40
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `arduino`
--
CREATE DATABASE IF NOT EXISTS `arduino` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `arduino`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aparelho`
--

DROP TABLE IF EXISTS `aparelho`;
CREATE TABLE `aparelho` (
  `id_aparelho` int(11) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT 1,
  `nome_aparelho` varchar(50) NOT NULL,
  `relay` int(11) DEFAULT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `automatic_action`
--

DROP TABLE IF EXISTS `automatic_action`;
CREATE TABLE `automatic_action` (
  `id_action` int(11) NOT NULL,
  `id_aparelho_fk` int(11) NOT NULL,
  `execute` int(2) NOT NULL DEFAULT 1,
  `hour` time NOT NULL,
  `action` varchar(3) NOT NULL,
  `repeat_action` varchar(6) NOT NULL,
  `starting_day` date DEFAULT NULL,
  `last_day` date DEFAULT NULL,
  `weekly` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registro`
--

DROP TABLE IF EXISTS `registro`;
CREATE TABLE `registro` (
  `id_registro` int(11) NOT NULL,
  `id_usuario_fk` int(11) NOT NULL,
  `id_aparelho_fk` int(11) NOT NULL,
  `operacao` int(11) NOT NULL,
  `hora` time NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT 1,
  `nome_usuario` varchar(100) NOT NULL,
  `email` varchar(256) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `senha` varchar(20) NOT NULL,
  `permissao` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_aparelho`
--

DROP TABLE IF EXISTS `usuario_aparelho`;
CREATE TABLE `usuario_aparelho` (
  `id_usuario_fk` int(11) NOT NULL,
  `id_aparelho_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aparelho`
--
ALTER TABLE `aparelho`
  ADD PRIMARY KEY (`id_aparelho`);

--
-- Índices para tabela `automatic_action`
--
ALTER TABLE `automatic_action`
  ADD PRIMARY KEY (`id_action`);

--
-- Índices para tabela `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `Id_ususuario_fk` (`id_usuario_fk`),
  ADD KEY `id_aparelho_fk` (`id_aparelho_fk`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `usuario_aparelho`
--
ALTER TABLE `usuario_aparelho`
  ADD PRIMARY KEY (`id_usuario_fk`,`id_aparelho_fk`),
  ADD KEY `id_aparelho_fk` (`id_aparelho_fk`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aparelho`
--
ALTER TABLE `aparelho`
  MODIFY `id_aparelho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `automatic_action`
--
ALTER TABLE `automatic_action`
  MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `registro`
--
ALTER TABLE `registro`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `registro_ibfk_1` FOREIGN KEY (`id_usuario_fk`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `registro_ibfk_2` FOREIGN KEY (`id_aparelho_fk`) REFERENCES `aparelho` (`id_aparelho`);

--
-- Limitadores para a tabela `usuario_aparelho`
--
ALTER TABLE `usuario_aparelho`
  ADD CONSTRAINT `usuario_aparelho_ibfk_1` FOREIGN KEY (`id_usuario_fk`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `usuario_aparelho_ibfk_2` FOREIGN KEY (`id_aparelho_fk`) REFERENCES `aparelho` (`id_aparelho`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
