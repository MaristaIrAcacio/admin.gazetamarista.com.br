-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: gazetamarista
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_charges`
--

LOCK TABLES `gm_charges` WRITE;
/*!40000 ALTER TABLE `gm_charges` DISABLE KEYS */;
INSERT INTO `gm_charges` VALUES (4,'04c5ac262d6c80f7cc7a78b5718ebf94.png',15,13,30,NULL,'publicado','A imagem está em baixa qualidade!','2024-07-24 22:03:12','2024-07-24 22:02:09','2024-07-24 22:03:12','Título','Descrição'),(6,'dc70527cbd6b9b2878c5bb4507112940.png',13,30,NULL,NULL,'publicado',NULL,'2024-07-27 10:39:54','2024-07-27 10:39:46','2024-07-27 10:39:54','sadfsdaf','sdafdas'),(7,'8c26c623c43550b4d25584e3179b75d3.png',13,30,NULL,NULL,'publicado','cb','2024-07-27 10:40:56','2024-07-27 10:40:30','2024-07-27 10:40:56','sdfg','sdfgfsdg');
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
) ENGINE=InnoDB AUTO_INCREMENT=799 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_logs`
--

LOCK TABLES `gm_logs` WRITE;
/*!40000 ALTER TABLE `gm_logs` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_materias`
--

LOCK TABLES `gm_materias` WRITE;
/*!40000 ALTER TABLE `gm_materias` DISABLE KEYS */;
INSERT INTO `gm_materias` VALUES (1,'Cessna Citation CJ1','asdasdsadsadsadsdsa','teste','teste',1,12,13,'publicado',NULL,'2024-07-24 20:44:47','sdfgfsdgfdsgfds','noticia','2024-07-24 20:34:44','2024-07-24 20:44:47',NULL,'Rascunho','19badbad3a08a6b24b5e9f0efed6fa03.png','ded76796a388530cf9e8e6c01183e434.png'),(2,'Título','Subtítulo','Lide da Notícia','Corpo do Texto',1,12,11,'publicado','teste','2024-07-24 20:45:48','sdfgfsdgfdsgfds','noticia','2024-07-24 20:44:07','2024-07-24 20:45:48',NULL,'Aprovação','c7888e763828b3c89ef9e210cbc6804b.png','7a7693b2bb2135881ea124a4de305b1b.png'),(3,'ACAMPAMENTO RAIO DE LUZ REÚNE ESTUDANTES DE COLÉGIOS MARISTAS E ESCOLAS SOCIAIS EM CASCAVEL, PARANÁ','teste','Cascavel, Paraná - O Acampamento Raio de Luz, realizado em parceria com o Colégio Marista, Marista Escolas Sociais Irmão Acácio de Londrina e Marista Escolas Sociais de Cascavel, proporcionou momentos de integração e espiritualidade para os jovens participantes.','<p>No primeiro dia do acampamento, os estudantes foram divididos em seis grupos, com o objetivo de promover a interação entre eles. Além disso, as barracas foram montadas para o acampamento ao ar livre, proporcionando uma experiência única em meio à natureza. Para encerrar o dia, foi realizada a vigília de Taizé, com o tema &quot;o amor de Deus&quot;.</p>\r\n\r\n<p>No segundo dia, os participantes acordaram às 6:00 da manhã e participaram do &quot;Ofício da manhã - oração&quot;. Em seguida, receberam kits de lanches e partiram para uma trilha na cidade de Cascavel, no Monte Sidinai. Foram percorridos 12km de trilha, com paradas estratégicas ao longo do percurso. Ao final, os jovens tiveram a oportunidade de conhecer uma cachoeira maravilhosa, proporcionando momentos de contemplação e conexão com a natureza.</p>\r\n\r\n<p>Após a trilha, os participantes retornaram ao Recanto Marista, onde puderam conhecer a Escola Marista Social de Cascavel. Na parte da noite, todos se reuniram novamente no recanto para se arrumarem e irem a uma missa. Após a celebração, os estudantes de Londrina partiram para suas casas, encerrando sua participação no acampamento.</p>\r\n\r\n<p>O Acampamento Raio de Luz em Cascavel, Paraná, foi marcado por momentos de integração, espiritualidade e contato com a natureza. A parceria entre os colégios maristas proporcionou uma experiência enriquecedora para os participantes, fortalecendo os laços entre os estudantes e promovendo o desenvolvimento pessoal e social de todos os envolvidos.</p>',5,15,20,'publicado','Não gostei muito da imagem de capa, poderia procurar uma com uma qualidade melhor.\r\n\r\nO texto ficou muito bom, a lide ficou bem escrita!','2024-07-27 10:22:29','Acampamento, Natureza, Trilha, Paraná, espiritualidade','noticia','2024-07-27 10:19:26','2024-07-27 10:22:29',NULL,'Aprovação','3c100ff2f6e910c85b4e0ac0241960be.png','e5cc2d0780d7b603372d104aed722145.png');
/*!40000 ALTER TABLE `gm_materias` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gm_programacaoradio`
--

LOCK TABLES `gm_programacaoradio` WRITE;
/*!40000 ALTER TABLE `gm_programacaoradio` DISABLE KEYS */;
INSERT INTO `gm_programacaoradio` VALUES (1,'2024-07-25','Matutino',13,29,30,'sadfasdf','safdsad','asdfasd','sdafsad','sadfsda','sadfsad','sdfsda','sdafsdaf','sdafsda','sdaf','safsda','sdafsda','sdfsda','sadfsdaf',NULL),(2,'2024-07-26','Matutino',28,27,30,'sdgfdsgdfgsdfgfsdgsdfgdf','sdfgfsdgfsdgdfs','fdsgfdsgdfsgdfsgdfs','fdsgfdsgdsf','dsfgfdsgdfs','gdfgdfsg','dfgdfgdsf','fsdgdfgfdsgfsd','fdsgfsdgdfgdgsdfg','fdsgdfsgdfsgdfsg','sdfgsdfgfsdgsdfgdfs','sdfgfdsgfdsgsdfgsdfg','fdgfdgfdsgsdfg','dfsgfdsgfdsgdfsgs','<p><strong>LOCUTORES:</strong><br />\r\nSoltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nEu sou ___.</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>\r\n\r\n<p><strong>CALENDÁRIO SAZONAL</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Calendário sazonal aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nE vamos agora para nossa primeira faixa do dia!</p>\r\n\r\n<p><strong>MÚSICA 1:</strong><br />\r\n(Primeira&nbsp;música do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nVocê ouviu ___.</p>\r\n\r\n<p><strong>NOTÍCIA</strong><br />\r\n<strong>LOCUTOR 2:</strong><br />\r\n(Primeira Notícia aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE vamos pra nossa próxima faixa!</p>\r\n\r\n<p><strong>MÚSICA 2:</strong><br />\r\n(Segunda música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nVocê escutou ___.</p>\r\n\r\n<p><strong>CURIOSIDADE DO DIA</strong><br />\r\n<strong>LOCUTOR 3:</strong><br />\r\n(Curiosidade do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nE vamos de mais música!</p>\r\n\r\n<p><strong>MÚSICA 3:</strong><br />\r\n(Terceira música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nVocê acabou de ouvir ___.</p>\r\n\r\n<p><strong>NOTÍCIA URGENTE</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Insira a notícia urgente aqui)</p>\r\n\r\n<p><strong>Evento após intervalo</strong></p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nMas infelizmente a nossa rádio já está chegando ao fim!</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nMuito obrigado a todos que estiveram com a gente!</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nMuito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>\r\n\r\n<p><strong>MÚSICA 4:</strong><br />\r\n(Quarta música aqui)</p>\r\n\r\n<p><strong>MÚSICA 5:</strong><br />\r\n(Insira a música aqui)</p>\r\n\r\n<p><strong>MÚSICA 6:</strong><br />\r\n(Insira a música aqui)</p>'),(3,'2024-07-27','Matutino',29,30,24,'Teste de Calendário Sazonal','M´pusicaaa','musica 2','musica 3','musica 4','musica 5','musica 6','comentpário','comantaio de musica 2','comntario da teceri amusica','Noticia','criosdade do dia','ntoicioa urgente','encerrametno','<p>testeeeeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>LOCUTORES:</strong><br />\r\nSoltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nEu sou ___.</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>\r\n\r\n<p><strong>CALENDÁRIO SAZONAL</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Calendário sazonal aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nE vamos agora para nossa primeira faixa do dia!</p>\r\n\r\n<p><strong>MÚSICA 1:</strong><br />\r\n(Primeira&nbsp;música do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nVocê ouviu ___.</p>\r\n\r\n<p><strong>NOTÍCIA</strong><br />\r\n<strong>LOCUTOR 2:</strong><br />\r\n(Primeira Notícia aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE vamos pra nossa próxima faixa!</p>\r\n\r\n<p><strong>MÚSICA 2:</strong><br />\r\n(Segunda música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nVocê escutou ___.</p>\r\n\r\n<p><strong>CURIOSIDADE DO DIA</strong><br />\r\n<strong>LOCUTOR 3:</strong><br />\r\n(Curiosidade do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nE vamos de mais música!</p>\r\n\r\n<p><strong>MÚSICA 3:</strong><br />\r\n(Terceira música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nVocê acabou de ouvir ___.</p>\r\n\r\n<p><strong>NOTÍCIA URGENTE</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Insira a notícia urgente aqui)</p>\r\n\r\n<p><strong>Evento após intervalo</strong></p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nMas infelizmente a nossa rádio já está chegando ao fim!</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nMuito obrigado a todos que estiveram com a gente!</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nMuito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>\r\n\r\n<p><strong>MÚSICA 4:</strong><br />\r\n(Quarta música aqui)</p>\r\n\r\n<p><strong>MÚSICA 5:</strong><br />\r\n(Insira a música aqui)</p>\r\n\r\n<p><strong>MÚSICA 6:</strong><br />\r\n(Insira a música aqui)</p>'),(4,'2024-07-26','Matutino',30,30,28,'asdasd','asdasd','asdfasd','asdasd','asdas','asdas','sadsa','sadsad','asdsa','asdas','asdasd','asdasd','asdas','dasd','<p><strong>LOCUTORES:</strong><br />\r\nSoltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nBom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nEu sou ___.</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>\r\n\r\n<p><strong>CALENDÁRIO SAZONAL</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Calendário sazonal aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nE vamos agora para nossa primeira faixa do dia!</p>\r\n\r\n<p><strong>MÚSICA 1:</strong><br />\r\n(Primeira&nbsp;música do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nVocê ouviu ___.</p>\r\n\r\n<p><strong>NOTÍCIA</strong><br />\r\n<strong>LOCUTOR 2:</strong><br />\r\n(Primeira Notícia aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nE vamos pra nossa próxima faixa!</p>\r\n\r\n<p><strong>MÚSICA 2:</strong><br />\r\n(Segunda música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nVocê escutou ___.</p>\r\n\r\n<p><strong>CURIOSIDADE DO DIA</strong><br />\r\n<strong>LOCUTOR 3:</strong><br />\r\n(Curiosidade do dia aqui...)</p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nE vamos de mais música!</p>\r\n\r\n<p><strong>MÚSICA 3:</strong><br />\r\n(Terceira música aqui)</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nVocê acabou de ouvir ___.</p>\r\n\r\n<p><strong>NOTÍCIA URGENTE</strong><br />\r\n<strong>LOCUTOR 1:</strong><br />\r\n(Insira a notícia urgente aqui)</p>\r\n\r\n<p><strong>Evento após intervalo</strong></p>\r\n\r\n<p><strong>LOCUTOR 1:</strong><br />\r\nMas infelizmente a nossa rádio já está chegando ao fim!</p>\r\n\r\n<p><strong>LOCUTOR 2:</strong><br />\r\nMuito obrigado a todos que estiveram com a gente!</p>\r\n\r\n<p><strong>LOCUTOR 3:</strong><br />\r\nMuito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>\r\n\r\n<p><strong>MÚSICA 4:</strong><br />\r\n(Quarta música aqui)</p>\r\n\r\n<p><strong>MÚSICA 5:</strong><br />\r\n(Insira a música aqui)</p>\r\n\r\n<p><strong>MÚSICA 6:</strong><br />\r\n(Insira a música aqui)</p>');
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
-- Table structure for table `menu_categorias`
--

DROP TABLE IF EXISTS `menu_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_categorias` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT COMMENT '\n',
  `icone` varchar(255) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `ordenacao` int(11) NOT NULL,
  PRIMARY KEY (`idcategoria`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_categorias`
--

LOCK TABLES `menu_categorias` WRITE;
/*!40000 ALTER TABLE `menu_categorias` DISABLE KEYS */;
INSERT INTO `menu_categorias` VALUES (1,'mdi-view-dashboard','Administração',1),(2,'mdi-home-city-outline','Institucional',5),(3,'mdi-file-document-box-search-outline','Consultas',10),(5,'mdi mdi-newspaper-variant','Matérias',3),(6,'mdi mdi-tools','Desenvolvimento',2),(7,'mdi mdi-image-area','Charges',4),(8,'mdi mdi-radio-tower','Programação Rádio',6);
/*!40000 ALTER TABLE `menu_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_itens`
--

DROP TABLE IF EXISTS `menu_itens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_itens` (
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
  CONSTRAINT `fk_menu_itens_menu_categorias1` FOREIGN KEY (`idcategoria`) REFERENCES `menu_categorias` (`idcategoria`),
  CONSTRAINT `fk_menu_itens_perfis1` FOREIGN KEY (`idperfil`) REFERENCES `gm_perfis` (`idperfil`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_itens`
--

LOCK TABLES `menu_itens` WRITE;
/*!40000 ALTER TABLE `menu_itens` DISABLE KEYS */;
INSERT INTO `menu_itens` VALUES (1,99,6,'Menu | Categorias','admin','menuscategorias','list',''),(2,99,6,'Menu | Itens','admin','menusitens','list',''),(3,99,6,'Perfil usuários','admin','perfis','list',''),(4,90,1,'Usuários','admin','usuarios','list',NULL),(5,2,1,'Trocar senha','admin','usuarios','trocarsenha',NULL),(6,90,1,'Configurações','admin','configuracoes','form','/idconfiguracao/1'),(7,99,1,'Logs admin','admin','logs','list',NULL),(18,2,3,'Contatos','admin','contatos','list',NULL),(37,2,3,'Emails','admin','emails','list',''),(38,2,5,'Matérias | Meus Rascunhos','admin','materiasrascunhos','list',''),(39,90,5,'Matérias | Categorias','admin','materiascategoria','list',''),(40,2,5,'Matérias | Publicadas','admin','materiaspublicadas','list',''),(41,90,5,'Matérias | Pendentes','admin','materiaspendente','list',''),(42,2,5,'Matérias | Rejeitados','admin','materiasrejeitado','list',''),(43,99,6,'Logs do Painel','admin','logs','list',''),(45,2,7,'Charges | Editor','admin','charges','list',''),(46,90,7,'Charges | Pendentes','admin','chargespendente','list',''),(47,2,7,'Charges | Rejeitados','admin','chargesrejeitado','list',''),(48,2,7,'Charges | Publicadas','admin','chargespublicadas','list',''),(49,2,8,'Rádio | Editor','admin','radio','list',''),(50,2,8,'Rádio | Histórico','admin','radioafter','list',''),(51,90,1,'Séries','admin','serie','list',''),(52,90,1,'Turmas','admin','turma','list','');
/*!40000 ALTER TABLE `menu_itens` ENABLE KEYS */;
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

-- Dump completed on 2024-07-27 14:10:46
