-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Dez-2022 às 13:33
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `olifx`
--

CREATE DATABASE IF NOT EXISTS `olifx`;
USE `olifx`;
-- --------------------------------------------------------

--
-- Estrutura da tabela `favorite`
--

CREATE TABLE `favorite` (
  `idUser` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `date_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `media`
--

CREATE TABLE `media` (
  `idProduct` int(11) NOT NULL,
  `path` varchar(100) NOT NULL,
  `idMedia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `media`
--

INSERT INTO `media` (`idProduct`, `path`, `idMedia`) VALUES
(0, '6399b79bb04d8.jpg', 12),
(1, '6399b7aa49da1.jpg', 13),
(2, '6399b82b62c8d.jpg', 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `product`
--

CREATE TABLE `product` (
  `idProduct` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `date_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `product`
--

INSERT INTO `product` (`idProduct`, `idUser`, `title`, `description`, `price`, `date_time`) VALUES
(0, 3, 'Pombo', 'richalisonnnn', '1000.00', '2022-12-14'),
(1, 3, 'omnitrix', 'teste', '500.00', '2022-12-14'),
(2, 3, 'caneta azul', 'azul caneta', '10000000.00', '2022-12-14'),
(3, 3, 'teste sem media', 'rgeggrtegtr', '100.00', '2022-12-14'),
(4, 3, 'Caneta azul 2.0', 'teste', '20000.00', '2022-12-14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cellphone` varchar(100) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `profilePic` varchar(100) DEFAULT 'default.jpg',
  `password` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`idUser`, `email`, `cellphone`, `fullName`, `profilePic`, `password`, `city`) VALUES
(1, 'theuspersch@gmail.com', '(51) 99883-9655', 'teste', 'default.jpg', '$2y$10$kprnZQhIRPRMcIL53mthDeAWVaojwRZmDOhfcblyc2L/h469LnVii', 'teste'),
(2, 'xxx@xxx', '(11) 11111111-1111', 'Teste supremo', '63874ac01c4ec.jpg', '$2y$10$CAGLT3ORLj3nq99u.HpRR.03tg5qkVsrn/BJZ4pK6q1Wy.17Eiw1a', 'teste'),
(3, 'dicionario16@gmail.com', '(51) 99883-9655', 'Matheus Persch', '63906d31da2c3.jpg', '$2y$10$3R7KmQMXNOvZejlGki3QyO3P.Tj2GuBeLOEoIRYJi7AyS7VT4M0oO', 'Bom Principio');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`idUser`,`idProduct`),
  ADD KEY `FK_UserFavorite` (`idUser`),
  ADD KEY `FK_ProductFavorite` (`idProduct`);

--
-- Índices para tabela `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`idMedia`);

--
-- Índices para tabela `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idProduct`),
  ADD KEY `FK_UserProduct` (`idUser`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `media`
--
ALTER TABLE `media`
  MODIFY `idMedia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `FK_ProductFavorite` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`),
  ADD CONSTRAINT `FK_UserFavorite` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Limitadores para a tabela `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_UserProduct` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
