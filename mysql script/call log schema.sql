CREATE DATABASE  IF NOT EXISTS `kgjsm` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `kgjsm`;
-- MySQL dump 10.13  Distrib 5.1.40, for Win32 (ia32)
--
-- Host: 127.0.0.1    Database: kgjsm
-- ------------------------------------------------------
-- Server version	5.1.49-community

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `call_type_tb`
--

DROP TABLE IF EXISTS `call_type_tb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `call_type_tb` (
  `call_type_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `pre_code` char(2) DEFAULT NULL,
  `call_desc` char(3) DEFAULT NULL,
  `call_per_minute` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`call_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `call_type_tb`
--

LOCK TABLES `call_type_tb` WRITE;
/*!40000 ALTER TABLE `call_type_tb` DISABLE KEYS */;
INSERT INTO `call_type_tb` VALUES (1,'09','GSM','11.16'),(2,'0','NDD','4.47'),(3,'00','IDD','13.00');
/*!40000 ALTER TABLE `call_type_tb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `call_log_tb`
--

DROP TABLE IF EXISTS `call_log_tb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `call_log_tb` (
  `call_log_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `call_date` date DEFAULT NULL,
  `call_finish` time DEFAULT NULL,
  `call_duration` time DEFAULT NULL,
  `total_call_cost` decimal(8,2) DEFAULT NULL,
  `tele_number_id` int(11) DEFAULT NULL,
  `user_info_id` smallint(6) DEFAULT NULL,
  `bill_number` smallint(3) unsigned DEFAULT NULL,
  `call_purpose` char(2) DEFAULT 'OB',
  `remarks` varchar(25) DEFAULT NULL,
  `audit_ack` char(1) DEFAULT 'N',
  `user_ack` char(1) DEFAULT 'N',
  `show_log` char(1) DEFAULT 'N',
  PRIMARY KEY (`call_log_id`),
  KEY `tele_number_id` (`tele_number_id`),
  KEY `user_info_id` (`user_info_id`),
  CONSTRAINT `call_log_tb_ibfk_1` FOREIGN KEY (`tele_number_id`) REFERENCES `tele_number_tb` (`tele_number_id`),
  CONSTRAINT `call_log_tb_ibfk_2` FOREIGN KEY (`user_info_id`) REFERENCES `user_info_tb` (`user_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `call_log_tb`
--

LOCK TABLES `call_log_tb` WRITE;
/*!40000 ALTER TABLE `call_log_tb` DISABLE KEYS */;
/*!40000 ALTER TABLE `call_log_tb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_tb`
--

DROP TABLE IF EXISTS `location_tb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location_tb` (
  `location_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `location_code` char(5) DEFAULT NULL,
  `location_desc` varchar(20) DEFAULT NULL,
  `call_type_id` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`location_id`),
  KEY `call_type_id` (`call_type_id`),
  CONSTRAINT `location_tb_ibfk_4` FOREIGN KEY (`call_type_id`) REFERENCES `call_type_tb` (`call_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_tb`
--

LOCK TABLES `location_tb` WRITE;
/*!40000 ALTER TABLE `location_tb` DISABLE KEYS */;
INSERT INTO `location_tb` VALUES (1,'907','TalknTxt',1),(2,'908','TalknTxt',1),(3,'909','TalknTxt',1),(4,'910','TalknTxt',1),(5,'912','Smart',1),(6,'918','Smart',1),(7,'919','Smart',1),(8,'920','Smart',1),(9,'921','Smart',1),(10,'928','Smart',1),(11,'929','TalknTxt',1),(12,'905','TouchMob',1),(13,'906','TouchMob',1),(14,'915','Globe',1),(15,'916','TouchMob',1),(16,'917','Globe',1),(17,'926','TouchMob',1),(18,'927','Globe',1),(19,'922','Sun',1),(20,'923','Sun',1),(21,'979','NextTel',1),(22,'938','RedMob',1),(23,'32','Cebu',2),(24,'33','Iloilo',2),(25,'34','NegrosOcc',2),(26,'35','NegrosOri',2),(27,'36','Capiz',2),(28,'38','Bohol',2),(29,'42','LcbQuezn',2),(30,'43','Batangas',2),(31,'45','Pampanga',2),(32,'47','Zambales',2),(33,'48','Palawan',2),(34,'49','Laguna',2),(35,'52','Albay',2),(36,'53','Leyte',2),(37,'54','Camarines',2),(38,'55','NorSamar',2),(39,'56','Masbate',2),(40,'62','ZamboangadSur',2),(41,'63','LanaodNor',2),(42,'64','Iligan',2),(43,'65','ZamboangadNor',2),(44,'72','LaUnion',2),(45,'74','Abra',2),(46,'75','Pangasinan',2),(47,'77','Ilocos',2),(48,'78','Quirino',2),(49,'83','SouCotobato',2),(50,'84','DavaodNor',2),(51,'85','Agusan',2),(52,'86','Surigao',2),(53,'87','DavaoOri',2),(54,'88','Misamis',2),(55,'44','MeyBlcan',2),(56,'46','Cavite',2),(57,'82','DavaodSur',2),(58,'32','Belgium',3),(59,'1','Canada',3),(60,'45','Denmark',3),(61,'852','HongKong',3),(62,'91','India',3),(63,'62','Indonesia',3),(64,'81','Japan',3),(65,'60','Malaysia',3),(66,'31','Netherlands',3),(67,'234','Nigeria',3),(68,'47','Norway',3),(69,'974','Qatar',3),(70,'65','Singapore',3),(71,'971','UAE',3),(72,'967','Yemen',3),(73,'88','Taiwan',3),(74,'61','Australia',3),(75,'70','Australia',3),(76,'212','Morocco',3),(77,'871','InMarSatAtla',3),(78,'872','InMarSatPaci',3),(79,'873','InMarSatIndia',3),(80,'874','InMarSatAtlaWe',3),(81,'44','U.K.',3),(82,'52','Mexico',3),(83,'49','Germany',3),(84,'86','China',3),(85,'509','Haiti',3),(86,'599','N.Antilles',3),(87,'94','Sri-Lanka',3),(88,'82','S.Korea',3),(89,'20','Egypt',3),(90,'95','Burma',3),(91,'57','Colombia',3),(92,'55','Brazil',3),(93,'58','Venezuela',3),(94,'385','Croatia',3),(95,'351','Portugal',3),(96,'33','France',3),(97,'56','Chile',3),(98,'39','Italy',3),(99,'90','Turkey',3),(100,'43','Austria',3),(101,'46','Sweden',3),(102,'53','Cuba',3),(103,'230','Mauritus',3),(104,'353','Ireland',3),(105,'249','Sudan',3),(106,'680','Palau Republic',3),(107,'968','Oman',3),(108,'66','Thailand',3),(109,'244','Angola',3),(110,'932','Sun',1),(111,'960','Maldives',3),(112,'27','South Africa',3),(113,'213','Algeria',3),(114,'34','Spain',3),(115,'84','Vietnam',3),(116,'92','Pakistan',3),(117,'939','Smart',1),(118,'350','Gibraltar',3),(119,'7','Russia',3),(120,'963','Syria',3),(121,'502','Guatemala',3),(122,'935','Globe',1),(123,'229','Benin',3),(124,'930','Smart',1),(125,'242','Congo',3),(126,'936','Globe',1),(127,'870','Inmarsat',3),(128,'973','Bahrain',3),(129,'356','Malta',3),(130,'2','NCR',2),(131,'999','Smart',1),(132,'218','Libya',3),(133,'933','Sun',1),(134,'598','Uruguay',3),(135,'114','Service',2);
/*!40000 ALTER TABLE `location_tb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tele_number_tb`
--

DROP TABLE IF EXISTS `tele_number_tb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tele_number_tb` (
  `tele_number_id` int(11) NOT NULL AUTO_INCREMENT,
  `tele_number` varchar(20) DEFAULT NULL,
  `location_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`tele_number_id`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `tele_number_tb_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `location_tb` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tele_number_tb`
--

LOCK TABLES `tele_number_tb` WRITE;
/*!40000 ALTER TABLE `tele_number_tb` DISABLE KEYS */;
/*!40000 ALTER TABLE `tele_number_tb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info_tb`
--

DROP TABLE IF EXISTS `user_info_tb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_info_tb` (
  `user_info_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `local_number` varchar(30) DEFAULT NULL,
  `user_initial` char(3) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `middle_name` varchar(20) DEFAULT NULL,
  `admin` char(1) NOT NULL DEFAULT 'N',
  `pass_word` varchar(10) DEFAULT NULL,
  `company_id` tinyint(1) DEFAULT '1',
  `user_exec` char(1) DEFAULT 'N',
  PRIMARY KEY (`user_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info_tb`
--

LOCK TABLES `user_info_tb` WRITE;
/*!40000 ALTER TABLE `user_info_tb` DISABLE KEYS */;
INSERT INTO `user_info_tb` VALUES (1,'200','DDE','Deb','Dipankar',NULL,'N',NULL,2,'N'),(2,'201','ADC','Cutab','Marie Anne','D','N',NULL,2,'N'),(3,'202','DRD','Dayusan','Maria Dalisay','R','N',NULL,2,'N'),(4,'203','RTR','Reforzado','Rowena','T','N',NULL,2,'N'),(5,'208','ZAD','Aguirre ','Zandrea','Solis','N',NULL,1,'N'),(6,'209','SPN','Paguirigan','Sofronio','M','N',NULL,2,'N'),(7,'210','LMB','Banal','Luisa','M','N',NULL,2,'N'),(8,'211','KCS','Santos','Kathryn','C','N',NULL,2,'N'),(9,'212','ANA','Sueyoshi','Analiza','V','N',NULL,2,'N'),(10,'213','ZAS','Santos','Zenaida','A','N',NULL,2,'N'),(11,'214','BBB','Bullalayao','Brian','B','N',NULL,1,'N'),(12,'215','GON','Gon gon','Jonathan','T','N',NULL,2,'N'),(13,'300','AKT','Torino','Anna Kristina','O','N',NULL,1,'N'),(14,'305','CTD','Daileg','Ma Claudine','T','N',NULL,1,'N'),(15,'307','RPP','Palmero','Ruby','P','N',NULL,1,'N'),(16,'308','MDV','Villapando','Medester','Dinglasan','N',NULL,1,'N'),(17,'331','MOG','Otadoy','Marito','G','N',NULL,2,'N'),(18,'332','FSA','Alegre','Freddie','S','N',NULL,2,'N'),(19,'333','ETV','Varela','Elmer','T','N',NULL,2,'N'),(20,'334','EDD','Grafane','Eddie','A','N',NULL,2,'N'),(21,'335','MJN','Johnsen','Morten','Soloe','N',NULL,1,'Y'),(22,'336','GMG','Macapayag','Guy Domino','Agres','N',NULL,1,'Y'),(23,'337','MTC','Castellon','Malvar','Tabuso','N',NULL,1,'Y'),(24,'338','ASR','Rafal','Alexander','Serrano','N',NULL,1,'Y'),(25,'339','MES','Siton','Melchor','Ensalada','N',NULL,1,'Y'),(26,'340','JVL','Ledesma','Juliet','Villarma','N',NULL,1,'N'),(27,'341','MCA','Cuaresma','Marianne','Balbuena','N',NULL,1,'N'),(28,'342','ARB','Boseta','Arnold','C','N',NULL,1,'Y'),(29,'343','HOC','Francisco','Honeylet','Cristobal','N','12345',1,'N'),(30,'344','ALM','Mantes','Ana Liza','Llagas','N',NULL,1,'N'),(31,'345','MEM','Miguel','Marifel','E','N',NULL,1,'N'),(32,'346','HEN','Navato','Hideliza','Enriquez','N',NULL,1,'N'),(33,'347','MNP','Pergis','Maria Nina','Valdemor','N',NULL,1,'N'),(34,'348','RME','Mendoza','Rosy','Lazaro','N',NULL,1,'N'),(35,'349','WTA','Villamor','Wilen','Anque','N',NULL,1,'N'),(36,'350','GGG','Gracilla','Glenda','Guray','N',NULL,1,'N'),(37,'351','WRO','Belarma','Rowena','Octavo','N',NULL,1,'N'),(38,'352','JEG','Gumban','Joey','Espino','N',NULL,1,'N'),(39,'353','MTR','Roque','Maricel','Tandoc','N',NULL,1,'N'),(40,'354','RRB','Borja','Reymon','Reyes','N',NULL,1,'N'),(41,'355','MJP','Pelobello','Mark John Bonn','Batara','N',NULL,1,'N'),(42,'356','JMF','Fabro','Janice','Meriel','N',NULL,1,'N'),(43,'357','MMZ','Martinez','Mildred','Defensor','N',NULL,1,'N'),(44,'358','PTB','Timbang','Phoeba Ann',NULL,'N',NULL,1,'N'),(45,'359','JCE','Eriguel','Jocelyn','Conception','N',NULL,1,'N'),(46,'360','MFS','Solano','Flora May','Abad','N',NULL,1,'N'),(47,'361','SMP','Paungan','Shiela Marie','Cuya','N',NULL,1,'N'),(48,'362','VSS','Sinisero','Villy','Sancho','N',NULL,1,'N'),(49,'363','MJD','De Los Santos','Mary Jane',NULL,'N',NULL,1,'N'),(50,'364','JPD','Dacuyasan','Joveluz','Pabrualinan','N',NULL,1,'N'),(51,'365','KLA','Asuncion','Kristine Eve','L','N',NULL,1,'N'),(52,'366','RNR','Roque','Rose Nadyn','Gaspar','N',NULL,1,'N'),(53,'367','CLG','Garlejo','Clifford',' Haducana','N',NULL,1,'Y'),(54,'368','CSV','Valdez','Cyrell Soriano',' Soriano','N',NULL,1,'N'),(55,'369','MMO','Manzon','Melmar','Parayoan','N',NULL,1,'N'),(56,'370','FPS','Sarmiento','Federico','Paras','Y','12345',1,'N'),(57,'371','JMU','Muertegui','Joy','Danieles','N',NULL,1,'N'),(58,'372','MCG','Garduque','Maureen','Cutay','N',NULL,1,'N'),(59,'373','MTR','Roque','Maricel','Tandoc','N',NULL,1,'N'),(60,'374','MCU','Pabuaya','Maria Corazon','Umeres','N',NULL,1,'N'),(61,'375','375','Reserved',NULL,NULL,'N',NULL,1,'N'),(62,'376','ALD','Duquiatan','Alfred','Seblario','N',NULL,1,'N'),(63,'377','RFS','Sikat','Rico','Fernando','N',NULL,1,'N'),(64,'378','PNJ','Jardio','Paul','N','N',NULL,1,'N'),(65,'379','DRM','Morada','Dranreb','Obel','N',NULL,1,'N'),(66,'380','MDB','Belencion','Ma. Victoria','Doroja','N',NULL,1,'N'),(67,'381','EMD','Doctor','Efren','M.','N',NULL,1,'Y'),(68,'382','RCO','Oleo Jr','Ricardo','Canape','N',NULL,1,'N'),(69,'383','KCR','Magano','Katleah','Reina','N',NULL,1,'N'),(70,'384','HNN','Nvarro','Helen','Liscano','N',NULL,1,'Y'),(71,'385','JYU','Umandap','Jay','Reyes','N',NULL,1,'N'),(72,'386','SNC','Culaste','Stephen','Manuel','N',NULL,1,'N'),(73,'387','MTA','Amparado','Hilda','Tolentino','N',NULL,1,'N'),(74,'388','388','Reserve',NULL,NULL,'N',NULL,1,'N'),(75,'389','ROF','Francisco','Rugerro','Odrial','N',NULL,1,'N'),(76,'390','390','Door Man',NULL,NULL,'N',NULL,1,'N'),(77,'391','391','Reserved',NULL,NULL,'N',NULL,1,'N'),(78,'392','ECP','Pojol','Earl Cary','Co','N',NULL,1,'N'),(79,'393','393','CnRm 6',NULL,NULL,'N',NULL,1,'Y'),(80,'394','JJL','Layug','Joseph James','Balubar','N',NULL,1,'N'),(81,'476','RSS','Sanidad','Reginald','Sanares','N',NULL,1,'N'),(82,'478','FPA','Pante','Fernando','Villanueva','N',NULL,1,'N'),(83,'477','ITR','IT Room',NULL,NULL,'N',NULL,1,'N'),(84,'479','LSL','Lamparero','Lennie','S','N',NULL,1,'N'),(85,'483','FLA','Olvina','Floremiel','A.','A','12345',1,'N');
/*!40000 ALTER TABLE `user_info_tb` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-08-15 21:03:52
