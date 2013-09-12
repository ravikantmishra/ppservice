-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: passportservices
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

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
-- Current Database: `passportservices`
--

/*!40000 DROP DATABASE IF EXISTS `passportservices`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `passportservices` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `passportservices`;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application` (
  `id` smallint(9) NOT NULL AUTO_INCREMENT,
  `type` enum('Passport','Visa') DEFAULT NULL,
  `title` enum('MR','MRS','MISS','DR') DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `date_of_birth` date NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `town` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `phone_number` varchar(14) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `application_type` enum('passport','visa') NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `status` enum('paid','unpaid') NOT NULL DEFAULT 'unpaid',
  `passport_number` varchar(15) DEFAULT NULL,
  `order_number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `application_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
INSERT INTO `application` VALUES (1,'Passport','MR','aa','','male','0000-00-00','aa','','aa@asmail.com','','aa',1,NULL,NULL,'passport',NULL,'unpaid',NULL,NULL),(2,'Passport','MR','aa','','male','0000-00-00','aa','','aa@asmail.com','','aa',1,NULL,NULL,'passport',NULL,'unpaid',NULL,NULL),(3,'Visa','MR','qq','qq','male','0000-00-00','qq','qq','qq@qq.com','','qq',1,NULL,NULL,'passport',NULL,'unpaid','qq',NULL);
/*!40000 ALTER TABLE `application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_number` char(11) DEFAULT NULL,
  `comment` text,
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'inactive' COMMENT 'to check seen by admin or not',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,'abc','abc@abc.com','9999999','abcd test','inactive'),(2,'abc','abc@abc.com','9999999','abcd test','inactive'),(3,'abc','abc@abc.com','9999999','','inactive'),(4,'uoi','abc@abc.com','9999','sdsdfsdf','inactive'),(5,'uoi','abc@abc.com','9999','sdsdfsdf','inactive'),(6,'uoi','abc@abc.com','9999','sdsdfsdf','inactive'),(7,'sdfsda','fsadfsd','sdfsdfsdf','sdfsdfsd','inactive'),(8,'abc','weawe@c.ccom','9999999','werewrwedasdasdasd','inactive'),(9,'abc','weawe@c.ccom','9999999','werewrwedasdasdasd','inactive'),(10,'abc','weawe@c.ccom','9999999','werewrwedasdasdasd','inactive'),(11,'abc','weawe@c.ccom','9999999','werewrwedasdasdasd','inactive'),(12,'abc','weawe@c.ccom','9999999','werewrwedasdasdasd','inactive'),(13,'abc','weawe@c.ccom','9999999','werewrwedasdasdasd','inactive'),(14,'abc','weawe@c.ccom','9999999','werewrwedasdasdasd','inactive'),(15,'fsdf','userdemo888@gmail.com','9999999','dsafsadfsd asdffa  dfsafds ','inactive'),(16,'fsdf','userdemo888@gmail.com','9999999','dsafsadfsd asdffa  dfsafds ','inactive'),(17,'test','test','test','test','inactive'),(18,'test','test@gmail.com','1234567','testing','inactive'),(19,'test','test@gmail.com','1234567','testing','inactive'),(20,'dasd','asdsa@a.com','dsadas','sadaddsadasd','inactive'),(21,'dasd','asdsa@a.com','11111','sadaddsadasd','inactive'),(22,'dasd','asdsa@a.com','11111','sadaddsadasd','inactive'),(23,'dasd','asdsa@a.com','asdas','sadaddsadasd','inactive'),(24,'dasd','asdsa@a.com','asdas','sadaddsadasd','inactive'),(25,'dasd','asdsa@a.com','11111111','sadaddsadasd','inactive'),(26,'dasd','asdsa@a.com','111111','sadaddsadasd','inactive'),(27,'dasd','asdsa@a.com','11111111111','sadaddsadasd','inactive'),(28,'dasd','asdsa@a.com','111111111','sadaddsadasd','inactive'),(29,'dasd','asdsa@a.com','111111111','sadaddsadasd','inactive'),(30,'dasd','asdsa@a.com','11111111111','sadaddsadasd','inactive'),(31,'dasd','asdsa@a.com','1111111111','sadaddsadasd','inactive'),(32,'dasd','asdsa@a.com','9911608832','sadaddsadasd','inactive'),(33,'dasd','asdsa@a.com','991160883','sadaddsadasd','inactive'),(34,'dasd','asdsa@a.com','991160883','sadaddsadasd','inactive'),(35,'dasd','asdsa@a.com','9911608832','sadaddsadasd','inactive'),(36,'dasd','asdsa@a.com','99116088322','sadaddsadasd','inactive'),(37,'dasd','asdsa@a.com','99116088322','sadaddsadasd','inactive'),(38,'dasd','asdsa@a.com','99116088322','sadaddsadasd','inactive'),(39,'alert(\"hello\");','asdsa@a.com','99116088322','sadaddsadasd','inactive'),(40,'test','test@test.com','1111111111','abcdefgh','inactive'),(41,'fsdf','aaaaa@a.com','99999999999','fdsafsdafasdfsd','inactive'),(42,'testy','asadf@g.com','9999999999','sdfsdfs','inactive'),(43,'test','test@g.com','9999999999','abcd\r\neweqwae','inactive'),(44,'test','test@t.com','9999999999','testss','inactive'),(45,'abc def','kldfsdl@t.com','9999999999','tests','inactive'),(46,'abcd abc','aweaea@z.com','9999999999','aweaweaw','inactive'),(47,'contact','contact@contact.com','9999999999','contact enqiry','inactive'),(48,'xyz stu','abc@def.com','9911608832','scrpitalert(&quot;hello&quot;);','inactive'),(49,'flashtest','flash@flkach.com','9999999999','flshtest','inactive'),(50,'dsfsdf','abc@def.com','9999999999','aaaa999','inactive'),(51,'dsfsdf','abc@def.com','99999999999','aaaa999','inactive'),(52,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(53,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(54,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(55,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(56,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(57,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(58,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(59,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(60,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(61,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(62,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(63,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(64,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(65,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(66,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(67,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(68,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(69,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(70,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(71,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(72,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(73,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(74,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(75,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(76,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(77,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(78,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(79,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(80,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(81,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(82,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(83,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(84,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(85,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(86,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(87,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(88,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(89,'erytr','aaa@a.com','99999999999','rewwrerewr','inactive'),(90,'sadfa','aaa@a.com','1234567890','enfhsdkfjs','inactive'),(91,'sadfa','aaa@a.com','1234567890','enfhsdkfjs','inactive'),(92,'raj','raj@oss.com','9811991190','testing the application','inactive'),(93,'raj','raj@oss.com','9811991190','testing the application','inactive'),(94,'test','test@teat.com','9911991199','enqire something','inactive'),(95,'test','test@teat.com','9911991199','enqire something','inactive'),(96,'test','user@gmail.com','9899998899','testing','inactive'),(97,'test','user@gmail.com','9899998899','testing','inactive'),(98,'test','user@gmail.com','9899998899','testing','inactive'),(99,'test','user@gmail.com','9899998899','testing','inactive'),(100,'userdemo','user@gmail.com','9899889999','testing user','inactive'),(101,'testuser','user@gmail.com','09911608832','testing user','inactive'),(102,'testuser','user@gmail.com','09911608832','testing user','inactive'),(103,'cdszv','aaa@a.com','9999116099','sdfsdfsdfsfs','inactive'),(104,'sdkljhdskj','aaa@a.com','9999116099','eygsdryhgcfhf','inactive'),(105,'testuser','testruser123@gmail.com','9911991199','test the user','inactive'),(106,'testuser','testruser123@gmail.com','9911991199','test the user','inactive'),(107,'contact us','contacAdmin@admin.com','9999999999','dsfkljsafksldg','inactive'),(108,'contact us','contacAdmin@admin.com','9999999999','dsfkljsafksldg','inactive'),(109,'contact us','contacAdmin@admin.com','9999999999','dsfkljsafksldg','inactive'),(110,'fsdf','aaa@a.com','9911991199','fddsafdsfsf','inactive'),(111,'fsdf','aaa@a.com','09911608832','fddsafdsfsf','inactive'),(112,'test','test@teat.com','9911991199','fbdsflkjsdfd','inactive'),(113,'test','test@teat.com','1234567890','fbdsflkjsdfd','inactive'),(114,'test','aaa@a.com','09911608832','dasdas','inactive'),(115,'test','aaa@a.com','09911608832','dasdas','inactive'),(116,'test','aaa@a.com','1234567890','asdfsdsdfdsfs','inactive'),(117,'test','aaa@a.com','1234567890','asdfsdsdfdsfs','inactive'),(118,'test','aaa@a.com','1234567890','asdfsdsdfdsfs','inactive'),(119,'test','aaa@a.com','1234567890','asdfsdsdfdsfs','inactive'),(120,'mohit','mohit@gmail.com','9999999999','jdkfksldajfd','inactive'),(121,'mohit','mohit@gmail.com','9999999999','jdkfksldajfd','inactive'),(122,'mohit','mohit@gmail.com','9999999999','jdkfksldajfd','inactive'),(123,'mohit','mohit@gmail.com','9999999999','jdkfksldajfd','inactive'),(124,'test','test@test.com','9999999999','nmdfksflsjkfkls','inactive'),(125,'test','test@test.com','9999999999','nmdfksflsjkfkls','inactive'),(126,'test','test@test.com','9999999999','nmdfksflsjkfkls','inactive'),(127,'test','test@test.com','9999999999','nmdfksflsjkfkls','inactive'),(128,'dfgjdslgk','aaa@a.com','9911991199','lkfdsklgsd','inactive'),(129,'dfsdfdsaf','aaa@a.com','9999999999','ertwew','inactive'),(130,'dfsdfdsaf','aaa@a.com','9999999999','ertwew','inactive'),(131,'dsfsdf','aaa@a.com','1234567890',',mnf.xd;kvbd;cnbklcx','inactive');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'Afghanistan'),(2,'Andorra'),(3,'Albania'),(4,'Algeria'),(5,'Andorra'),(6,'Angola'),(7,'Antigua and Barbuda'),(8,'Argentina'),(9,'Armenia'),(10,'Australia'),(11,'Austria'),(12,'Azerbaijan'),(13,'Bahamas'),(14,'Bahrain'),(15,'Bangladesh'),(16,'Barbados'),(17,'Belarus'),(18,'Belgium'),(19,'Belize'),(20,'Benin'),(21,'Bhutan'),(22,'Bolivia'),(23,'Bosnia and Herzegovina'),(24,'Botswana'),(25,'Brazil'),(26,'Brunei'),(27,'Bulgaria'),(28,'Burkina Faso'),(29,'Burundi'),(30,'Cabo Verde'),(31,'Cambodia'),(32,'Cameroon'),(33,'Canada'),(34,'Central African Republic'),(35,'Chad'),(36,'Chile'),(37,'China'),(38,'Colombia'),(39,'Comoros'),(40,'Congo'),(41,'Costa Rica'),(42,'Croatia'),(43,'Cuba'),(44,'Cyprus'),(45,'Czech Republic'),(46,'Democratic Republic of the Congo'),(47,'Denmark'),(48,'Djibouti'),(49,'Dominica'),(50,'Dominican Republic'),(51,'Ecuador'),(52,'Egypt'),(53,'El Salvador'),(54,'Equatorial Guinea'),(55,'Eritrea'),(56,'Estonia'),(57,'Ethiopia'),(58,'Fiji'),(59,'Finland'),(60,'France'),(61,'Gabon'),(62,'Gambia'),(63,'Georgia'),(64,'Germany'),(65,'Ghana'),(66,'Greece'),(67,'Grenada'),(68,'Guatemala'),(69,'Guinea'),(70,'Guinea-Bissau'),(71,'Guyana'),(72,'Haiti'),(73,'Honduras'),(74,'Hungary'),(75,'Iceland'),(76,'India'),(77,'Indonesia'),(78,'Iran'),(79,'Iraq'),(80,'Ireland'),(81,'Israel'),(82,'Italy'),(83,'Jamaica'),(84,'Japan'),(85,'Jordan'),(86,'Kazakhstan'),(87,'Kenya'),(88,'Kiribati'),(89,'Kuwait'),(90,'Kyrgyzstan'),(91,'Laos'),(92,'Latvia'),(93,'Lebanon'),(94,'Lesotho'),(95,'Liberia'),(96,'Libya'),(97,'Liechtenstein'),(98,'Lithuania'),(99,'Luxembourg'),(100,'Macedonia'),(101,'Madagascar'),(102,'Malawi'),(103,'Malaysia'),(104,'Maldives'),(105,'Mali'),(106,'Malta'),(107,'Marshall Islands'),(108,'Mauritania'),(109,'Mauritius'),(110,'Mexico'),(111,'Micronesia'),(112,'Moldova'),(113,'Monaco'),(114,'Mongolia'),(115,'Morocco'),(116,'Mozambique'),(117,'Myanmar'),(118,'Namibia'),(119,'Nauru'),(120,'Nepal'),(121,'Netherlands'),(122,'New Zealand'),(123,'Nicaragua'),(124,'Niger'),(125,'Nigeria'),(126,'North Korea'),(127,'Norway'),(128,'Oman'),(129,'Pakistan'),(130,'Palau'),(131,'Panama'),(132,'Papua New Guinea'),(133,'Paraguay'),(134,'Peru'),(135,'Philippines'),(136,'Poland'),(137,'Portugal'),(138,'Qatar'),(139,'Romania'),(140,'Russia'),(141,'Rwanda'),(142,'Saint Kitts and Nevis'),(143,'Saint Lucia'),(144,'Saint Vincent and the Grenadines'),(145,'Samoa'),(146,'San Marino'),(147,'Sao Tome and Principe'),(148,'Saudi Arabia'),(149,'Senegal'),(150,'Serbia'),(151,'Seychelles'),(152,'Sierra Leone'),(153,'Singapore'),(154,'Slovakia'),(155,'Slovenia'),(156,'Solomon Islands'),(157,'Somalia'),(158,'South Africa'),(159,'South Korea'),(160,'Spain'),(161,'Sri Lanka'),(162,'Sudan'),(163,'Suriname'),(164,'Swaziland'),(165,'Sweden'),(166,'Switzerland'),(167,'Syria'),(168,'Taiwan'),(169,'Tajikistan'),(170,'Tanzania'),(171,'Thailand'),(172,'Timor-Leste'),(173,'Togolese'),(174,'Tonga'),(175,'Trinidad and Tobago'),(176,'Tunisia'),(177,'Turkey'),(178,'Turkmenistan'),(179,'Tuvalu'),(180,'Uganda'),(181,'Ukraine'),(182,'United Arab Emirates'),(183,'United Kingdom'),(184,'United States'),(185,'Uruguay'),(186,'Uzbekistan'),(187,'Vanuatu'),(188,'Vatican'),(189,'Venezuela'),(190,'Vietnam'),(191,'Western Sahara'),(192,'Yemen'),(193,'Zambia'),(194,'Zimbabwe');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `comment` text,
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'inactive' COMMENT 'to check seen by admin or not',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
INSERT INTO `feedback` VALUES (1,'','','','','inactive'),(2,'test','test@t.com','99999999999','dsfsdfsaffd','inactive'),(3,'testing','testing@test.com','9999999999','testing check','inactive'),(4,'abc','abc@gmail.com','9911608832','hello testing app.','inactive'),(5,'tester','test@test.com','9999999999','hjfdgksjgfsdlg','inactive'),(6,'fdsfa','aaa@a.com','99999999999','gsdfa','inactive'),(7,'fdsfa','aaa@a.com','99999999999','gsdfagui','inactive'),(8,'sdgfsd','aaa@a.com','09911608832','sdgfdsgfds','inactive'),(9,'sdgfsd','aaa@a.com','09911608832','sdgfdsgfds','inactive'),(10,'fsdfsd','aaa@a.com','9999999999','fsdgsdgfdgdfg','inactive'),(11,'fsdfsd','aaa@a.com','9999999999','fsdgsdgfdgdfg','inactive'),(12,'fsdfsd','aaa@a.com','9999999999','fsdgsdgfdgdfg','inactive'),(13,'fsdfsd','aaa@a.com','9999999999','fsdgsdgfdgdfg','inactive'),(14,'fsdfsd','aaa@a.com','9999999999','fsdgsdgfdgdfg','inactive'),(15,'fsdfsd','aaa@a.com','9999999999','fsdgsdgfdgdfg','inactive'),(16,'fsdfsd','aaa@a.com','9999999999','fsdgsdgfdgdfg','inactive'),(17,'flash','flash@flash.com','9999999999','jdfkgkfdsgkdfslkdg','inactive'),(18,'test2','test2@test.com','9999999999','test2working','inactive'),(19,'abcdq','abcd@ww.com','9899998811','test fro enquiry','inactive');
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `template`
--

DROP TABLE IF EXISTS `template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(50) NOT NULL,
  `template_data` longtext,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `template`
--

LOCK TABLES `template` WRITE;
/*!40000 ALTER TABLE `template` DISABLE KEYS */;
INSERT INTO `template` VALUES (1,'signup','Thank you <strong>{username}</strong> for signing up with email <strong>{email}</strong>\n \nThe Admin','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'forget Password','Hi <strong>{username}</strong> your password is succesfully sended to your email <strong>{email}</strong>\n \nThe Admin','2013-09-10 03:22:13','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active' COMMENT 'to check user is deleted or not',
  `link` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'aa','4124bc0a9335c27f086f24ba207a4912','aa@asmail.com','aa','aa','active',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-11 17:42:10
