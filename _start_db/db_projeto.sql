-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 05/10/2019 às 18:59
-- Versão do servidor: 10.1.36-MariaDB
-- Versão do PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_projeto`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `ID` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `conteudo_aprendido`
--

CREATE TABLE `conteudo_aprendido` (
  `ID` int(11) NOT NULL,
  `id_usuario` int(255) NOT NULL,
  `id_conteudo` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `conteudo_compartilhado`
--

CREATE TABLE `conteudo_compartilhado` (
  `ID` int(11) NOT NULL,
  `id_usuario` varchar(255) NOT NULL,
  `id_categoria` varchar(255) NOT NULL,
  `curtidas` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` varchar(255) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `pergunta1` varchar(255) NOT NULL,
  `resposta11` varchar(255) NOT NULL,
  `resposta12` varchar(255) NOT NULL,
  `resposta13` varchar(255) NOT NULL,
  `resposta14` varchar(255) NOT NULL,
  `pergunta2` varchar(255) NOT NULL,
  `resposta21` varchar(255) NOT NULL,
  `resposta22` varchar(255) NOT NULL,
  `resposta23` varchar(255) NOT NULL,
  `resposta24` varchar(255) NOT NULL,
  `pergunta3` varchar(255) NOT NULL,
  `resposta31` varchar(255) NOT NULL,
  `resposta32` varchar(255) NOT NULL,
  `resposta33` varchar(255) NOT NULL,
  `resposta34` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `options`
--

CREATE TABLE `options` (
  `ID` int(11) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `permission_value` int(11) NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `blocked` tinyint(1) NOT NULL,
  `pontuacao_respondido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `conteudo_aprendido`
--
ALTER TABLE `conteudo_aprendido`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `conteudo_compartilhado`
--
ALTER TABLE `conteudo_compartilhado`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conteudo_aprendido`
--
ALTER TABLE `conteudo_aprendido`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conteudo_compartilhado`
--
ALTER TABLE `conteudo_compartilhado`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `options`
--
ALTER TABLE `options`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
