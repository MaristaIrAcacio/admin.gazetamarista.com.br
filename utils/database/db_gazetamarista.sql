-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_gazetamarista
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `gm_categorias`
--

DROP TABLE IF EXISTS `gm_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_categorias` (
  `idCategorias` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idCategorias`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_categorias`
--

LOCK TABLES `gm_categorias` WRITE;
/*!40000 ALTER TABLE `gm_categorias` DISABLE KEYS */;
INSERT INTO `gm_categorias` VALUES (2,'A voz da Escola',1),(3,'Acontece na Escola',1),(4,'Londrina na Visão',1),(5,'Atualidades',1),(6,'Fala Marista',1),(7,'Quadrinhos',1);
/*!40000 ALTER TABLE `gm_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_charges`
--

DROP TABLE IF EXISTS `gm_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_charges` (
  `idCharges` int(11) NOT NULL AUTO_INCREMENT,
  `imagem` varchar(255) DEFAULT NULL,
  `autorId` int(11) DEFAULT NULL,
  `colaborador1Id` int(11) DEFAULT NULL,
  `colaborador2Id` int(11) DEFAULT NULL,
  `colaborador3Id` int(11) DEFAULT NULL,
  `status` enum('pendente','publicado','rejeitado') DEFAULT 'pendente',
  `apontamentos` varchar(255) DEFAULT NULL,
  `dataPublicacao` datetime DEFAULT NULL,
  `criadoEm` datetime DEFAULT current_timestamp(),
  `atualizadoEm` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `titulo` varchar(120) NOT NULL,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`idCharges`),
  KEY `autorId` (`autorId`),
  KEY `colaborador1Id` (`colaborador1Id`),
  KEY `colaborador2Id` (`colaborador2Id`),
  KEY `colaborador3Id` (`colaborador3Id`),
  CONSTRAINT `gm_charges_ibfk_1` FOREIGN KEY (`autorId`) REFERENCES `usuarios` (`idusuario`),
  CONSTRAINT `gm_charges_ibfk_2` FOREIGN KEY (`colaborador1Id`) REFERENCES `usuarios` (`idusuario`),
  CONSTRAINT `gm_charges_ibfk_3` FOREIGN KEY (`colaborador2Id`) REFERENCES `usuarios` (`idusuario`),
  CONSTRAINT `gm_charges_ibfk_4` FOREIGN KEY (`colaborador3Id`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_charges`
--

LOCK TABLES `gm_charges` WRITE;
/*!40000 ALTER TABLE `gm_charges` DISABLE KEYS */;
INSERT INTO `gm_charges` VALUES (9,'38383ca5e9865194750e73198c518233.jpg',15,14,NULL,NULL,'publicado','dsasda','2024-07-28 10:41:17','2024-07-28 10:40:38','2024-07-28 10:41:17','safsdaf','sadfsdafs'),(10,'f329a75da236dcab049ef9cdfdd3c175.jpg',15,NULL,NULL,NULL,'pendente',NULL,NULL,'2024-07-28 11:10:54','2024-07-28 11:10:54','sadfsadf','sadfsdaf'),(11,'582b32f71cc12b388b5019473ac91e3d.jpg',15,14,15,13,'pendente',NULL,NULL,'2024-07-28 11:24:28','2024-07-28 11:24:28','Cessna Citation CJ1','');
/*!40000 ALTER TABLE `gm_charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_configuracoes`
--

DROP TABLE IF EXISTS `gm_configuracoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_configuracoes` (
  `idconfiguracao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_site` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(45) DEFAULT NULL,
  `whatsapp` varchar(45) DEFAULT NULL,
  `recaptcha_key` varchar(255) DEFAULT NULL,
  `recaptcha_secret` varchar(255) DEFAULT NULL,
  `share_tag` varchar(255) DEFAULT NULL,
  `codigo_final_head` text DEFAULT NULL,
  `codigo_inicio_body` text DEFAULT NULL,
  `codigo_final_body` text DEFAULT NULL,
  `politica_cookie_texto` text DEFAULT NULL,
  PRIMARY KEY (`idconfiguracao`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_configuracoes`
--

LOCK TABLES `gm_configuracoes` WRITE;
/*!40000 ALTER TABLE `gm_configuracoes` DISABLE KEYS */;
INSERT INTO `gm_configuracoes` VALUES (1,'Gazeta Marista','','','','','','','','','','','<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>');
/*!40000 ALTER TABLE `gm_configuracoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_contatos`
--

DROP TABLE IF EXISTS `gm_contatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_contatos` (
  `idcontato` int(11) NOT NULL AUTO_INCREMENT,
  `assunto` varchar(150) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `celular` varchar(30) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idcontato`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_contatos`
--

LOCK TABLES `gm_contatos` WRITE;
/*!40000 ALTER TABLE `gm_contatos` DISABLE KEYS */;
INSERT INTO `gm_contatos` VALUES (9,'Sugestões','Vitor Gabriel de Oliveira','vitor@clickweb.com.br','(43) 98487-3807','Teste de Envio de Contato','2024-07-19 10:48:41','187.62.30.129'),(10,'Dúvidas sobre o serviço','teste','vitor@clickweb.com.br','(43) 98487-3807','teste','2024-07-19 11:08:34','187.62.30.129');
/*!40000 ALTER TABLE `gm_contatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_cookies`
--

DROP TABLE IF EXISTS `gm_cookies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_cookies` (
  `idcookie` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`idcookie`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_cookies`
--

LOCK TABLES `gm_cookies` WRITE;
/*!40000 ALTER TABLE `gm_cookies` DISABLE KEYS */;
INSERT INTO `gm_cookies` VALUES (29,'128.94.16.43','2024-07-19 16:23:53'),(30,'186.212.84.59','2024-07-19 19:05:37'),(31,'::1','2024-07-19 23:58:59');
/*!40000 ALTER TABLE `gm_cookies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_emails`
--

DROP TABLE IF EXISTS `gm_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_emails` (
  `idemail` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idemail`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_emails`
--

LOCK TABLES `gm_emails` WRITE;
/*!40000 ALTER TABLE `gm_emails` DISABLE KEYS */;
INSERT INTO `gm_emails` VALUES (33,'ph@clickweb.com.br',NULL,'2024-07-19 12:19:21','127.0.0.1'),(34,'joao.pimentel@clickweb.com.br','','2024-07-19 12:35:44','187.62.30.129'),(35,'vitor@clickweb.com.br','','2024-07-19 12:36:53','187.62.30.129'),(36,'vitorgabrieldeoliveiradev@gmail.com',NULL,'2024-07-19 14:01:29','127.0.0.1');
/*!40000 ALTER TABLE `gm_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_erros`
--

DROP TABLE IF EXISTS `gm_erros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_erros` (
  `iderro` int(11) NOT NULL AUTO_INCREMENT,
  `data_execucao` datetime NOT NULL,
  `mensagem` text NOT NULL,
  `parametros` text NOT NULL,
  `browser_sistema` varchar(255) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `trace` text DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`iderro`) USING BTREE,
  KEY `fk_erros_usuarios1` (`idusuario`) USING BTREE,
  CONSTRAINT `fk_erros_usuarios1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=1590 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_erros`
--

LOCK TABLES `gm_erros` WRITE;
/*!40000 ALTER TABLE `gm_erros` DISABLE KEYS */;
/*!40000 ALTER TABLE `gm_erros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_logs`
--

DROP TABLE IF EXISTS `gm_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_logs` (
  `idlog` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) DEFAULT NULL,
  `nomeusuario` varchar(255) DEFAULT NULL,
  `modulo` varchar(50) NOT NULL,
  `tabela` varchar(50) NOT NULL,
  `json_data_antes` longblob DEFAULT NULL,
  `json_data` longblob DEFAULT NULL,
  `acao_executada` varchar(20) NOT NULL,
  `browser_sistema` varchar(255) NOT NULL,
  `data_execucao` datetime NOT NULL,
  `ip` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idlog`) USING BTREE,
  KEY `fk_logs_usuarios1` (`idusuario`) USING BTREE,
  CONSTRAINT `fk_logs_usuarios1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=848 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_logs`
--

LOCK TABLES `gm_logs` WRITE;
/*!40000 ALTER TABLE `gm_logs` DISABLE KEYS */;
INSERT INTO `gm_logs` VALUES (799,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"14\",\"idperfil\":\"99\",\"avatar\":\"16fa94f8bc10e08c32343d76cacb0168.jpg\",\"nome\":\"Desenvolvimento\",\"email\":\"dev@gmail.com\",\"login\":\"developer\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-27 14:27:09','::1'),(800,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"14\",\"idperfil\":\"99\",\"avatar\":\"16fa94f8bc10e08c32343d76cacb0168.jpg\",\"nome\":\"Desenvolvimento\",\"email\":\"dev@gmail.com\",\"login\":\"developer\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-27 14:27:15','::1'),(801,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"13\",\"idperfil\":\"90\",\"avatar\":\"4d3c9678bc8ab80c9c3175b40bd26060.jpg\",\"nome\":\"Admin\",\"email\":\"admin@gmail.com.br\",\"login\":\"admin\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-27 14:27:22','::1'),(802,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"14\",\"idperfil\":\"99\",\"avatar\":\"16fa94f8bc10e08c32343d76cacb0168.jpg\",\"nome\":\"Desenvolvimento\",\"email\":\"dev@gmail.com\",\"login\":\"developer\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-27 14:29:09','::1'),(803,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"13\",\"idperfil\":\"90\",\"avatar\":\"4d3c9678bc8ab80c9c3175b40bd26060.jpg\",\"nome\":\"Admin\",\"email\":\"admin@gmail.com.br\",\"login\":\"admin\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-27 14:29:20','::1'),(804,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"14\",\"idperfil\":\"99\",\"avatar\":\"16fa94f8bc10e08c32343d76cacb0168.jpg\",\"nome\":\"Desenvolvimento\",\"email\":\"dev@gmail.com\",\"login\":\"developer\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-27 14:29:30','::1'),(805,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"15\",\"idperfil\":\"2\",\"avatar\":\"73fe9b8b8fa68ed856a2e199d68fdb46.png\",\"nome\":\"Redator\",\"email\":\"redator@gmail.com\",\"login\":\"redator\",\"chave\":null,\"sendmail\":\"2024-07-24 20:52:02\",\"serie\":\"1\",\"turma\":\"2\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-27 14:29:38','::1'),(806,NULL,NULL,'','usuarios','',_binary '{\"login\":\"developer\"}','LOGIN-ERRO','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-27 14:30:51','::1'),(807,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"14\",\"idperfil\":\"99\",\"avatar\":\"16fa94f8bc10e08c32343d76cacb0168.jpg\",\"nome\":\"Desenvolvimento\",\"email\":\"dev@gmail.com\",\"login\":\"developer\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-27 14:30:59','::1'),(808,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"14\",\"idperfil\":\"99\",\"avatar\":\"16fa94f8bc10e08c32343d76cacb0168.jpg\",\"nome\":\"Desenvolvimento\",\"email\":\"dev@gmail.com\",\"login\":\"developer\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 09:24:43','::1'),(809,14,'Desenvolvimento (developer)','admin','gm_materias',NULL,_binary '{\"idNoticia\":0,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"2ca26679ff9f8cf1b4681b8674c4f89b.jpg\",\"categoriaId\":null,\"colaboradorId\":\"14\",\"titulo\":\"asdasdas\",\"subtitulo\":\"\",\"lide\":\"asdasd\",\"texto\":\"adas\",\"tipo\":\"noticia\",\"tags\":\"asdasd, sadsa\",\"status\":\"rascunho\",\"autorId\":\"14\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:38:23','::1'),(810,14,'Desenvolvimento (developer)','admin','gm_materias',NULL,_binary '{\"idNoticia\":0,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"c67f10e71cd75316d1f5c01f28bb5d85.jpg\",\"imagem_mobile\":\"adc32b1b4195e08f777407bbfd3f77ae.jpg\",\"categoriaId\":\"6\",\"colaboradorId\":null,\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"Subt\\u00edtulo\",\"lide\":\"sadfsdaf\",\"texto\":\"asdfsdaf\",\"tipo\":\"noticia\",\"tags\":\"sadfsdaf\",\"status\":\"rascunho\",\"autorId\":\"14\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:39:03','::1'),(811,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"15\",\"idperfil\":\"2\",\"avatar\":\"73fe9b8b8fa68ed856a2e199d68fdb46.png\",\"nome\":\"Redator\",\"email\":\"redator@gmail.com\",\"login\":\"redator\",\"chave\":null,\"sendmail\":\"2024-07-24 20:52:02\",\"serie\":\"1\",\"turma\":\"2\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:39:20','::1'),(812,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":0,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"135873d477ec1b5f871ae0fef2dbc3e3.jpg\",\"imagem_mobile\":\"5e53d3e48bef9445c7778df7e84b97f3.jpg\",\"categoriaId\":\"3\",\"colaboradorId\":\"14\",\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"Subt\\u00edtulo\",\"lide\":\"asdfdsafsdafsadf\",\"texto\":\"sadfsadfsdafa\",\"tipo\":\"noticia\",\"tags\":\"sadfsdfsa\",\"status\":\"rascunho\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:39:44','::1'),(813,15,'Redator (redator)','admin','gm_charges',NULL,_binary '{\"idCharges\":8,\"colaborador1Id\":\"14\",\"colaborador2Id\":\"14\",\"colaborador3Id\":\"13\",\"titulo\":\"Cessna Citation CJ1\",\"descricao\":\"sadfsdafsdaf\",\"imagem\":\"43afbcb88320926ba4aa8f5d3e9e0fbf.jpg\",\"status\":\"pendente\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:40:08','::1'),(814,15,'Redator (redator)','admin','gm_charges',NULL,_binary '{\"idCharges\":9,\"colaborador1Id\":\"14\",\"colaborador2Id\":null,\"colaborador3Id\":null,\"titulo\":\"safsdaf\",\"descricao\":\"sadfsdafs\",\"imagem\":\"38383ca5e9865194750e73198c518233.jpg\",\"status\":\"pendente\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:40:38','::1'),(815,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"14\",\"idperfil\":\"99\",\"avatar\":\"16fa94f8bc10e08c32343d76cacb0168.jpg\",\"nome\":\"Desenvolvimento\",\"email\":\"dev@gmail.com\",\"login\":\"developer\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:40:51','::1'),(816,14,'Desenvolvimento (developer)','admin','gm_charges',_binary '{\"idCharges\":\"9\",\"imagem\":\"38383ca5e9865194750e73198c518233.jpg\",\"autorId\":\"15\",\"colaborador1Id\":\"14\",\"colaborador2Id\":null,\"colaborador3Id\":null,\"status\":\"pendente\",\"apontamentos\":null,\"dataPublicacao\":null,\"criadoEm\":\"2024-07-28 10:40:38\",\"atualizadoEm\":\"2024-07-28 10:40:38\",\"titulo\":\"safsdaf\",\"descricao\":\"sadfsdafs\"}',_binary '{\"idCharges\":9,\"titulo\":\"safsdaf\",\"descricao\":\"sadfsdafs\",\"colaborador1Id\":\"14\",\"colaborador2Id\":null,\"colaborador3Id\":null,\"apontamentos\":\"dsasda\",\"status\":\"rejeitado\"}','UPDATE','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:41:00','::1'),(817,15,'Redator (redator)','admin','gm_charges',_binary '{\"idCharges\":\"9\",\"imagem\":\"38383ca5e9865194750e73198c518233.jpg\",\"autorId\":\"15\",\"colaborador1Id\":\"14\",\"colaborador2Id\":null,\"colaborador3Id\":null,\"status\":\"rejeitado\",\"apontamentos\":\"dsasda\",\"dataPublicacao\":null,\"criadoEm\":\"2024-07-28 10:40:38\",\"atualizadoEm\":\"2024-07-28 10:41:00\",\"titulo\":\"safsdaf\",\"descricao\":\"sadfsdafs\"}',_binary '{\"idCharges\":9,\"titulo\":\"safsdaf\",\"descricao\":\"sadfsdafs\",\"colaborador1Id\":\"14\",\"colaborador2Id\":null,\"colaborador3Id\":null,\"status\":\"pendente\"}','UPDATE','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:41:09','::1'),(818,14,'Desenvolvimento (developer)','admin','gm_charges',_binary '{\"idCharges\":\"9\",\"imagem\":\"38383ca5e9865194750e73198c518233.jpg\",\"autorId\":\"15\",\"colaborador1Id\":\"14\",\"colaborador2Id\":null,\"colaborador3Id\":null,\"status\":\"pendente\",\"apontamentos\":\"dsasda\",\"dataPublicacao\":null,\"criadoEm\":\"2024-07-28 10:40:38\",\"atualizadoEm\":\"2024-07-28 10:41:09\",\"titulo\":\"safsdaf\",\"descricao\":\"sadfsdafs\"}',_binary '{\"idCharges\":9,\"titulo\":\"safsdaf\",\"descricao\":\"sadfsdafs\",\"colaborador1Id\":\"14\",\"colaborador2Id\":null,\"colaborador3Id\":null,\"status\":\"publicado\",\"dataPublicacao\":\"2024-07-28 10:41:17\"}','UPDATE','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:41:17','::1'),(819,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":0,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"06c1479b0ebf9d954da64df8ae619512.jpg\",\"imagem_mobile\":\"75b1eba203b488a19831a6446ce73776.jpg\",\"categoriaId\":\"3\",\"colaboradorId\":null,\"titulo\":\"sadsadasdsa\",\"subtitulo\":\"\",\"lide\":\"sadsada\",\"texto\":\"asdasdasd\",\"tipo\":\"noticia\",\"tags\":\"asdas\",\"status\":\"rascunho\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:42:16','::1'),(820,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":0,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"637dfd5d1d674e774a9f5e6d3d6c9d8a.jpg\",\"imagem_mobile\":\"358e46e875762a5d6db62390a44a9589.jpg\",\"categoriaId\":\"3\",\"colaboradorId\":null,\"titulo\":\"sadfsdaf\",\"subtitulo\":\"\",\"lide\":\"sadfsdaf\",\"texto\":\"saffsdaf\",\"tipo\":\"noticia\",\"tags\":\"\",\"status\":\"rascunho\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:44:58','::1'),(821,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":0,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"e9505c1f96429de6b011e0553ae188ea.jpg\",\"imagem_mobile\":\"5bde5bb4d391c5f3390fc322d460d5a7.jpg\",\"categoriaId\":\"3\",\"colaboradorId\":null,\"titulo\":\"asdfsdaf\",\"subtitulo\":\"\",\"lide\":\"\",\"texto\":\"asdfsdafsda\",\"tipo\":\"noticia\",\"tags\":\"\",\"status\":\"rascunho\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:45:15','::1'),(822,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":0,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"d2d5cd90142c52347d6ec3130d8d816e.jpg\",\"imagem_mobile\":\"d8320f13c55b00fe4b18e83016ff26b5.jpg\",\"categoriaId\":\"3\",\"colaboradorId\":\"14\",\"titulo\":\"sdfsdfssdfsd\",\"subtitulo\":\"sdfsdfsdf\",\"lide\":\"sdfsdfsd\",\"texto\":\"sdfsdfsdfsd\",\"tipo\":\"noticia\",\"tags\":\"sdfsdfsd\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:46:04','::1'),(823,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":2,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"95be84e767ad722c7173763231cd9e9e.jpg\",\"imagem_mobile\":\"b3b5c5a721043f2b1306a74cfa9eba08.jpg\",\"categoriaId\":\"5\",\"colaboradorId\":\"14\",\"titulo\":\"T\\u00edtulo\",\"subtitulo\":\"\",\"lide\":\"sadsadas\",\"texto\":\"asdasd\",\"tipo\":\"noticia\",\"tags\":\"sadas\",\"status\":\"rascunho\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:47:32','::1'),(824,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":4,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"fe735a43f63d557b30d757b31f7c5d76.jpg\",\"imagem_mobile\":\"c985490c386d89f2ee4f487736b3d1eb.jpg\",\"categoriaId\":\"5\",\"colaboradorId\":\"15\",\"titulo\":\"sdfsdfsd\",\"subtitulo\":\"\",\"lide\":\"sdfsdfsdsdfs\",\"texto\":\"sdfsdfdf\",\"tipo\":\"noticia\",\"tags\":\"sdfsdf\",\"status\":\"rascunho\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:48:00','::1'),(825,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":5,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"5c21c5084c4e6a1f74656238392cf4a1.jpg\",\"imagem_mobile\":\"0ba5482cbb0bac44b2eed53a73e46207.jpg\",\"categoriaId\":\"3\",\"colaboradorId\":\"14\",\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"sdfsdf\",\"lide\":\"sdfsdfsdfs\",\"texto\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"tags\":\"sdfsdfsd\",\"status\":\"rascunho\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:48:39','::1'),(826,15,'Redator (redator)','admin','gm_materias',_binary '{\"idNoticia\":\"5\",\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"sdfsdf\",\"lide\":\"sdfsdfsdfs\",\"texto\":\"sdfsdfsd\",\"categoriaId\":\"3\",\"autorId\":\"15\",\"colaboradorId\":\"14\",\"status\":\"rascunho\",\"apontamentos\":null,\"dataPublicacao\":null,\"tags\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"criadoEm\":\"2024-07-28 10:48:39\",\"atualizadoEm\":\"2024-07-28 10:48:39\",\"ultimaAlteracao\":null,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"5c21c5084c4e6a1f74656238392cf4a1.jpg\",\"imagem_mobile\":\"0ba5482cbb0bac44b2eed53a73e46207.jpg\"}',_binary '{\"idNoticia\":5,\"isRascunho\":\"Aprova\\u00e7\\u00e3o\",\"categoriaId\":\"3\",\"colaboradorId\":\"14\",\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"sdfsdf\",\"lide\":\"sdfsdfsdfs\",\"texto\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"tags\":\"sdfsdfsd\",\"status\":\"pendente\"}','UPDATE','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:48:43','::1'),(827,14,'Desenvolvimento (developer)','admin','gm_materias',_binary '{\"idNoticia\":\"5\",\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"sdfsdf\",\"lide\":\"sdfsdfsdfs\",\"texto\":\"sdfsdfsd\",\"categoriaId\":\"3\",\"autorId\":\"15\",\"colaboradorId\":\"14\",\"status\":\"pendente\",\"apontamentos\":null,\"dataPublicacao\":null,\"tags\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"criadoEm\":\"2024-07-28 10:48:39\",\"atualizadoEm\":\"2024-07-28 10:48:43\",\"ultimaAlteracao\":null,\"isRascunho\":\"Aprova\\u00e7\\u00e3o\",\"imagem_desktop\":\"5c21c5084c4e6a1f74656238392cf4a1.jpg\",\"imagem_mobile\":\"0ba5482cbb0bac44b2eed53a73e46207.jpg\"}',_binary '{\"idNoticia\":5,\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"sdfsdf\",\"lide\":\"sdfsdfsdfs\",\"texto\":\"sdfsdfsd\",\"categoriaId\":\"3\",\"autorId\":\"15\",\"colaboradorId\":\"14\",\"tags\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"apontamentos\":\"sdfgfdgsd\",\"status\":\"rejeitado\"}','UPDATE','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:48:54','::1'),(828,15,'Redator (redator)','admin','gm_materias',_binary '{\"idNoticia\":\"5\",\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"sdfsdf\",\"lide\":\"sdfsdfsdfs\",\"texto\":\"sdfsdfsd\",\"categoriaId\":\"3\",\"autorId\":\"15\",\"colaboradorId\":\"14\",\"status\":\"rejeitado\",\"apontamentos\":\"sdfgfdgsd\",\"dataPublicacao\":null,\"tags\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"criadoEm\":\"2024-07-28 10:48:39\",\"atualizadoEm\":\"2024-07-28 10:48:54\",\"ultimaAlteracao\":null,\"isRascunho\":\"Aprova\\u00e7\\u00e3o\",\"imagem_desktop\":\"5c21c5084c4e6a1f74656238392cf4a1.jpg\",\"imagem_mobile\":\"0ba5482cbb0bac44b2eed53a73e46207.jpg\"}',_binary '{\"idNoticia\":5,\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"sdfsdf\",\"lide\":\"sdfsdfsdfs\",\"texto\":\"sdfsdfsd\",\"categoriaId\":\"3\",\"autorId\":\"15\",\"colaboradorId\":\"14\",\"dataPublicacao\":\" :\",\"tags\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"status\":\"pendente\"}','UPDATE','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:49:00','::1'),(829,14,'Desenvolvimento (developer)','admin','gm_materias',_binary '{\"idNoticia\":\"5\",\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"sdfsdf\",\"lide\":\"sdfsdfsdfs\",\"texto\":\"sdfsdfsd\",\"categoriaId\":\"3\",\"autorId\":\"15\",\"colaboradorId\":\"14\",\"status\":\"pendente\",\"apontamentos\":\"sdfgfdgsd\",\"dataPublicacao\":\"0000-00-00 00:00:00\",\"tags\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"criadoEm\":\"2024-07-28 10:48:39\",\"atualizadoEm\":\"2024-07-28 10:49:00\",\"ultimaAlteracao\":null,\"isRascunho\":\"Aprova\\u00e7\\u00e3o\",\"imagem_desktop\":\"5c21c5084c4e6a1f74656238392cf4a1.jpg\",\"imagem_mobile\":\"0ba5482cbb0bac44b2eed53a73e46207.jpg\"}',_binary '{\"idNoticia\":5,\"titulo\":\"Cessna Citation CJ1\",\"subtitulo\":\"sdfsdf\",\"lide\":\"sdfsdfsdfs\",\"texto\":\"sdfsdfsd\",\"categoriaId\":\"3\",\"autorId\":\"15\",\"colaboradorId\":\"14\",\"tags\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"status\":\"publicado\",\"dataPublicacao\":\"2024-07-28 10:49:06\"}','UPDATE','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:49:06','::1'),(830,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":6,\"isRascunho\":\"Aprova\\u00e7\\u00e3o\",\"imagem_desktop\":\"43288a358c3eff2d1cf950d92afd10f4.jpg\",\"imagem_mobile\":\"67df195070eeea3638e71bbe98328766.jpg\",\"categoriaId\":\"3\",\"colaboradorId\":\"14\",\"titulo\":\"sdfsdfsdfsd\",\"subtitulo\":\"sdfsd\",\"lide\":\"sdfsdf\",\"texto\":\"sdfsdfsd\",\"tipo\":\"noticia\",\"tags\":\"sdfsdf\",\"status\":\"pendente\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 10:57:41','::1'),(831,15,'Redator (redator)','admin','gm_charges',NULL,_binary '{\"idCharges\":10,\"colaborador1Id\":null,\"colaborador2Id\":null,\"colaborador3Id\":null,\"titulo\":\"sadfsadf\",\"descricao\":\"sadfsdaf\",\"imagem\":\"f329a75da236dcab049ef9cdfdd3c175.jpg\",\"status\":\"pendente\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:10:54','::1'),(832,15,'Redator (redator)','admin','gm_programacaoradio',NULL,_binary '{\"idRadio\":5,\"data\":\"2024-07-28\",\"periodo\":\"Matutino\",\"locutor1\":\"14\",\"locutor2\":\"14\",\"locutor3\":\"14\",\"calendario_sazonal\":\"sdfgfdsgfsdg\",\"musica1\":\"sdfg\",\"comentario_musica1\":\"fsdgfsd\",\"noticia1\":\"dfsgsd\",\"musica2\":\"sfdsg\",\"comentario_musica2\":\"dfsgfd\",\"curiosidade_dia\":\"fdsgfsd\",\"musica3\":\"gdfsgfsd\",\"comentario_musica3\":\"dfsgfds\",\"noticia_urgente\":\"fdsgfsd\",\"encerramento\":\"dfgfdsg\",\"musica4\":\"fdsgdfs\",\"musica5\":\"fdgdfs\",\"musica6\":\"fdsgsd\",\"pauta_escrita\":\"<p><strong>LOCUTORES:<\\/strong><br \\/>\\r\\nSoltem a vinheta de abertura. Ap\\u00f3s ela, sigam o roteiro abaixo!<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nEu sou ___.<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nE eu sou ____, e estaremos com voc\\u00eas nas ondas da nossa r\\u00e1dio at\\u00e9 \\u00e0s 10:30.<\\/p>\\r\\n\\r\\n<p><strong>CALEND\\u00c1RIO SAZONAL<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\n(Calend\\u00e1rio sazonal aqui...)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nE vamos agora para nossa primeira faixa do dia!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 1:<\\/strong><br \\/>\\r\\n(Primeira&nbsp;m\\u00fasica do dia aqui...)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nVoc\\u00ea ouviu ___.<\\/p>\\r\\n\\r\\n<p><strong>NOT\\u00cdCIA<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\n(Primeira Not\\u00edcia aqui)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nE vamos pra nossa pr\\u00f3xima faixa!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 2:<\\/strong><br \\/>\\r\\n(Segunda m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nVoc\\u00ea escutou ___.<\\/p>\\r\\n\\r\\n<p><strong>CURIOSIDADE DO DIA<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\n(Curiosidade do dia aqui...)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nE vamos de mais m\\u00fasica!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 3:<\\/strong><br \\/>\\r\\n(Terceira m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nVoc\\u00ea acabou de ouvir ___.<\\/p>\\r\\n\\r\\n<p><strong>NOT\\u00cdCIA URGENTE<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\n(Insira a not\\u00edcia urgente aqui)<\\/p>\\r\\n\\r\\n<p><strong>Evento ap\\u00f3s intervalo<\\/strong><\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nMas infelizmente a nossa r\\u00e1dio j\\u00e1 est\\u00e1 chegando ao fim!<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nMuito obrigado a todos que estiveram com a gente!<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nMuito obrigado! Tenham um bom dia, um \\u00f3timo fim de semana e bons estudos! Tchau!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 4:<\\/strong><br \\/>\\r\\n(Quarta m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 5:<\\/strong><br \\/>\\r\\n(Insira a m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 6:<\\/strong><br \\/>\\r\\n(Insira a m\\u00fasica aqui)<\\/p>\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:11:58','::1'),(833,15,'Redator (redator)','admin','gm_programacaoradio',NULL,_binary '{\"idRadio\":6,\"data\":\"2024-07-28\",\"periodo\":\"Vespertino\",\"locutor1\":\"14\",\"locutor2\":\"14\",\"locutor3\":\"15\",\"calendario_sazonal\":\"sadfsdaf\",\"musica1\":\"asdfsda\",\"comentario_musica1\":\"sdafsda\",\"noticia1\":\"sdafsda\",\"musica2\":\"sadfsda\",\"comentario_musica2\":\"sdfsda\",\"curiosidade_dia\":\"sdafsdaf\",\"musica3\":\"sdafsdaf\",\"comentario_musica3\":\"sdfasda\",\"noticia_urgente\":\"sdafsdaf\",\"encerramento\":\"sdfsad\",\"musica4\":\"sdafsda\",\"musica5\":\"sdfsda\",\"musica6\":\"sadfsa\",\"pauta_escrita\":\"<p><strong>LOCUTORES:<\\/strong><br \\/>\\r\\nSoltem a vinheta de abertura. Ap\\u00f3s ela, sigam o roteiro abaixo!<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nEu sou ___.<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nE eu sou ____, e estaremos com voc\\u00eas nas ondas da nossa r\\u00e1dio at\\u00e9 \\u00e0s 10:30.<\\/p>\\r\\n\\r\\n<p><strong>CALEND\\u00c1RIO SAZONAL<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\n(Calend\\u00e1rio sazonal aqui...)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nE vamos agora para nossa primeira faixa do dia!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 1:<\\/strong><br \\/>\\r\\n(Primeira&nbsp;m\\u00fasica do dia aqui...)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nVoc\\u00ea ouviu ___.<\\/p>\\r\\n\\r\\n<p><strong>NOT\\u00cdCIA<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\n(Primeira Not\\u00edcia aqui)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nE vamos pra nossa pr\\u00f3xima faixa!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 2:<\\/strong><br \\/>\\r\\n(Segunda m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nVoc\\u00ea escutou ___.<\\/p>\\r\\n\\r\\n<p><strong>CURIOSIDADE DO DIA<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\n(Curiosidade do dia aqui...)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nE vamos de mais m\\u00fasica!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 3:<\\/strong><br \\/>\\r\\n(Terceira m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nVoc\\u00ea acabou de ouvir ___.<\\/p>\\r\\n\\r\\n<p><strong>NOT\\u00cdCIA URGENTE<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\n(Insira a not\\u00edcia urgente aqui)<\\/p>\\r\\n\\r\\n<p><strong>Evento ap\\u00f3s intervalo<\\/strong><\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nMas infelizmente a nossa r\\u00e1dio j\\u00e1 est\\u00e1 chegando ao fim!<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nMuito obrigado a todos que estiveram com a gente!<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nMuito obrigado! Tenham um bom dia, um \\u00f3timo fim de semana e bons estudos! Tchau!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 4:<\\/strong><br \\/>\\r\\n(Quarta m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 5:<\\/strong><br \\/>\\r\\n(Insira a m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 6:<\\/strong><br \\/>\\r\\n(Insira a m\\u00fasica aqui)<\\/p>\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:12:51','::1'),(834,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"13\",\"idperfil\":\"90\",\"avatar\":\"4d3c9678bc8ab80c9c3175b40bd26060.jpg\",\"nome\":\"Admin\",\"email\":\"admin@gmail.com.br\",\"login\":\"admin\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:16:49','::1'),(835,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"14\",\"idperfil\":\"99\",\"avatar\":\"16fa94f8bc10e08c32343d76cacb0168.jpg\",\"nome\":\"Desenvolvimento\",\"email\":\"dev@gmail.com\",\"login\":\"developer\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:17:00','::1'),(836,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"15\",\"idperfil\":\"2\",\"avatar\":\"73fe9b8b8fa68ed856a2e199d68fdb46.png\",\"nome\":\"Redator\",\"email\":\"redator@gmail.com\",\"login\":\"redator\",\"chave\":null,\"sendmail\":\"2024-07-24 20:52:02\",\"serie\":\"1\",\"turma\":\"2\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:18:02','::1'),(837,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"13\",\"idperfil\":\"90\",\"avatar\":\"4d3c9678bc8ab80c9c3175b40bd26060.jpg\",\"nome\":\"Admin\",\"email\":\"admin@gmail.com.br\",\"login\":\"admin\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:18:09','::1'),(838,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"15\",\"idperfil\":\"2\",\"avatar\":\"73fe9b8b8fa68ed856a2e199d68fdb46.png\",\"nome\":\"Redator\",\"email\":\"redator@gmail.com\",\"login\":\"redator\",\"chave\":null,\"sendmail\":\"2024-07-24 20:52:02\",\"serie\":\"1\",\"turma\":\"2\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:23:42','::1'),(839,NULL,NULL,'','usuarios','',_binary '{\"idusuario\":\"13\",\"idperfil\":\"90\",\"avatar\":\"4d3c9678bc8ab80c9c3175b40bd26060.jpg\",\"nome\":\"Admin\",\"email\":\"admin@gmail.com.br\",\"login\":\"admin\",\"chave\":null,\"sendmail\":null,\"serie\":\"8\",\"turma\":\"4\",\"instagram\":\"\",\"linkedin\":null,\"ativo\":\"1\"}','LOGIN-OK','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:24:03','::1'),(840,15,'Redator (redator)','admin','gm_charges',NULL,_binary '{\"idCharges\":11,\"colaborador1Id\":\"14\",\"colaborador2Id\":\"15\",\"colaborador3Id\":\"13\",\"titulo\":\"Cessna Citation CJ1\",\"descricao\":\"\",\"imagem\":\"582b32f71cc12b388b5019473ac91e3d.jpg\",\"status\":\"pendente\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:24:28','::1'),(841,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":7,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"fec8896c40fdad35ad8479f35fbba9a1.jpg\",\"imagem_mobile\":\"44eacffaba7c3614d124fabcc7bca3aa.jpg\",\"categoriaId\":\"2\",\"colaboradorId\":\"15\",\"titulo\":\"asdsad\",\"subtitulo\":\"\",\"lide\":\"asdsad\",\"texto\":\"asdsads\",\"tipo\":\"noticia\",\"tags\":\"asdasdas\",\"status\":\"rascunho\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:24:53','::1'),(842,15,'Redator (redator)','admin','gm_materias',_binary '{\"idNoticia\":\"7\",\"titulo\":\"asdsad\",\"subtitulo\":\"\",\"lide\":\"asdsad\",\"texto\":\"asdsads\",\"categoriaId\":\"2\",\"autorId\":\"15\",\"colaboradorId\":\"15\",\"status\":\"rascunho\",\"apontamentos\":null,\"dataPublicacao\":null,\"tags\":\"asdasdas\",\"tipo\":\"noticia\",\"criadoEm\":\"2024-07-28 11:24:53\",\"atualizadoEm\":\"2024-07-28 11:24:53\",\"ultimaAlteracao\":null,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"fec8896c40fdad35ad8479f35fbba9a1.jpg\",\"imagem_mobile\":\"44eacffaba7c3614d124fabcc7bca3aa.jpg\"}',_binary '{\"idNoticia\":7,\"isRascunho\":\"Aprova\\u00e7\\u00e3o\",\"categoriaId\":\"2\",\"colaboradorId\":\"15\",\"titulo\":\"asdsad\",\"subtitulo\":\"\",\"lide\":\"asdsad\",\"texto\":\"asdsads\",\"tipo\":\"noticia\",\"tags\":\"asdasdas\",\"status\":\"pendente\"}','UPDATE','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:25:02','::1'),(843,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":8,\"isRascunho\":\"Aprova\\u00e7\\u00e3o\",\"imagem_desktop\":\"db6482a599685b4bf78f314e52712e0e.jpg\",\"imagem_mobile\":\"e9c493c3365e31f9df41027b06732bdf.jpg\",\"categoriaId\":\"2\",\"colaboradorId\":\"13\",\"titulo\":\"sadas\",\"subtitulo\":\"\",\"lide\":\"asdasd\",\"texto\":\"asdas\",\"tipo\":\"noticia\",\"tags\":\"asdasd\",\"status\":\"pendente\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:26:05','::1'),(844,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":9,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"d897593062e30a10032faf1aa4fbf8f2.jpg\",\"imagem_mobile\":\"baa1262aaf3fb9ae34ef87fead199118.jpg\",\"categoriaId\":\"3\",\"colaboradorId\":\"14\",\"titulo\":\"sadfsdaf\",\"subtitulo\":\"asdasdas\",\"lide\":\"sadfdsa\",\"texto\":\"sdafsda\",\"tipo\":\"noticia\",\"tags\":\"asdfdsaf\",\"status\":\"rascunho\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:26:47','::1'),(845,15,'Redator (redator)','admin','gm_materias',_binary '{\"idNoticia\":\"9\",\"titulo\":\"sadfsdaf\",\"subtitulo\":\"asdasdas\",\"lide\":\"sadfdsa\",\"texto\":\"sdafsda\",\"categoriaId\":\"3\",\"autorId\":\"15\",\"colaboradorId\":\"14\",\"status\":\"rascunho\",\"apontamentos\":null,\"dataPublicacao\":null,\"tags\":\"asdfdsaf\",\"tipo\":\"noticia\",\"criadoEm\":\"2024-07-28 11:26:47\",\"atualizadoEm\":\"2024-07-28 11:26:47\",\"ultimaAlteracao\":null,\"isRascunho\":\"Rascunho\",\"imagem_desktop\":\"d897593062e30a10032faf1aa4fbf8f2.jpg\",\"imagem_mobile\":\"baa1262aaf3fb9ae34ef87fead199118.jpg\"}',_binary '{\"idNoticia\":9,\"isRascunho\":\"Aprova\\u00e7\\u00e3o\",\"categoriaId\":\"3\",\"colaboradorId\":\"14\",\"titulo\":\"sadfsdaf\",\"subtitulo\":\"asdasdas\",\"lide\":\"sadfdsa\",\"texto\":\"sdafsda\",\"tipo\":\"noticia\",\"tags\":\"asdfdsaf\",\"status\":\"pendente\"}','UPDATE','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:26:55','::1'),(846,15,'Redator (redator)','admin','gm_programacaoradio',NULL,_binary '{\"idRadio\":7,\"data\":\"2024-07-28\",\"periodo\":\"Matutino\",\"locutor1\":\"13\",\"locutor2\":\"14\",\"locutor3\":\"14\",\"calendario_sazonal\":\"sadasda\",\"musica1\":\"sadas\",\"comentario_musica1\":\"asdas\",\"noticia1\":\"asdasd\",\"musica2\":\"asdas\",\"comentario_musica2\":\"asdas\",\"curiosidade_dia\":\"sasadas\",\"musica3\":\"sadas\",\"comentario_musica3\":\"asdas\",\"noticia_urgente\":\"asdas\",\"encerramento\":\"asdasd\",\"musica4\":\"sad\",\"musica5\":\"asda\",\"musica6\":\"sadas\",\"pauta_escrita\":\"<p><strong>LOCUTORES:<\\/strong><br \\/>\\r\\nSoltem a vinheta de abertura. Ap\\u00f3s ela, sigam o roteiro abaixo!<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nEu sou ___.<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nE eu sou ____, e estaremos com voc\\u00eas nas ondas da nossa r\\u00e1dio at\\u00e9 \\u00e0s 10:30.<\\/p>\\r\\n\\r\\n<p><strong>CALEND\\u00c1RIO SAZONAL<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\n(Calend\\u00e1rio sazonal aqui...)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nE vamos agora para nossa primeira faixa do dia!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 1:<\\/strong><br \\/>\\r\\n(Primeira&nbsp;m\\u00fasica do dia aqui...)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nVoc\\u00ea ouviu ___.<\\/p>\\r\\n\\r\\n<p><strong>NOT\\u00cdCIA<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\n(Primeira Not\\u00edcia aqui)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nE vamos pra nossa pr\\u00f3xima faixa!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 2:<\\/strong><br \\/>\\r\\n(Segunda m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nVoc\\u00ea escutou ___.<\\/p>\\r\\n\\r\\n<p><strong>CURIOSIDADE DO DIA<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\n(Curiosidade do dia aqui...)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nE vamos de mais m\\u00fasica!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 3:<\\/strong><br \\/>\\r\\n(Terceira m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nVoc\\u00ea acabou de ouvir ___.<\\/p>\\r\\n\\r\\n<p><strong>NOT\\u00cdCIA URGENTE<\\/strong><br \\/>\\r\\n<strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\n(Insira a not\\u00edcia urgente aqui)<\\/p>\\r\\n\\r\\n<p><strong>Evento ap\\u00f3s intervalo<\\/strong><\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 1:<\\/strong><br \\/>\\r\\nMas infelizmente a nossa r\\u00e1dio j\\u00e1 est\\u00e1 chegando ao fim!<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 2:<\\/strong><br \\/>\\r\\nMuito obrigado a todos que estiveram com a gente!<\\/p>\\r\\n\\r\\n<p><strong>LOCUTOR 3:<\\/strong><br \\/>\\r\\nMuito obrigado! Tenham um bom dia, um \\u00f3timo fim de semana e bons estudos! Tchau!<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 4:<\\/strong><br \\/>\\r\\n(Quarta m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 5:<\\/strong><br \\/>\\r\\n(Insira a m\\u00fasica aqui)<\\/p>\\r\\n\\r\\n<p><strong>M\\u00daSICA 6:<\\/strong><br \\/>\\r\\n(Insira a m\\u00fasica aqui)<\\/p>\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:27:33','::1'),(847,15,'Redator (redator)','admin','gm_materias',NULL,_binary '{\"idNoticia\":10,\"isRascunho\":\"Aprova\\u00e7\\u00e3o\",\"imagem_desktop\":\"e5696a957d2aac70ff773d8384262aab.jpg\",\"imagem_mobile\":\"4c4520fa4f26aed44dac61899ca8c901.jpg\",\"categoriaId\":\"5\",\"colaboradorId\":\"15\",\"titulo\":\"sfsdfsd\",\"subtitulo\":\"\",\"lide\":\"\",\"texto\":\"sdfsdfsdf\",\"tipo\":\"poesia\",\"tags\":\"sdfsdf\",\"status\":\"pendente\",\"autorId\":\"15\"}','INSERT','\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/127.0.0.0 Safari\\/537.36\"','2024-07-28 11:30:57','::1');
/*!40000 ALTER TABLE `gm_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_materias`
--

DROP TABLE IF EXISTS `gm_materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_materias` (
  `idNoticia` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `lide` text DEFAULT NULL,
  `texto` text NOT NULL,
  `categoriaId` int(11) DEFAULT NULL,
  `autorId` int(11) NOT NULL,
  `colaboradorId` int(11) DEFAULT NULL,
  `status` enum('rascunho','pendente','publicado','rejeitado') DEFAULT 'rascunho',
  `apontamentos` text DEFAULT NULL,
  `dataPublicacao` datetime DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `tipo` enum('noticia','poesia') NOT NULL,
  `criadoEm` datetime DEFAULT current_timestamp(),
  `atualizadoEm` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ultimaAlteracao` varchar(255) DEFAULT NULL,
  `isRascunho` enum('Rascunho','Aprovação') NOT NULL DEFAULT 'Rascunho',
  `imagem_desktop` varchar(255) DEFAULT NULL,
  `imagem_mobile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idNoticia`),
  KEY `categoriaId` (`categoriaId`),
  KEY `autorId` (`autorId`),
  KEY `colaboradorId` (`colaboradorId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_materias`
--

LOCK TABLES `gm_materias` WRITE;
/*!40000 ALTER TABLE `gm_materias` DISABLE KEYS */;
INSERT INTO `gm_materias` VALUES (5,'Cessna Citation CJ1','sdfsdf','sdfsdfsdfs','sdfsdfsd',3,15,14,'publicado','sdfgfdgsd','2024-07-28 10:49:06','sdfsdfsd','noticia','2024-07-28 10:48:39','2024-07-28 10:49:06',NULL,'Aprovação','5c21c5084c4e6a1f74656238392cf4a1.jpg','0ba5482cbb0bac44b2eed53a73e46207.jpg'),(6,'sdfsdfsdfsd','sdfsd','sdfsdf','sdfsdfsd',3,15,14,'pendente',NULL,NULL,'sdfsdf','noticia','2024-07-28 10:57:41','2024-07-28 10:57:41',NULL,'Aprovação','43288a358c3eff2d1cf950d92afd10f4.jpg','67df195070eeea3638e71bbe98328766.jpg'),(7,'asdsad','','asdsad','asdsads',2,15,15,'pendente',NULL,NULL,'asdasdas','noticia','2024-07-28 11:24:53','2024-07-28 11:25:02',NULL,'Aprovação','fec8896c40fdad35ad8479f35fbba9a1.jpg','44eacffaba7c3614d124fabcc7bca3aa.jpg'),(8,'sadas','','asdasd','asdas',2,15,13,'pendente',NULL,NULL,'asdasd','noticia','2024-07-28 11:26:05','2024-07-28 11:26:05',NULL,'Aprovação','db6482a599685b4bf78f314e52712e0e.jpg','e9c493c3365e31f9df41027b06732bdf.jpg'),(9,'sadfsdaf','asdasdas','sadfdsa','sdafsda',3,15,14,'pendente',NULL,NULL,'asdfdsaf','noticia','2024-07-28 11:26:47','2024-07-28 11:26:55',NULL,'Aprovação','d897593062e30a10032faf1aa4fbf8f2.jpg','baa1262aaf3fb9ae34ef87fead199118.jpg'),(10,'sfsdfsd','','','sdfsdfsdf',5,15,15,'pendente',NULL,NULL,'sdfsdf','poesia','2024-07-28 11:30:57','2024-07-28 11:30:57',NULL,'Aprovação','e5696a957d2aac70ff773d8384262aab.jpg','4c4520fa4f26aed44dac61899ca8c901.jpg');
/*!40000 ALTER TABLE `gm_materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_menucategorias`
--

DROP TABLE IF EXISTS `gm_menucategorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_menucategorias` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT COMMENT '\n',
  `icone` varchar(255) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `ordenacao` int(11) NOT NULL,
  PRIMARY KEY (`idcategoria`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_menucategorias`
--

LOCK TABLES `gm_menucategorias` WRITE;
/*!40000 ALTER TABLE `gm_menucategorias` DISABLE KEYS */;
INSERT INTO `gm_menucategorias` VALUES (1,'mdi-view-dashboard','Administração',1),(2,'mdi-home-city-outline','Institucional',5),(3,'mdi-file-document-box-search-outline','Consultas',10),(5,'mdi mdi-newspaper-variant','Matérias',3),(6,'mdi mdi-tools','Desenvolvimento',2),(7,'mdi mdi-image-area','Charges',4),(8,'mdi mdi-radio-tower','Programação Rádio',6);
/*!40000 ALTER TABLE `gm_menucategorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_menuitens`
--

DROP TABLE IF EXISTS `gm_menuitens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_menuitens` (
  `iditem` int(11) NOT NULL AUTO_INCREMENT,
  `idperfil` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `controlador` varchar(50) NOT NULL,
  `acao` varchar(50) NOT NULL,
  `parametros` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`iditem`) USING BTREE,
  KEY `fk_menu_itens_menu_categorias1` (`idcategoria`) USING BTREE,
  KEY `fk_menu_itens_perfis1` (`idperfil`) USING BTREE,
  CONSTRAINT `fk_menu_itens_menu_categorias1` FOREIGN KEY (`idcategoria`) REFERENCES `gm_menucategorias` (`idcategoria`),
  CONSTRAINT `fk_menu_itens_perfis1` FOREIGN KEY (`idperfil`) REFERENCES `gm_perfis` (`idperfil`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_menuitens`
--

LOCK TABLES `gm_menuitens` WRITE;
/*!40000 ALTER TABLE `gm_menuitens` DISABLE KEYS */;
INSERT INTO `gm_menuitens` VALUES (1,99,6,'Menu | Categorias','admin','menuscategorias','list',''),(2,99,6,'Menu | Itens','admin','menusitens','list',''),(3,99,6,'Perfil usuários','admin','perfis','list',''),(4,90,1,'Usuários','admin','usuarios','list',NULL),(5,2,1,'Trocar senha','admin','usuarios','trocarsenha',NULL),(6,90,1,'Configurações','admin','configuracoes','form','/idconfiguracao/1'),(7,99,1,'Logs admin','admin','logs','list',NULL),(18,2,3,'Contatos','admin','contatos','list',NULL),(37,2,3,'Emails','admin','emails','list',''),(38,2,5,'Matérias | Meus Rascunhos','admin','materiasrascunhos','list',''),(39,90,5,'Matérias | Categorias','admin','materiascategoria','list',''),(40,2,5,'Matérias | Publicadas','admin','materiaspublicadas','list',''),(41,90,5,'Matérias | Pendentes','admin','materiaspendente','list',''),(42,2,5,'Matérias | Rejeitados','admin','materiasrejeitado','list',''),(43,99,6,'Logs do Painel','admin','logs','list',''),(45,2,7,'Charges | Editor','admin','charges','list',''),(46,90,7,'Charges | Pendentes','admin','chargespendente','list',''),(47,2,7,'Charges | Rejeitados','admin','chargesrejeitado','list',''),(48,2,7,'Charges | Publicadas','admin','chargespublicadas','list',''),(49,2,8,'Rádio | Editor','admin','radio','list',''),(50,2,8,'Rádio | Histórico','admin','radioafter','list',''),(51,90,1,'Séries','admin','serie','list',''),(52,90,1,'Turmas','admin','turma','list','');
/*!40000 ALTER TABLE `gm_menuitens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_notificacoes`
--

DROP TABLE IF EXISTS `gm_notificacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_notificacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `item_id` int(11) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_notificacoes`
--

LOCK TABLES `gm_notificacoes` WRITE;
/*!40000 ALTER TABLE `gm_notificacoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `gm_notificacoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_perfis`
--

DROP TABLE IF EXISTS `gm_perfis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_perfis` (
  `idperfil` int(11) NOT NULL,
  `descricao` varchar(80) NOT NULL,
  PRIMARY KEY (`idperfil`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_perfis`
--

LOCK TABLES `gm_perfis` WRITE;
/*!40000 ALTER TABLE `gm_perfis` DISABLE KEYS */;
INSERT INTO `gm_perfis` VALUES (2,'Redator'),(90,'Administrador'),(99,'Desenvolvimento');
/*!40000 ALTER TABLE `gm_perfis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_programacaoradio`
--

DROP TABLE IF EXISTS `gm_programacaoradio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_programacaoradio` (
  `idRadio` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `periodo` enum('Matutino','Vespertino') NOT NULL,
  `locutor1` int(11) DEFAULT NULL,
  `locutor2` int(11) DEFAULT NULL,
  `locutor3` int(11) DEFAULT NULL,
  `calendario_sazonal` text DEFAULT NULL,
  `musica1` varchar(100) DEFAULT NULL,
  `musica2` varchar(100) DEFAULT NULL,
  `musica3` varchar(100) DEFAULT NULL,
  `musica4` varchar(100) DEFAULT NULL,
  `musica5` varchar(100) DEFAULT NULL,
  `musica6` varchar(100) DEFAULT NULL,
  `comentario_musica1` text DEFAULT NULL,
  `comentario_musica2` text DEFAULT NULL,
  `comentario_musica3` text DEFAULT NULL,
  `noticia1` text DEFAULT NULL,
  `curiosidade_dia` text DEFAULT NULL,
  `noticia_urgente` text DEFAULT NULL,
  `encerramento` text DEFAULT NULL,
  `pauta_escrita` text DEFAULT NULL,
  PRIMARY KEY (`idRadio`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_programacaoradio`
--

LOCK TABLES `gm_programacaoradio` WRITE;
/*!40000 ALTER TABLE `gm_programacaoradio` DISABLE KEYS */;
INSERT INTO `gm_programacaoradio` VALUES (1,'2024-07-25','Matutino',13,29,30,'sadfasdf','safdsad','asdfasd','sdafsad','sadfsda','sadfsad','sdfsda','sdafsdaf','sdafsda','sdaf','safsda','sdafsda','sdfsda','sadfsdaf',NULL),(2,'2024-07-26','Matutino',28,27,30,'sdgfdsgdfgsdfgfsdgsdfgdf','sdfgfsdgfsdgdfs','fdsgfdsgdfsgdfsgdfs','fdsgfdsgdsf','dsfgfdsgdfs','gdfgdfsg','dfgdfgdsf','fsdgdfgfdsgfsd','fdsgfsdgdfgdgsdfg','fdsgdfsgdfsgdfsg','sdfgsdfgfsdgsdfgdfs','sdfgfdsgfdsgsdfgsdfg','fdgfdgfdsgsdfg','dfsgfdsgfdsgdfsgs','<p><strong>LOCUTORES:</strong><br />\r\nSoltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nEu sou ___.</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>\r\n\r\n<p><strong>CALENDÁRIO SAZONAL</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Calendário sazonal aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nE vamos agora para nossa primeira faixa do dia!</p>\r\n\r\n<p><strong>MÚSICA 1:</strong><br />\r\n(Primeira&nbsp;música do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nVocê ouviu ___.</p>\r\n\r\n<p><strong>NOTÍCIA</strong><br />\r\n<strong>LOCUTOR 2:</strong><br />\r\n(Primeira Notícia aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE vamos pra nossa próxima faixa!</p>\r\n\r\n<p><strong>MÚSICA 2:</strong><br />\r\n(Segunda música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nVocê escutou ___.</p>\r\n\r\n<p><strong>CURIOSIDADE DO DIA</strong><br />\r\n<strong>LOCUTOR 3:</strong><br />\r\n(Curiosidade do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nE vamos de mais música!</p>\r\n\r\n<p><strong>MÚSICA 3:</strong><br />\r\n(Terceira música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nVocê acabou de ouvir ___.</p>\r\n\r\n<p><strong>NOTÍCIA URGENTE</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Insira a notícia urgente aqui)</p>\r\n\r\n<p><strong>Evento após intervalo</strong></p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nMas infelizmente a nossa rádio já está chegando ao fim!</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nMuito obrigado a todos que estiveram com a gente!</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nMuito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>\r\n\r\n<p><strong>MÚSICA 4:</strong><br />\r\n(Quarta música aqui)</p>\r\n\r\n<p><strong>MÚSICA 5:</strong><br />\r\n(Insira a música aqui)</p>\r\n\r\n<p><strong>MÚSICA 6:</strong><br />\r\n(Insira a música aqui)</p>'),(3,'2024-07-27','Matutino',29,30,24,'Teste de Calendário Sazonal','M´pusicaaa','musica 2','musica 3','musica 4','musica 5','musica 6','comentpário','comantaio de musica 2','comntario da teceri amusica','Noticia','criosdade do dia','ntoicioa urgente','encerrametno','<p>testeeeeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>LOCUTORES:</strong><br />\r\nSoltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nEu sou ___.</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>\r\n\r\n<p><strong>CALENDÁRIO SAZONAL</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Calendário sazonal aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nE vamos agora para nossa primeira faixa do dia!</p>\r\n\r\n<p><strong>MÚSICA 1:</strong><br />\r\n(Primeira&nbsp;música do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nVocê ouviu ___.</p>\r\n\r\n<p><strong>NOTÍCIA</strong><br />\r\n<strong>LOCUTOR 2:</strong><br />\r\n(Primeira Notícia aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE vamos pra nossa próxima faixa!</p>\r\n\r\n<p><strong>MÚSICA 2:</strong><br />\r\n(Segunda música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nVocê escutou ___.</p>\r\n\r\n<p><strong>CURIOSIDADE DO DIA</strong><br />\r\n<strong>LOCUTOR 3:</strong><br />\r\n(Curiosidade do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nE vamos de mais música!</p>\r\n\r\n<p><strong>MÚSICA 3:</strong><br />\r\n(Terceira música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nVocê acabou de ouvir ___.</p>\r\n\r\n<p><strong>NOTÍCIA URGENTE</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Insira a notícia urgente aqui)</p>\r\n\r\n<p><strong>Evento após intervalo</strong></p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nMas infelizmente a nossa rádio já está chegando ao fim!</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nMuito obrigado a todos que estiveram com a gente!</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nMuito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>\r\n\r\n<p><strong>MÚSICA 4:</strong><br />\r\n(Quarta música aqui)</p>\r\n\r\n<p><strong>MÚSICA 5:</strong><br />\r\n(Insira a música aqui)</p>\r\n\r\n<p><strong>MÚSICA 6:</strong><br />\r\n(Insira a música aqui)</p>'),(4,'2024-07-26','Matutino',30,30,28,'asdasd','asdasd','asdfasd','asdasd','asdas','asdas','sadsa','sadsad','asdsa','asdas','asdasd','asdasd','asdas','dasd','<p><strong>LOCUTORES:</strong><br />\r\nSoltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nEu sou ___.</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>\r\n\r\n<p><strong>CALENDÁRIO SAZONAL</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Calendário sazonal aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nE vamos agora para nossa primeira faixa do dia!</p>\r\n\r\n<p><strong>MÚSICA 1:</strong><br />\r\n(Primeira&nbsp;música do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nVocê ouviu ___.</p>\r\n\r\n<p><strong>NOTÍCIA</strong><br />\r\n<strong>LOCUTOR 2:</strong><br />\r\n(Primeira Notícia aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE vamos pra nossa próxima faixa!</p>\r\n\r\n<p><strong>MÚSICA 2:</strong><br />\r\n(Segunda música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nVocê escutou ___.</p>\r\n\r\n<p><strong>CURIOSIDADE DO DIA</strong><br />\r\n<strong>LOCUTOR 3:</strong><br />\r\n(Curiosidade do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nE vamos de mais música!</p>\r\n\r\n<p><strong>MÚSICA 3:</strong><br />\r\n(Terceira música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nVocê acabou de ouvir ___.</p>\r\n\r\n<p><strong>NOTÍCIA URGENTE</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Insira a notícia urgente aqui)</p>\r\n\r\n<p><strong>Evento após intervalo</strong></p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nMas infelizmente a nossa rádio já está chegando ao fim!</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nMuito obrigado a todos que estiveram com a gente!</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nMuito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>\r\n\r\n<p><strong>MÚSICA 4:</strong><br />\r\n(Quarta música aqui)</p>\r\n\r\n<p><strong>MÚSICA 5:</strong><br />\r\n(Insira a música aqui)</p>\r\n\r\n<p><strong>MÚSICA 6:</strong><br />\r\n(Insira a música aqui)</p>'),(5,'2024-07-28','Matutino',14,14,14,'sdfgfdsgfsdg','sdfg','sfdsg','gdfsgfsd','fdsgdfs','fdgdfs','fdsgsd','fsdgfsd','dfsgfd','dfsgfds','dfsgsd','fdsgfsd','fdsgfsd','dfgfdsg','<p><strong>LOCUTORES:</strong><br />\r\nSoltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nEu sou ___.</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>\r\n\r\n<p><strong>CALENDÁRIO SAZONAL</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Calendário sazonal aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nE vamos agora para nossa primeira faixa do dia!</p>\r\n\r\n<p><strong>MÚSICA 1:</strong><br />\r\n(Primeira&nbsp;música do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nVocê ouviu ___.</p>\r\n\r\n<p><strong>NOTÍCIA</strong><br />\r\n<strong>LOCUTOR 2:</strong><br />\r\n(Primeira Notícia aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE vamos pra nossa próxima faixa!</p>\r\n\r\n<p><strong>MÚSICA 2:</strong><br />\r\n(Segunda música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nVocê escutou ___.</p>\r\n\r\n<p><strong>CURIOSIDADE DO DIA</strong><br />\r\n<strong>LOCUTOR 3:</strong><br />\r\n(Curiosidade do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nE vamos de mais música!</p>\r\n\r\n<p><strong>MÚSICA 3:</strong><br />\r\n(Terceira música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nVocê acabou de ouvir ___.</p>\r\n\r\n<p><strong>NOTÍCIA URGENTE</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Insira a notícia urgente aqui)</p>\r\n\r\n<p><strong>Evento após intervalo</strong></p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nMas infelizmente a nossa rádio já está chegando ao fim!</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nMuito obrigado a todos que estiveram com a gente!</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nMuito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>\r\n\r\n<p><strong>MÚSICA 4:</strong><br />\r\n(Quarta música aqui)</p>\r\n\r\n<p><strong>MÚSICA 5:</strong><br />\r\n(Insira a música aqui)</p>\r\n\r\n<p><strong>MÚSICA 6:</strong><br />\r\n(Insira a música aqui)</p>'),(6,'2024-07-28','Vespertino',14,14,15,'sadfsdaf','asdfsda','sadfsda','sdafsdaf','sdafsda','sdfsda','sadfsa','sdafsda','sdfsda','sdfasda','sdafsda','sdafsdaf','sdafsdaf','sdfsad','<p><strong>LOCUTORES:</strong><br />\r\nSoltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nEu sou ___.</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>\r\n\r\n<p><strong>CALENDÁRIO SAZONAL</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Calendário sazonal aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nE vamos agora para nossa primeira faixa do dia!</p>\r\n\r\n<p><strong>MÚSICA 1:</strong><br />\r\n(Primeira&nbsp;música do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nVocê ouviu ___.</p>\r\n\r\n<p><strong>NOTÍCIA</strong><br />\r\n<strong>LOCUTOR 2:</strong><br />\r\n(Primeira Notícia aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE vamos pra nossa próxima faixa!</p>\r\n\r\n<p><strong>MÚSICA 2:</strong><br />\r\n(Segunda música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nVocê escutou ___.</p>\r\n\r\n<p><strong>CURIOSIDADE DO DIA</strong><br />\r\n<strong>LOCUTOR 3:</strong><br />\r\n(Curiosidade do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nE vamos de mais música!</p>\r\n\r\n<p><strong>MÚSICA 3:</strong><br />\r\n(Terceira música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nVocê acabou de ouvir ___.</p>\r\n\r\n<p><strong>NOTÍCIA URGENTE</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Insira a notícia urgente aqui)</p>\r\n\r\n<p><strong>Evento após intervalo</strong></p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nMas infelizmente a nossa rádio já está chegando ao fim!</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nMuito obrigado a todos que estiveram com a gente!</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nMuito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>\r\n\r\n<p><strong>MÚSICA 4:</strong><br />\r\n(Quarta música aqui)</p>\r\n\r\n<p><strong>MÚSICA 5:</strong><br />\r\n(Insira a música aqui)</p>\r\n\r\n<p><strong>MÚSICA 6:</strong><br />\r\n(Insira a música aqui)</p>'),(7,'2024-07-28','Matutino',13,14,14,'sadasda','sadas','asdas','sadas','sad','asda','sadas','asdas','asdas','asdas','asdasd','sasadas','asdas','asdasd','<p><strong>LOCUTORES:</strong><br />\r\nSoltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nEu sou ___.</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>\r\n\r\n<p><strong>CALENDÁRIO SAZONAL</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Calendário sazonal aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nE vamos agora para nossa primeira faixa do dia!</p>\r\n\r\n<p><strong>MÚSICA 1:</strong><br />\r\n(Primeira&nbsp;música do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nVocê ouviu ___.</p>\r\n\r\n<p><strong>NOTÍCIA</strong><br />\r\n<strong>LOCUTOR 2:</strong><br />\r\n(Primeira Notícia aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE vamos pra nossa próxima faixa!</p>\r\n\r\n<p><strong>MÚSICA 2:</strong><br />\r\n(Segunda música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nVocê escutou ___.</p>\r\n\r\n<p><strong>CURIOSIDADE DO DIA</strong><br />\r\n<strong>LOCUTOR 3:</strong><br />\r\n(Curiosidade do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nE vamos de mais música!</p>\r\n\r\n<p><strong>MÚSICA 3:</strong><br />\r\n(Terceira música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nVocê acabou de ouvir ___.</p>\r\n\r\n<p><strong>NOTÍCIA URGENTE</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Insira a notícia urgente aqui)</p>\r\n\r\n<p><strong>Evento após intervalo</strong></p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nMas infelizmente a nossa rádio já está chegando ao fim!</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nMuito obrigado a todos que estiveram com a gente!</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nMuito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>\r\n\r\n<p><strong>MÚSICA 4:</strong><br />\r\n(Quarta música aqui)</p>\r\n\r\n<p><strong>MÚSICA 5:</strong><br />\r\n(Insira a música aqui)</p>\r\n\r\n<p><strong>MÚSICA 6:</strong><br />\r\n(Insira a música aqui)</p>');
/*!40000 ALTER TABLE `gm_programacaoradio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_serie`
--

DROP TABLE IF EXISTS `gm_serie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_serie` (
  `idserie` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(40) NOT NULL,
  PRIMARY KEY (`idserie`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_serie`
--

LOCK TABLES `gm_serie` WRITE;
/*!40000 ALTER TABLE `gm_serie` DISABLE KEYS */;
INSERT INTO `gm_serie` VALUES (1,'6° EF'),(2,'7°  EF'),(3,'8° EF '),(4,'9° EF'),(5,'1° EM'),(6,'2° EM'),(7,'3° EM'),(8,'Colaborador');
/*!40000 ALTER TABLE `gm_serie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gm_turma`
--

DROP TABLE IF EXISTS `gm_turma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gm_turma` (
  `idturma` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(40) NOT NULL,
  PRIMARY KEY (`idturma`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_turma`
--

LOCK TABLES `gm_turma` WRITE;
/*!40000 ALTER TABLE `gm_turma` DISABLE KEYS */;
INSERT INTO `gm_turma` VALUES (1,'A'),(2,'B'),(3,'C'),(4,'Colaborador');
/*!40000 ALTER TABLE `gm_turma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `idperfil` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login` varchar(45) NOT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `chave` varchar(32) DEFAULT NULL,
  `sendmail` datetime DEFAULT NULL,
  `serie` int(1) DEFAULT NULL,
  `turma` varchar(1) DEFAULT NULL,
  `instagram` varchar(120) DEFAULT NULL,
  `linkedin` varchar(120) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idusuario`) USING BTREE,
  KEY `fk_usuarios_perfis1` (`idperfil`) USING BTREE,
  CONSTRAINT `fk_usuarios_perfis1` FOREIGN KEY (`idperfil`) REFERENCES `gm_perfis` (`idperfil`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (13,90,'4d3c9678bc8ab80c9c3175b40bd26060.jpg','Admin','admin@gmail.com.br','admin','21232f297a57a5a743894a0e4a801fc3',NULL,NULL,8,'4','',NULL,1),(14,99,'16fa94f8bc10e08c32343d76cacb0168.jpg','Desenvolvimento','dev@gmail.com','developer','5e8edd851d2fdfbd7415232c67367cc3',NULL,NULL,8,'4','',NULL,1),(15,2,'73fe9b8b8fa68ed856a2e199d68fdb46.png','Redator','redator@gmail.com','redator','eab9e1f8e8c7421c149be0fd8cae0114',NULL,'2024-07-24 20:52:02',1,'2','',NULL,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-28 11:36:22
