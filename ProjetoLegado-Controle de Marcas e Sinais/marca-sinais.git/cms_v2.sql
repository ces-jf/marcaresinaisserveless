-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 07/06/2013 às 15:13:29
-- Versão do Servidor: 5.5.27
-- Versão do PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Banco de Dados: `cms_v2`
--
CREATE DATABASE `cms_v2` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `cms_v2`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_certificados`
--

CREATE TABLE IF NOT EXISTS `cms_certificados` (
  `idcertificado` int(100) NOT NULL AUTO_INCREMENT,
  `certificado` varchar(17) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `localidade` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `produtor` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `data_certificado` date NOT NULL,
  `hora_certificado` time NOT NULL,
  `sequencia` int(100) NOT NULL,
  `numero` int(100) NOT NULL,
  `caminho` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idcertificado`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `cms_certificados`
--

INSERT INTO `cms_certificados` (`idcertificado`, `certificado`, `tipo`, `localidade`, `produtor`, `cpf`, `data_certificado`, `hora_certificado`, `sequencia`, `numero`, `caminho`) VALUES
(1, '', 'm', 'teste', 'Fulano', '11111', '2012-11-28', '12:46:00', 1, 1, 'marca/20121128112407.jpg'),
(2, '', 'm', 'teste', 'Fulano', '11111', '2012-11-28', '12:57:12', 1, 1, 'marca/20121128112407.jpg'),
(3, '', 'm', 'teste', 'Fulano', '11111', '2012-11-28', '13:00:17', 1, 1, 'marca/20121128112407.jpg'),
(4, '', 'm', 'teste', 'Fulano', '11111', '2012-11-28', '13:01:18', 1, 1, 'marca/20121128112407.jpg'),
(5, '', 's', 'teste', 'Fulano', '11111', '2012-11-28', '13:03:52', 1, 1, 'sinal/20121128124212.jpg'),
(6, '', 'm', 'Teste', 'Fulano', '11111', '2012-11-28', '13:34:00', 1, 1, 'marca/20121128112407.jpg'),
(7, '', 'm', 'Teste', 'Fulano', '11111', '2013-06-07', '09:43:14', 1, 1, 'marca/20121128112407.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_localidades`
--

CREATE TABLE IF NOT EXISTS `cms_localidades` (
  `idlocalidade` int(100) NOT NULL AUTO_INCREMENT,
  `localidade` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idlocalidade`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `cms_localidades`
--

INSERT INTO `cms_localidades` (`idlocalidade`, `localidade`) VALUES
(2, 'Teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_logacessos`
--

CREATE TABLE IF NOT EXISTS `cms_logacessos` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_marcas`
--

CREATE TABLE IF NOT EXISTS `cms_marcas` (
  `idmarca` int(100) NOT NULL AUTO_INCREMENT,
  `numero` int(200) NOT NULL,
  `idprodutor` int(100) NOT NULL,
  `idlocalidade` int(100) NOT NULL,
  `caminho` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `data_cadastro` date NOT NULL,
  `ch_figura` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `ch_letra` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `ch_numero` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idmarca`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `cms_marcas`
--

INSERT INTO `cms_marcas` (`idmarca`, `numero`, `idprodutor`, `idlocalidade`, `caminho`, `data_cadastro`, `ch_figura`, `ch_letra`, `ch_numero`) VALUES
(1, 1, 3, 2, 'marca/20121128112407.jpg', '2012-11-28', 's', 'n', 's');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_produtores`
--

CREATE TABLE IF NOT EXISTS `cms_produtores` (
  `idprodutor` int(100) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `ie` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idlocalidade` int(100) NOT NULL,
  `endereco` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`idprodutor`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `cms_produtores`
--

INSERT INTO `cms_produtores` (`idprodutor`, `nome`, `cpf`, `ie`, `idlocalidade`, `endereco`, `telefone`, `data_cadastro`) VALUES
(3, 'Fulano', '11111', '22222', 2, 'Rua teste', '53-33331111', '2012-11-28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_sinais`
--

CREATE TABLE IF NOT EXISTS `cms_sinais` (
  `idsinal` int(100) NOT NULL AUTO_INCREMENT,
  `numero` int(100) NOT NULL,
  `idprodutor` int(100) NOT NULL,
  `idlocalidade` int(100) NOT NULL,
  `caminho` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`idsinal`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `cms_sinais`
--

INSERT INTO `cms_sinais` (`idsinal`, `numero`, `idprodutor`, `idlocalidade`, `caminho`, `data_cadastro`) VALUES
(3, 1, 3, 2, 'sinal/20121128130428.jpg', '2012-11-28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_usuarios`
--

CREATE TABLE IF NOT EXISTS `cms_usuarios` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `login` int(50) NOT NULL,
  `senha` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tentativas` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `cms_usuarios`
--

INSERT INTO `cms_usuarios` (`id`, `login`, `senha`, `nome`, `tentativas`) VALUES
(1, 123, '202cb962ac59075b964b07152d234b70', 'teste', 0);

