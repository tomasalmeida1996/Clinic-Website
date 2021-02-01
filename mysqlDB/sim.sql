-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: 16-Dez-2018 às 23:04
-- Versão do servidor: 10.3.9-MariaDB
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sim`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultas`
--

DROP TABLE IF EXISTS `consultas`;
CREATE TABLE IF NOT EXISTS `consultas` (
  `IdConsulta` int(11) NOT NULL AUTO_INCREMENT,
  `IdUtilizador` int(11) NOT NULL,
  `IdFichaUtente` int(11) NOT NULL,
  `TipoConsulta` varchar(30) NOT NULL,
  `Classificacao` varchar(30) NOT NULL,
  `PercentagemCalc` float NOT NULL,
  `Recomendacao` varchar(50) NOT NULL,
  `DataConsulta` date NOT NULL,
  `Concluida` tinyint(1) NOT NULL,
  `DataUltAlteracao` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdConsulta`),
  KEY `FK_IdUtilizadorConsulta` (`IdUtilizador`),
  KEY `FK_IdFichaUtente` (`IdFichaUtente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `consultas`
--

INSERT INTO `consultas` (`IdConsulta`, `IdUtilizador`, `IdFichaUtente`, `TipoConsulta`, `Classificacao`, `PercentagemCalc`, `Recomendacao`, `DataConsulta`, `Concluida`, `DataUltAlteracao`) VALUES
(1, 3, 5, 'AntesTratamento', 'Nao', 48.3, 'Sim', '2018-12-15', 1, '2018-12-15 03:58:58'),
(2, 3, 7, 'AntesTratamento', 'Nao', 48.3, 'Nao', '2018-12-16', 1, '2018-12-16 03:26:27'),
(3, 3, 6, 'PÃ³sTratamento', 'Nao', 48.3, 'Nao', '2018-12-16', 1, '2018-12-16 03:39:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fichasutente`
--

DROP TABLE IF EXISTS `fichasutente`;
CREATE TABLE IF NOT EXISTS `fichasutente` (
  `IdFichaUtente` int(11) NOT NULL AUTO_INCREMENT,
  `IdUtente` int(11) NOT NULL,
  `DuracaoInf` float NOT NULL,
  `Causa` int(1) NOT NULL,
  `IMCElemF` float NOT NULL,
  `AFC` float NOT NULL,
  `F_Tabaco` int(1) NOT NULL,
  `M_Tabaco` int(1) NOT NULL,
  `M_Etnia` int(1) NOT NULL,
  `Historico` tinyint(1) NOT NULL,
  `DataCriacao` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdFichaUtente`),
  KEY `FK_IdUtente_Ficha` (`IdUtente`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fichasutente`
--

INSERT INTO `fichasutente` (`IdFichaUtente`, `IdUtente`, `DuracaoInf`, `Causa`, `IMCElemF`, `AFC`, `F_Tabaco`, `M_Tabaco`, `M_Etnia`, `Historico`, `DataCriacao`) VALUES
(1, 1, 20, 1, 20.4, 20, 1, 1, 1, 1, '2018-12-14 20:40:24'),
(2, 1, 21, 1, 21.7, 20, 3, 3, 4, 1, '2018-12-14 20:52:24'),
(3, 1, 20.9, 8, 3.5, 5.2, 3, 3, 6, 1, '2018-12-14 20:54:54'),
(4, 1, 20.9, 8, 3.5, 5.2, 3, 3, 6, 1, '2018-12-14 20:59:29'),
(5, 1, 100.4, 2, 24.5, 85.4, 1, 3, 6, 1, '2018-12-14 21:00:06'),
(6, 1, 20, 2, 20, 20, 1, 1, 1, 1, '2018-12-15 19:02:35'),
(7, 2, 104, 2, 22.4, 29, 2, 1, 2, 1, '2018-12-16 03:15:13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionalidades`
--

DROP TABLE IF EXISTS `funcionalidades`;
CREATE TABLE IF NOT EXISTS `funcionalidades` (
  `IdFuncionalidade` int(11) NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(100) NOT NULL,
  `NomeMenu` varchar(30) NOT NULL,
  `UrlDestino` varchar(100) NOT NULL,
  `MenuPai` int(11) DEFAULT NULL,
  `DataUltAlteracao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdFuncionalidade`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionalidades`
--

INSERT INTO `funcionalidades` (`IdFuncionalidade`, `Descricao`, `NomeMenu`, `UrlDestino`, `MenuPai`, `DataUltAlteracao`) VALUES
(1, 'Página Inicial', 'Home', 'index.php?operacao=homepage', NULL, '2018-11-27 03:45:42'),
(2, 'Listar Utilizadores indicando o ID, nome, data de\r\nnascimento e o perfil\r\n', 'Listar Utilizadores', 'index.php?operacao=ListarUtilizadores&page=1', NULL, '2018-11-29 23:46:39'),
(3, 'Registar novo Utilizador do tipo Obstetra / Investigador', 'Registar Utilizador', 'index.php?operacao=RegistarUtilizador', NULL, '2018-11-27 20:22:02'),
(4, 'Registar novo Utente', 'Registar Utente', 'index.php?operacao=RegistarUtente', NULL, '2018-11-27 20:22:02'),
(5, 'Registar os parâmetros do utente', 'Introduzir Parametros', 'index.php?operacao=OpcaoParametros', NULL, '2018-12-14 19:42:11'),
(6, 'Visualizar a ficha de um Utilizador', 'Visualizar Utilizador', 'index.php?operacao=ListarUtilizadores', NULL, '2018-11-30 06:01:44'),
(7, 'Visualizar a ficha de um Utente', 'Visualizar Utente', 'index.php?operacao=ListarUtentes', NULL, '2018-12-07 01:04:18'),
(8, 'Editar ficha de um Utilizador', 'Editar Utilizador', 'index.php?operacao=ListarUtilizadores', NULL, '2018-11-30 01:15:20'),
(9, 'Editar ficha de um Utente', 'Editar Utente', 'index.php?operacao=ListarUtentes', NULL, '2018-12-07 01:04:27'),
(10, 'Desativar utilizadores', 'Desativar utilizadores', 'index.php?operacao=DesativarUtilizadores', NULL, '2018-11-27 20:22:02'),
(11, 'Adicionar parâmetros clínicos', 'Adicionar Parametros', 'index.php?operacao=AdicionarParametros', NULL, '2018-11-27 20:22:02'),
(12, 'Registo de consulta (classificação e recomendações\r\nclínicas)', 'Nova Consulta', 'index.php?operacao=ListarUtentes&consulta=1', NULL, '2018-12-14 21:26:54'),
(13, 'Enviar mail ao utente com os seus dados', 'Enviar email', 'index.php?operacao=EnviarEmail', NULL, '2018-11-27 20:22:02'),
(14, 'Mostrar estatísticas', 'Mostrar estatisticas', 'index.php?operacao=MostraEstatisticas', NULL, '2018-11-29 16:19:20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `parametros`
--

DROP TABLE IF EXISTS `parametros`;
CREATE TABLE IF NOT EXISTS `parametros` (
  `IdParametro` int(11) NOT NULL AUTO_INCREMENT,
  `IdParametroPai` int(11) DEFAULT NULL,
  `Descricao` varchar(50) NOT NULL,
  `DescricaoAbrev` varchar(30) DEFAULT NULL,
  `ValorAssociado` varchar(30) DEFAULT NULL,
  `DataCriacao` datetime NOT NULL DEFAULT current_timestamp(),
  `Ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`IdParametro`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `parametros`
--

INSERT INTO `parametros` (`IdParametro`, `IdParametroPai`, `Descricao`, `DescricaoAbrev`, `ValorAssociado`, `DataCriacao`, `Ativo`) VALUES
(1, NULL, 'Geral', 'Geral', NULL, '2018-12-14 18:13:49', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tiposutilizadores`
--

DROP TABLE IF EXISTS `tiposutilizadores`;
CREATE TABLE IF NOT EXISTS `tiposutilizadores` (
  `IdTipoUtilizador` int(11) NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(100) NOT NULL,
  `Configuracoes` varchar(1000) DEFAULT NULL,
  `Visivel` bit(1) NOT NULL,
  `DataAlteracao` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdTipoUtilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tiposutilizadores`
--

INSERT INTO `tiposutilizadores` (`IdTipoUtilizador`, `Descricao`, `Configuracoes`, `Visivel`, `DataAlteracao`) VALUES
(1, 'Administrador', NULL, b'1', '2018-11-24 23:28:33'),
(2, 'Utente', NULL, b'1', '2018-11-25 20:47:17'),
(3, 'Obstetra', NULL, b'1', '2018-11-25 20:47:17'),
(4, 'Investigador', NULL, b'1', '2018-11-25 20:47:17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tiposutilizadorfuncionalidade`
--

DROP TABLE IF EXISTS `tiposutilizadorfuncionalidade`;
CREATE TABLE IF NOT EXISTS `tiposutilizadorfuncionalidade` (
  `IdTiposUtilizadorFuncionalidade` int(11) NOT NULL AUTO_INCREMENT,
  `IdTipoUtilizador` int(11) NOT NULL,
  `IdFuncionalidade` int(11) NOT NULL,
  `Ver` bit(1) NOT NULL,
  `Criar` bit(1) NOT NULL,
  `Editar` bit(1) NOT NULL,
  `Eliminar` bit(1) NOT NULL,
  `Ativo` bit(1) NOT NULL,
  `DataUltAlteracao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdTiposUtilizadorFuncionalidade`),
  KEY `FK_F_IdTipoUtilizador` (`IdTipoUtilizador`),
  KEY `FK_IdFuncionalidade` (`IdFuncionalidade`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tiposutilizadorfuncionalidade`
--

INSERT INTO `tiposutilizadorfuncionalidade` (`IdTiposUtilizadorFuncionalidade`, `IdTipoUtilizador`, `IdFuncionalidade`, `Ver`, `Criar`, `Editar`, `Eliminar`, `Ativo`, `DataUltAlteracao`) VALUES
(1, 1, 1, b'0', b'1', b'1', b'1', b'1', '2018-11-27 03:28:45'),
(2, 2, 1, b'0', b'0', b'0', b'0', b'1', '2018-11-27 03:28:45'),
(3, 3, 1, b'0', b'0', b'0', b'0', b'1', '2018-11-27 03:28:45'),
(4, 4, 1, b'0', b'0', b'0', b'0', b'1', '2018-11-27 03:28:45'),
(5, 1, 2, b'0', b'0', b'0', b'0', b'1', '2018-11-29 16:15:40'),
(6, 1, 3, b'0', b'1', b'0', b'0', b'1', '2018-11-29 16:15:40'),
(7, 1, 4, b'0', b'1', b'0', b'0', b'0', '2018-12-16 00:59:34'),
(8, 1, 5, b'0', b'1', b'0', b'0', b'0', '2018-12-16 00:54:39'),
(9, 1, 6, b'1', b'0', b'0', b'0', b'1', '2018-11-30 06:00:56'),
(10, 1, 7, b'1', b'0', b'0', b'0', b'1', '2018-11-30 06:00:56'),
(11, 1, 8, b'0', b'0', b'1', b'0', b'1', '2018-11-29 16:15:40'),
(12, 1, 9, b'0', b'0', b'1', b'0', b'1', '2018-11-29 16:15:40'),
(13, 1, 10, b'0', b'0', b'0', b'1', b'1', '2018-11-29 16:15:40'),
(14, 1, 11, b'0', b'1', b'0', b'0', b'1', '2018-11-29 16:15:40'),
(15, 1, 12, b'0', b'1', b'0', b'0', b'1', '2018-11-29 16:15:40'),
(16, 1, 13, b'0', b'0', b'0', b'0', b'1', '2018-11-29 16:15:40'),
(17, 1, 14, b'1', b'0', b'0', b'0', b'1', '2018-11-30 06:00:56'),
(18, 2, 5, b'0', b'1', b'0', b'0', b'1', '2018-12-07 01:29:27'),
(19, 2, 7, b'1', b'0', b'0', b'0', b'1', '2018-12-07 01:29:27'),
(20, 2, 9, b'0', b'0', b'1', b'0', b'1', '2018-12-07 01:29:27'),
(21, 2, 11, b'0', b'1', b'0', b'0', b'1', '2018-12-07 01:29:27'),
(22, 3, 2, b'0', b'0', b'0', b'0', b'1', '2018-12-07 23:53:34'),
(23, 3, 3, b'0', b'1', b'0', b'0', b'1', '2018-12-07 23:53:34'),
(24, 3, 6, b'1', b'0', b'0', b'0', b'1', '2018-12-07 23:53:34'),
(25, 3, 7, b'1', b'0', b'0', b'0', b'1', '2018-12-07 23:53:34'),
(26, 3, 8, b'0', b'0', b'1', b'0', b'1', '2018-12-07 23:53:34'),
(27, 3, 10, b'0', b'0', b'0', b'1', b'1', '2018-12-07 23:53:34'),
(28, 3, 12, b'0', b'1', b'0', b'0', b'1', '2018-12-07 23:53:34'),
(29, 3, 13, b'0', b'1', b'0', b'0', b'1', '2018-12-07 23:53:34'),
(30, 4, 2, b'0', b'0', b'0', b'0', b'1', '2018-12-07 23:56:28'),
(31, 4, 6, b'1', b'0', b'0', b'0', b'1', '2018-12-07 23:56:28'),
(32, 4, 7, b'1', b'0', b'0', b'0', b'1', '2018-12-07 23:56:28'),
(33, 4, 8, b'0', b'0', b'1', b'0', b'1', '2018-12-07 23:56:28'),
(34, 4, 14, b'1', b'0', b'0', b'0', b'1', '2018-12-07 23:56:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utentes`
--

DROP TABLE IF EXISTS `utentes`;
CREATE TABLE IF NOT EXISTS `utentes` (
  `IdUtente` int(11) NOT NULL AUTO_INCREMENT,
  `IdUtilizador` int(11) NOT NULL,
  `NomeCompleto` varchar(150) NOT NULL,
  `Morada` varchar(50) NOT NULL,
  `Localidade` varchar(15) NOT NULL,
  `Distrito` varchar(15) NOT NULL,
  `Contacto` varchar(13) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `DataNascimento` date NOT NULL,
  `Sexo` varchar(1) NOT NULL,
  `NIF` varchar(9) NOT NULL,
  `CartaoSaude` varchar(9) DEFAULT NULL,
  `Alergias` varchar(200) DEFAULT NULL,
  `DataUltAlteracao` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdUtente`),
  KEY `IdUtilizador` (`IdUtilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `utentes`
--

INSERT INTO `utentes` (`IdUtente`, `IdUtilizador`, `NomeCompleto`, `Morada`, `Localidade`, `Distrito`, `Contacto`, `Email`, `DataNascimento`, `Sexo`, `NIF`, `CartaoSaude`, `Alergias`, `DataUltAlteracao`) VALUES
(1, 2, 'tom alm', 'Rua rua rua', 'Cascais', 'Lisboa', '999999999', 'tttt@gmail.com', '1996-12-31', 'M', '95486413', '45687913', 'Isto;Aquilo;Aquloutro', '2018-12-07 00:24:32'),
(2, 14, 'Paciente Teste', 'Rua dos nervos', 'Lisboa', 'Lisboa', '9468746595', 'sim.nextgen2018@gmail.com', '2000-05-11', 'F', '164587956', '125465897', 'Nenhuma', '2018-12-16 03:14:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `IdUtilizador` int(11) NOT NULL AUTO_INCREMENT,
  `IdTipoUtilizador` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Morada` varchar(50) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `DataNascimento` date DEFAULT NULL,
  `Contacto` varchar(13) DEFAULT NULL,
  `Instituicao` varchar(50) DEFAULT NULL,
  `Ativo` tinyint(1) NOT NULL,
  `DataUltEntrada` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `DataCriacao` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdUtilizador`),
  KEY `FK_IdTipoUtilizador` (`IdTipoUtilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`IdUtilizador`, `IdTipoUtilizador`, `Nome`, `Username`, `Password`, `Morada`, `Email`, `DataNascimento`, `Contacto`, `Instituicao`, `Ativo`, `DataUltEntrada`, `DataCriacao`) VALUES
(1, 1, 'Administrador', 'admin', '1234', 'rua lalala', 'tata@gmail.com', NULL, '944658466', NULL, 1, '2018-11-30 05:45:46', '2018-11-24 23:33:31'),
(2, 2, 'tom alm', 'teste2', 'teste', 'Rua rua rua', 'tttt@gmail.com', NULL, '999999999', NULL, 1, '2018-12-07 20:30:14', '2018-12-07 00:24:09'),
(3, 3, 'Josué Morais', 'josue', 'josue', 'Rua do josue', 'josueM@yahoo.com', '1945-05-21', '915478466', NULL, 1, '2018-12-08 00:11:55', '2018-12-08 00:11:55'),
(4, 3, 'Rui Pereira', 'rui99', 'rui99', 'Rua do rui', 'ruizinho@gmail.com', '1957-12-05', '945874521', NULL, 1, '2018-12-08 00:11:55', '2018-12-08 00:11:55'),
(5, 3, 'Jonas Pistolas', 'jafoste', 'jonas', 'Rua do jonas', 'queroareforma@gmail.com', '1966-07-29', '112', NULL, 1, '2018-12-08 00:14:39', '2018-12-08 00:11:55'),
(6, 4, 'André André', 'andre', 'andre', 'Rua numero 2', 'andre@sapo.pt', '2000-01-18', '987654321', NULL, 1, '2018-12-08 00:11:55', '2018-12-08 00:11:55'),
(7, 4, 'Joaquim Eusébio', 'jaquim', 'jaquim', 'Rua do quim', 'quimbas@gmail.com', '1978-09-30', '965412358', NULL, 1, '2018-12-08 00:11:55', '2018-12-08 00:11:55'),
(8, 3, 'Rui Silva', 'rui', 'barroas', 'ruazinha', 'rui@gmail.com', NULL, '964587988', NULL, 1, '2018-12-07 00:46:15', '2018-12-07 00:46:15'),
(9, 4, 'Tonel Carvalho', 'tonel', 'tonel', 'Rua do Tonel', 'toneltoni@campus.fct.unl.pt', NULL, '912354687', NULL, 1, '2018-12-08 00:16:27', '2018-12-08 00:16:27'),
(10, 3, 'Antonieta Jesus', 'antonieta', 'jesus', 'Rua dela', 'antonieta@gmail.com', NULL, '946513256', NULL, 1, '2018-12-16 01:04:43', '2018-12-16 01:04:43'),
(11, 3, 'Manel dos Vinhos', 'manuel', 'manuel', 'Rua das quinas', 'manuel@gmail.com', NULL, '976431546', NULL, 1, '2018-12-16 01:06:07', '2018-12-16 01:06:07'),
(12, 4, 'Investigador do mÃªs', 'investigador', 'investigador', 'rua do investigador', 'insvs@gmail.com', NULL, '976431245', NULL, 1, '2018-12-16 01:07:23', '2018-12-16 01:07:23'),
(13, 3, 'nome1 apelido1', 'teste3', 'teste3', 'rua', 'blabla@gmail.com', NULL, '125489654', NULL, 1, '2018-12-16 02:04:27', '2018-12-16 02:04:27'),
(14, 2, 'Paciente Teste', 'paciente', 'paciente', 'Rua dos nervos', 'sim.nextgen2018@gmail.com', NULL, '9468746595', NULL, 1, '2018-12-16 03:14:16', '2018-12-16 03:14:16');

-- --------------------------------------------------------

--
-- Stand-in structure for view `utilizadorfuncionalidades`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `utilizadorfuncionalidades`;
CREATE TABLE IF NOT EXISTS `utilizadorfuncionalidades` (
`IdTipoUtilizador` int(11)
,`tipoUtilizador` varchar(100)
,`NomeMenu` varchar(30)
,`funcionalidade` varchar(100)
,`UrlCompleto` varchar(183)
);

-- --------------------------------------------------------

--
-- Structure for view `utilizadorfuncionalidades`
--
DROP TABLE IF EXISTS `utilizadorfuncionalidades`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `utilizadorfuncionalidades`  AS  select `t`.`IdTipoUtilizador` AS `IdTipoUtilizador`,`t`.`Descricao` AS `tipoUtilizador`,`f`.`NomeMenu` AS `NomeMenu`,`f`.`Descricao` AS `funcionalidade`,concat('<a href="',`f`.`UrlDestino`,'&ver=',cast(`tf`.`Ver` as signed),'&criar=',cast(`tf`.`Criar` as signed),'&editar=',cast(`tf`.`Editar` as signed),'&eliminar=',cast(`tf`.`Eliminar` as signed),'">',`f`.`NomeMenu`,'</a>') AS `UrlCompleto` from ((`tiposutilizadores` `t` left join `tiposutilizadorfuncionalidade` `tf` on(`tf`.`IdTipoUtilizador` = `t`.`IdTipoUtilizador`)) left join `funcionalidades` `f` on(`f`.`IdFuncionalidade` = `tf`.`IdFuncionalidade`)) where `tf`.`Ativo` = 1 order by `t`.`IdTipoUtilizador`,`f`.`IdFuncionalidade` ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `FK_IdFichaUtente` FOREIGN KEY (`IdFichaUtente`) REFERENCES `fichasutente` (`IdFichaUtente`),
  ADD CONSTRAINT `FK_IdUtilizadorConsulta` FOREIGN KEY (`IdUtilizador`) REFERENCES `utilizadores` (`IdUtilizador`);

--
-- Limitadores para a tabela `fichasutente`
--
ALTER TABLE `fichasutente`
  ADD CONSTRAINT `FK_IdUtente_Ficha` FOREIGN KEY (`IdUtente`) REFERENCES `utentes` (`IdUtente`);

--
-- Limitadores para a tabela `tiposutilizadorfuncionalidade`
--
ALTER TABLE `tiposutilizadorfuncionalidade`
  ADD CONSTRAINT `FK_F_IdTipoUtilizador` FOREIGN KEY (`IdTipoUtilizador`) REFERENCES `tiposutilizadores` (`IdTipoUtilizador`),
  ADD CONSTRAINT `FK_IdFuncionalidade` FOREIGN KEY (`IdFuncionalidade`) REFERENCES `funcionalidades` (`IdFuncionalidade`);

--
-- Limitadores para a tabela `utentes`
--
ALTER TABLE `utentes`
  ADD CONSTRAINT `FK_IdUtilizador` FOREIGN KEY (`IdUtilizador`) REFERENCES `utilizadores` (`IdUtilizador`);

--
-- Limitadores para a tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD CONSTRAINT `FK_IdTipoUtilizador` FOREIGN KEY (`IdTipoUtilizador`) REFERENCES `tiposutilizadores` (`IdTipoUtilizador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
