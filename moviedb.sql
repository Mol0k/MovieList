-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: moviedb
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tcomentarios`
--

DROP TABLE IF EXISTS `tcomentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tcomentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(2000) DEFAULT NULL,
  `movie_id` int(11) NOT NULL,
  `fecha_comentario` datetime DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `tcomentarios_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `tmovie` (`id`),
  CONSTRAINT `tcomentarios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `tuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tcomentarios`
--

LOCK TABLES `tcomentarios` WRITE;
/*!40000 ALTER TABLE `tcomentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcomentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tfavorites`
--

DROP TABLE IF EXISTS `tfavorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tfavorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `tfavorites_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `tmovie` (`id`),
  CONSTRAINT `tfavorites_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `tuser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tfavorites`
--

LOCK TABLES `tfavorites` WRITE;
/*!40000 ALTER TABLE `tfavorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `tfavorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmovie`
--

DROP TABLE IF EXISTS `tmovie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmovie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sinopsis` longtext NOT NULL,
  `image` varchar(200) NOT NULL,
  `created` date NOT NULL,
  `gender` varchar(500) NOT NULL,
  `duration` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmovie`
--

LOCK TABLES `tmovie` WRITE;
/*!40000 ALTER TABLE `tmovie` DISABLE KEYS */;
INSERT INTO `tmovie` VALUES 
(1,'Sonic 2, la película','Después de establecerse en Green Hills, Sonic se muere por demostrar que tiene madera de auténtico héroe. La prueba de fuego llega con el retorno del malvado Robotnik, en esta ocasión con un nuevo compinche, Knuckles, en busca de una esmeralda que tiene el poder de destruir civilizaciones. Sonic forma equipo con su propio compañero de fatigas, Tails, y juntos se lanzan a una aventura que les llevará por todo el mundo en busca de la preciada piedra para evitar que caiga en manos equivocadas.','movie-1.png','2022-04-01','a:3:{i:0;s:7:\"Acción\";i:1;s:7:\"Comedia\";i:2;s:9:\"Aventuras\";}','122 minutos'),
(2,'Morbius','El Doctor Michael Morbius (Jared Leto) es un bioquímico que sufre una extraña enfermedad en la sangre. Al intentar curarse y dar una respuesta a su trastorno se infecta sin darse cuenta con una forma de vampirismo. Tras la cura, Michael se siente más vivo que nunca y adquiere varios dones como fuerza y velocidad, además de una necesidad irresistible de consumir sangre. Trágicamente convertido en un imperfecto antihéroe, el Doctor Morbius tendrá una última oportunidad, pero sin saber a qué precio.','movie-2.png','2022-03-10','a:6:{i:0;s:7:\"Acción\";i:1;s:16:\"Ciencia ficción\";i:2;s:6:\"Terror\";i:3;s:9:\"Monstruos\";i:4;s:12:\"Superhéroes\";i:5;s:16:\"Fantasía oscura\";}','104 minutos'),
(3,'El proyecto Adam','Adam Reed (Reynolds) es un viajero del tiempo del año 2050, que se ha aventurado en una misión de rescate para buscar a Laura (Zoe Saldana), la mujer que ama, quien se perdió en el continuo espacio-tiempo en circunstancias misteriosas. Cuando la nave de Adam se estropea, es enviado en espiral al año 2022, y al único lugar que conoce de esta época de su vida: su casa, donde vive su yo cuando tenía 12 años.','movie-3.png','2022-03-11','a:3:{i:0;s:7:\"Acción\";i:1;s:9:\"Aventuras\";i:2;s:16:\"Ciencia ficción\";}','106 minutos'),
(4,'Free Guy','Guy (Ryan Reynolds) trabaja como cajero de un banco, y es un tipo alegre y solitario al que nada la amarga el día. Incluso si le utilizan como rehén durante un atraco a su banco, él sigue sonriendo como si nada. Pero un día se da cuenta de que Free City no es exactamente la ciudad que él creía. Guy va a descubrir que en realidad es un personaje no jugable dentro de un brutal videojuego.','movie-4.png','2021-08-13','a:2:{i:0;s:7:\"Comedia\";i:1;s:16:\"Ciencia ficción\";}','115 minutos'),
(5,'The Batman','Después de dos años acechando por las calles de la ciudad como Batman (Robert Pattinson), e infundiendo miedo en las mentes perversas de los criminales, Bruce Wayne está sumido en las profundidades de las sombras de Gotham City. Este vigilante solitario cuenta con pocos aliados de confianza y eso le ha llevado a convertirse en la única encarnación de la venganza entre sus conciudadanos. Cuando un asesino apunta a la élite de Gotham con una serie de maquinaciones sádicas, un rastro de pistas crípticas lleva a Batman a realizar una investigación en el inframundo.','movie-5.png','2022-04-18','a:4:{i:0;s:8:\"Suspense\";i:1;s:5:\"Drama\";i:2;s:12:\"Superhéroes\";i:3;s:6:\"Crimen\";}','176 minutos'),
(6,'Uncharted','Basada en una de las series de videojuegos más vendidas y aclamadas por la crítica de todos los tiempos, \"Uncharted\" presenta a un joven, astuto y carismático, Nathan Drake (Tom Holland) en su primera aventura como cazatesoros con su ingenioso compañero Victor “Sully” Sullivan (Mark Wahlberg). En una aventura de acción que se extiende por todo el mundo, ambos se embarcan en una peligrosa búsqueda de “el mayor tesoro nunca antes encontrado” al tiempo que rastrean las claves que les podrían conducir al hermano de Nathan, perdido hace ya mucho tiempo.','movie-6.png','2022-02-11','a:3:{i:0;s:7:\"Acción\";i:1;s:9:\"Aventuras\";i:2;s:9:\"Fantasía\";}','115 minutos'),
(7,'Muerte en el Nilo','Basada en la novela de Agatha Christie, publicada en 1937. \"Muerte en el Nilo\" es un thriller de misterio dirigido por Kenneth Branagh sobre el caos emocional y las consecuencias letales que provocan los amores obsesivos. Las vacaciones egipcias del detective belga Hércules Poirot, a bordo de un glamuroso barco de vapor, se ven alteradas por la búsqueda de un asesino cuando la idílica luna de miel de una pareja perfecta se ve truncada de la forma más trágica. ','movie-7.png','2022-02-18','a:3:{i:0;s:5:\"Drama\";i:1;s:6:\"Crimen\";i:2;s:8:\"Misterio\";}','127 minutos'),
(8,'The King\"s Man: La primera misión','Cuando un grupo formado por los tiranos y las mentes criminales más malvadas de la historia se une para desencadenar una guerra que matará a millones de personas, un hombre tendrá que luchar a contrarreloj para detenerlos. Tercera entrega de la saga \"Kingsman\", ambientada muchos años antes de las anteriores y explicando el origen de la agencia.','movie-8.png','2021-12-29','a:4:{i:0;s:8:\"Suspense\";i:1;s:7:\"Acción\";i:2;s:7:\"Comedia\";i:3;s:9:\"Espionaje\";}','131 minutos'),
(9,'Doctor Strange en el Multiverso de la Locura','Viaja a lo desconocido con el Doctor Strange, quien, con la ayuda de tanto antiguos como nuevos aliados místicos, recorre las complejas y peligrosas realidades alternativas del multiverso para enfrentarse a un nuevo y misterioso adversario.','movie-9.png','2022-05-06','a:3:{i:0;s:7:\"Acción\";i:1;s:6:\"Terror\";i:2;s:9:\"Fantasía\";}','126 minutos'),
(10,'Spider-Man: No Way Home','Por primera vez en la historia cinematográfica de Spider-Man, nuestro héroe, vecino y amigo es desenmascarado, y por tanto, ya no es capaz de separar su vida normal de los enormes riesgos que conlleva ser un superhéroe. Cuando pide ayuda al Doctor Strange, los riesgos pasan a ser aún más peligrosos, obligándole a descubrir lo que realmente significa ser él. Secuela de \"Spider-Man: Far From Home\".','movie-10.png','2021-12-16','a:4:{i:0;s:7:\"Acción\";i:1;s:9:\"Aventuras\";i:2;s:16:\"Ciencia ficción\";i:3;s:12:\"Superhéroes\";}','148 minutos');
/*!40000 ALTER TABLE `tmovie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tuser`
--

DROP TABLE IF EXISTS `tuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `encrypted_password` varchar(100) NOT NULL,
  `roles` varchar(50) NOT NULL,
  `profile_image` varchar(200) DEFAULT NULL,
  `registration_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tuser`
--

LOCK TABLES `tuser` WRITE;
/*!40000 ALTER TABLE `tuser` DISABLE KEYS */;
INSERT INTO `tuser` VALUES (1,'cristiancp','abc@gmail.com','$2y$10$xIlhl.V4genjeZG3OJywbOunu1JQ72joDohPTo8UEN.j53Fu.jw6W','','a9b02ec1cf7caa65b1577c906d23589e.jpg');
/*!40000 ALTER TABLE `tuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twatchlist`
--

DROP TABLE IF EXISTS `twatchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twatchlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `twatchlist_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `tmovie` (`id`),
  CONSTRAINT `twatchlist_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `tuser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twatchlist`
--

LOCK TABLES `twatchlist` WRITE;
/*!40000 ALTER TABLE `twatchlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `twatchlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-29  3:19:46
