-- MySQL dump 10.13  Distrib 5.7.11, for osx10.10 (x86_64)
--
-- Host: localhost    Database: offshore
-- ------------------------------------------------------
-- Server version	5.7.11

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'All Categories','all_category',NULL,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(2,'Vessels','vessels',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(3,'Inventory','inventory',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(4,'Trucks','trucks',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(5,'Helicopters','helicopters',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(6,'Spare Labour Resources','spare_labour_resources',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(7,'Consultancy / Recruitment','consultancy_recruitment',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(8,'Shore Base','shore_base',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(9,'Pipe Yard','pipe_yard',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(10,'Heavy Equipment','heavy_equipment',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(11,'Office Space','office_space',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(12,'Infrastructure Optimisation','infrastructure_optimisation',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(13,'Rig Optimization','rig_optimization',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(14,'PSVs','psvs',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(15,'Crew / Personnel','crew_personnel',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(16,'Anchor Handler','anchor_handler',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(17,'Tug','tug',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(18,'Diving & ROV','diving_&_row',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(19,'Pipe Laying','pipe_laying',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(20,'Heavy Lift','heavy_lift',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(21,'Cable Laying','cable_laying',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(22,'Barge','barge',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(23,'Casing/ Tubing','casing_tubing',3,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(24,'Rope, Soap & Dope','rope_soap_&_dope',3,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(25,'Cranes','cranes',10,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(26,'Fork Lifts','fork_lifts',10,'2016-06-06 21:08:37','2016-06-06 21:08:37');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Test Company','2016-06-06 21:08:37','2016-06-06 21:08:37');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `countries_region_id_foreign` (`region_id`),
  CONSTRAINT `countries_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Afghanistan',8),(2,'Albania',4),(3,'Algeria',5),(4,'American Samoa',9),(5,'Andorra',4),(6,'Angola',5),(7,'Anguilla',3),(8,'Antigua & Barbuda',3),(9,'Argentina',3),(10,'Armenia',8),(11,'Aruba',3),(12,'Australia',9),(13,'Austria',4),(14,'Azerbaijan',8),(15,'Bahamas, The',3),(16,'Bahrain',7),(17,'Bangladesh',8),(18,'Barbados',3),(19,'Belarus',8),(20,'Belgium',4),(21,'Belize',3),(22,'Benin',5),(23,'Bermuda',1),(24,'Bhutan',8),(25,'Bolivia',3),(26,'Bosnia & Herzegovina',4),(27,'Botswana',5),(28,'Brazil',3),(29,'British Virgin Is.',3),(30,'Brunei',8),(31,'Bulgaria',4),(32,'Burkina Faso',5),(33,'Burma',8),(34,'Burundi',5),(35,'Cambodia',8),(36,'Cameroon',5),(37,'Canada',1),(38,'Cape Verde',5),(39,'Cayman Islands',3),(40,'Central  Rep.',5),(41,'Chad',5),(42,'Chile',3),(43,'China',8),(44,'Colombia',3),(45,'Comoros',5),(46,'Congo, Dem. Rep.',5),(47,'Congo, Repub. of the',5),(48,'Cook Islands',9),(49,'Costa Rica',3),(50,'Cote d\'Ivoire',5),(51,'Croatia',4),(52,'Cuba',3),(53,'Cyprus',8),(54,'Czech Republic',4),(55,'Denmark',4),(56,'Djibouti',5),(57,'Dominica',3),(58,'Dominican Republic',3),(59,'East Timor',8),(60,'Ecuador',3),(61,'Egypt',7),(62,'El Salvador',3),(63,'Equatorial Guinea',5),(64,'Eritrea',5),(65,'Estonia',4),(66,'Ethiopia',5),(67,'Faroe Islands',4),(68,'Fiji',9),(69,'Finland',4),(70,'France',4),(71,'French Guiana',3),(72,'French Polynesia',9),(73,'Gabon',5),(74,'Gambia, The',5),(75,'Georgia',4),(76,'Germany',4),(77,'Ghana',5),(78,'Gibraltar',4),(79,'Greece',4),(80,'Greenland',1),(81,'Grenada',3),(82,'Guadeloupe',3),(83,'Guam',9),(84,'Guatemala',3),(85,'Guernsey',4),(86,'Guinea',5),(87,'Guinea-Bissau',5),(88,'Guyana',3),(89,'Haiti',3),(90,'Honduras',3),(91,'Hong Kong',8),(92,'Hungary',4),(93,'Iceland',4),(94,'India',8),(95,'Indonesia',8),(96,'Iran',7),(97,'Iraq',7),(98,'Ireland',4),(99,'Isle of Man',4),(100,'Israel',7),(101,'Italy',4),(102,'Jamaica',3),(103,'Japan',8),(104,'Jersey',4),(105,'Jordan',7),(106,'Kazakhstan',8),(107,'Kenya',5),(108,'Kiribati',9),(109,'Korea, North',8),(110,'Korea, South',8),(111,'Kuwait',7),(112,'Kyrgyzstan',8),(113,'Laos',8),(114,'Latvia',4),(115,'Lebanon',7),(116,'Lesotho',5),(117,'Liberia',5),(118,'Libya',5),(119,'Liechtenstein',4),(120,'Lithuania',4),(121,'Luxembourg',4),(122,'Macau',8),(123,'Macedonia',4),(124,'Madagascar',5),(125,'Malawi',5),(126,'Malaysia',8),(127,'Maldives',8),(128,'Mali',5),(129,'Malta',4),(130,'Marshall Islands',9),(131,'Martinique',3),(132,'Mauritania',5),(133,'Mauritius',5),(134,'Mayotte',5),(135,'Mexico',3),(136,'Micronesia, Fed. St.',9),(137,'Moldova',4),(138,'Monaco',4),(139,'Mongolia',8),(140,'Montserrat',3),(141,'Morocco',5),(142,'Mozambique',5),(143,'Namibia',5),(144,'Nauru',9),(145,'Nepal',8),(146,'Netherlands',4),(147,'Netherlands Antilles',3),(148,'New Caledonia',9),(149,'New Zealand',9),(150,'Nicaragua',3),(151,'Niger',5),(152,'Nigeria',5),(153,'N. Mariana Islands',9),(154,'Norway',4),(155,'Oman',7),(156,'Pakistan',7),(157,'Palau',9),(158,'Panama',3),(159,'Papua New Guinea',9),(160,'Paraguay',3),(161,'Peru',3),(162,'Philippines',8),(163,'Poland',4),(164,'Portugal',4),(165,'Puerto Rico',3),(166,'Qatar',7),(167,'Reunion',5),(168,'Romania',4),(169,'Russia',6),(170,'Rwanda',5),(171,'Saint Helena',5),(172,'Saint Kitts & Nevis',3),(173,'Saint Lucia',3),(174,'St Pierre & Miquelon',1),(175,'Saint Vincent and the Grenadines',3),(176,'Samoa',9),(177,'San Marino',4),(178,'Sao Tome & Principe',5),(179,'Saudi Arabia',7),(180,'Senegal',5),(181,'Serbia',4),(182,'Seychelles',5),(183,'Sierra Leone',5),(184,'Singapore',8),(185,'Slovakia',4),(186,'Slovenia',4),(187,'Solomon Islands',9),(188,'Somalia',5),(189,'South 5',5),(190,'Spain',4),(191,'Sri Lanka',8),(192,'Sudan',5),(193,'Suriname',3),(194,'Swaziland',5),(195,'Sweden',4),(196,'Switzerland',4),(197,'Syria',7),(198,'Taiwan',8),(199,'Tajikistan',7),(200,'Tanzania',5),(201,'Thailand',8),(202,'Togo',5),(203,'Tonga',9),(204,'Trinidad & Tobago',3),(205,'Tunisia',5),(206,'Turkey',7),(207,'Turkmenistan',7),(208,'Turks & Caicos Is',3),(209,'Tuvalu',9),(210,'Uganda',5),(211,'Ukraine',4),(212,'United Arab Emirates',7),(213,'United Kingdom',4),(214,'United States',1),(215,'Uruguay',3),(216,'Uzbekistan',8),(217,'Vanuatu',9),(218,'Venezuela',3),(219,'Vietnam',8),(220,'Virgin Islands',3),(221,'Wallis and Futuna',9),(222,'West Bank',7),(223,'Western Sahara',5),(224,'Yemen',7),(225,'Zambia',5),(226,'Zimbabwe',5);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docs`
--

DROP TABLE IF EXISTS `docs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `docs_type_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `docs_docs_type_id_foreign` (`docs_type_id`),
  CONSTRAINT `docs_docs_type_id_foreign` FOREIGN KEY (`docs_type_id`) REFERENCES `docs_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docs`
--

LOCK TABLES `docs` WRITE;
/*!40000 ALTER TABLE `docs` DISABLE KEYS */;
INSERT INTO `docs` VALUES (1,'Lorem ipsum dolor sit amet','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pharetra fringilla est dapibus dictum. Etiam eu lacus aliquam, pretium nisl vestibulum, aliquet ante. Integer feugiat vel libero quis bibendum. Cras a gravida tellus, a pharetra sapien. Cras vel finibus leo. Proin blandit lacus vitae condimentum cursus. Aliquam erat volutpat. Aenean venenatis neque at libero commodo, a vulputate augue vulputate. Sed vitae ultricies justo. Pellentesque molestie rhoncus risus ut volutpat. Morbi sit amet facilisis eros. Nunc vulputate quis orci a viverra. Nullam tempor non mi eu tincidunt. Suspendisse ullamcorper, nibh vitae pharetra iaculis, ipsum felis posuere ante, id varius odio purus ornare mi. Praesent fringilla hendrerit iaculis.<br />Pellentesque arcu tellus, pretium ac arcu at, commodo feugiat nunc. Duis at volutpat nunc, eu cursus massa. Nulla maximus bibendum nisi, eu congue ipsum cursus venenatis. Etiam commodo pharetra tellus, et posuere libero. Nunc vitae semper dolor. Curabitur sed lacus sed ante feugiat ullamcorper. Integer vitae posuere leo. Vivamus eget sagittis tellus, consequat feugiat libero. Suspendisse accumsan porta magna in dictum. Maecenas odio enim, elementum eu sem et, consectetur interdum tellus. Donec gravida massa eros, sodales mattis sapien ornare aliquet. Nunc hendrerit metus dui, vitae ultrices urna suscipit non. Nunc bibendum vestibulum maximus. Mauris vel imperdiet ipsum.<br />Aenean luctus vulputate lacinia. Aenean facilisis convallis semper. Donec mattis urna id lorem euismod sollicitudin. Nunc ultrices accumsan velit id aliquet. Suspendisse potenti. Pellentesque luctus cursus orci pharetra condimentum. Fusce ut sapien quis magna convallis tincidunt.<br />Nullam id varius felis, quis scelerisque velit. Nunc fermentum ligula eget orci pharetra, quis malesuada nisl elementum. Proin ut consectetur erat. Fusce ac odio in nibh vestibulum eleifend. Duis vel erat est. Mauris nisl nulla, cursus vitae odio non, bibendum pretium orci. Nullam vitae sapien nibh. Fusce ultricies vulputate risus vel tincidunt.<br />Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras aliquam sollicitudin mi at malesuada. Vivamus et ante elit. Nunc volutpat dolor nisl, vel vulputate felis condimentum quis. Ut maximus vel nibh ac semper. Sed sodales lorem sit amet felis sagittis tincidunt. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras viverra neque vel vulputate aliquet. Vivamus porta magna vel libero consequat, quis tristique ligula fringilla.','en',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(2,'Lorem ipsum dolor sit amet','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pharetra fringilla est dapibus dictum. Etiam eu lacus aliquam, pretium nisl vestibulum, aliquet ante. Integer feugiat vel libero quis bibendum. Cras a gravida tellus, a pharetra sapien. Cras vel finibus leo. Proin blandit lacus vitae condimentum cursus. Aliquam erat volutpat. Aenean venenatis neque at libero commodo, a vulputate augue vulputate. Sed vitae ultricies justo. Pellentesque molestie rhoncus risus ut volutpat. Morbi sit amet facilisis eros. Nunc vulputate quis orci a viverra. Nullam tempor non mi eu tincidunt. Suspendisse ullamcorper, nibh vitae pharetra iaculis, ipsum felis posuere ante, id varius odio purus ornare mi. Praesent fringilla hendrerit iaculis.<br />Pellentesque arcu tellus, pretium ac arcu at, commodo feugiat nunc. Duis at volutpat nunc, eu cursus massa. Nulla maximus bibendum nisi, eu congue ipsum cursus venenatis. Etiam commodo pharetra tellus, et posuere libero. Nunc vitae semper dolor. Curabitur sed lacus sed ante feugiat ullamcorper. Integer vitae posuere leo. Vivamus eget sagittis tellus, consequat feugiat libero. Suspendisse accumsan porta magna in dictum. Maecenas odio enim, elementum eu sem et, consectetur interdum tellus. Donec gravida massa eros, sodales mattis sapien ornare aliquet. Nunc hendrerit metus dui, vitae ultrices urna suscipit non. Nunc bibendum vestibulum maximus. Mauris vel imperdiet ipsum.<br />Aenean luctus vulputate lacinia. Aenean facilisis convallis semper. Donec mattis urna id lorem euismod sollicitudin. Nunc ultrices accumsan velit id aliquet. Suspendisse potenti. Pellentesque luctus cursus orci pharetra condimentum. Fusce ut sapien quis magna convallis tincidunt.<br />Nullam id varius felis, quis scelerisque velit. Nunc fermentum ligula eget orci pharetra, quis malesuada nisl elementum. Proin ut consectetur erat. Fusce ac odio in nibh vestibulum eleifend. Duis vel erat est. Mauris nisl nulla, cursus vitae odio non, bibendum pretium orci. Nullam vitae sapien nibh. Fusce ultricies vulputate risus vel tincidunt.<br />Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras aliquam sollicitudin mi at malesuada. Vivamus et ante elit. Nunc volutpat dolor nisl, vel vulputate felis condimentum quis. Ut maximus vel nibh ac semper. Sed sodales lorem sit amet felis sagittis tincidunt. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras viverra neque vel vulputate aliquet. Vivamus porta magna vel libero consequat, quis tristique ligula fringilla.','en',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(3,'Lorem ipsum dolor sit amet','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pharetra fringilla est dapibus dictum. Etiam eu lacus aliquam, pretium nisl vestibulum, aliquet ante. Integer feugiat vel libero quis bibendum. Cras a gravida tellus, a pharetra sapien. Cras vel finibus leo. Proin blandit lacus vitae condimentum cursus. Aliquam erat volutpat. Aenean venenatis neque at libero commodo, a vulputate augue vulputate. Sed vitae ultricies justo. Pellentesque molestie rhoncus risus ut volutpat. Morbi sit amet facilisis eros. Nunc vulputate quis orci a viverra. Nullam tempor non mi eu tincidunt. Suspendisse ullamcorper, nibh vitae pharetra iaculis, ipsum felis posuere ante, id varius odio purus ornare mi. Praesent fringilla hendrerit iaculis.<br />Pellentesque arcu tellus, pretium ac arcu at, commodo feugiat nunc. Duis at volutpat nunc, eu cursus massa. Nulla maximus bibendum nisi, eu congue ipsum cursus venenatis. Etiam commodo pharetra tellus, et posuere libero. Nunc vitae semper dolor. Curabitur sed lacus sed ante feugiat ullamcorper. Integer vitae posuere leo. Vivamus eget sagittis tellus, consequat feugiat libero. Suspendisse accumsan porta magna in dictum. Maecenas odio enim, elementum eu sem et, consectetur interdum tellus. Donec gravida massa eros, sodales mattis sapien ornare aliquet. Nunc hendrerit metus dui, vitae ultrices urna suscipit non. Nunc bibendum vestibulum maximus. Mauris vel imperdiet ipsum.<br />Aenean luctus vulputate lacinia. Aenean facilisis convallis semper. Donec mattis urna id lorem euismod sollicitudin. Nunc ultrices accumsan velit id aliquet. Suspendisse potenti. Pellentesque luctus cursus orci pharetra condimentum. Fusce ut sapien quis magna convallis tincidunt.<br />Nullam id varius felis, quis scelerisque velit. Nunc fermentum ligula eget orci pharetra, quis malesuada nisl elementum. Proin ut consectetur erat. Fusce ac odio in nibh vestibulum eleifend. Duis vel erat est. Mauris nisl nulla, cursus vitae odio non, bibendum pretium orci. Nullam vitae sapien nibh. Fusce ultricies vulputate risus vel tincidunt.<br />Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras aliquam sollicitudin mi at malesuada. Vivamus et ante elit. Nunc volutpat dolor nisl, vel vulputate felis condimentum quis. Ut maximus vel nibh ac semper. Sed sodales lorem sit amet felis sagittis tincidunt. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras viverra neque vel vulputate aliquet. Vivamus porta magna vel libero consequat, quis tristique ligula fringilla.','en',3,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(4,'Lorem ipsum dolor sit amet','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pharetra fringilla est dapibus dictum. Etiam eu lacus aliquam, pretium nisl vestibulum, aliquet ante. Integer feugiat vel libero quis bibendum. Cras a gravida tellus, a pharetra sapien. Cras vel finibus leo. Proin blandit lacus vitae condimentum cursus. Aliquam erat volutpat. Aenean venenatis neque at libero commodo, a vulputate augue vulputate. Sed vitae ultricies justo. Pellentesque molestie rhoncus risus ut volutpat. Morbi sit amet facilisis eros. Nunc vulputate quis orci a viverra. Nullam tempor non mi eu tincidunt. Suspendisse ullamcorper, nibh vitae pharetra iaculis, ipsum felis posuere ante, id varius odio purus ornare mi. Praesent fringilla hendrerit iaculis.<br />Pellentesque arcu tellus, pretium ac arcu at, commodo feugiat nunc. Duis at volutpat nunc, eu cursus massa. Nulla maximus bibendum nisi, eu congue ipsum cursus venenatis. Etiam commodo pharetra tellus, et posuere libero. Nunc vitae semper dolor. Curabitur sed lacus sed ante feugiat ullamcorper. Integer vitae posuere leo. Vivamus eget sagittis tellus, consequat feugiat libero. Suspendisse accumsan porta magna in dictum. Maecenas odio enim, elementum eu sem et, consectetur interdum tellus. Donec gravida massa eros, sodales mattis sapien ornare aliquet. Nunc hendrerit metus dui, vitae ultrices urna suscipit non. Nunc bibendum vestibulum maximus. Mauris vel imperdiet ipsum.<br />Aenean luctus vulputate lacinia. Aenean facilisis convallis semper. Donec mattis urna id lorem euismod sollicitudin. Nunc ultrices accumsan velit id aliquet. Suspendisse potenti. Pellentesque luctus cursus orci pharetra condimentum. Fusce ut sapien quis magna convallis tincidunt.<br />Nullam id varius felis, quis scelerisque velit. Nunc fermentum ligula eget orci pharetra, quis malesuada nisl elementum. Proin ut consectetur erat. Fusce ac odio in nibh vestibulum eleifend. Duis vel erat est. Mauris nisl nulla, cursus vitae odio non, bibendum pretium orci. Nullam vitae sapien nibh. Fusce ultricies vulputate risus vel tincidunt.<br />Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras aliquam sollicitudin mi at malesuada. Vivamus et ante elit. Nunc volutpat dolor nisl, vel vulputate felis condimentum quis. Ut maximus vel nibh ac semper. Sed sodales lorem sit amet felis sagittis tincidunt. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras viverra neque vel vulputate aliquet. Vivamus porta magna vel libero consequat, quis tristique ligula fringilla.','fr',1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(5,'Lorem ipsum dolor sit amet','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pharetra fringilla est dapibus dictum. Etiam eu lacus aliquam, pretium nisl vestibulum, aliquet ante. Integer feugiat vel libero quis bibendum. Cras a gravida tellus, a pharetra sapien. Cras vel finibus leo. Proin blandit lacus vitae condimentum cursus. Aliquam erat volutpat. Aenean venenatis neque at libero commodo, a vulputate augue vulputate. Sed vitae ultricies justo. Pellentesque molestie rhoncus risus ut volutpat. Morbi sit amet facilisis eros. Nunc vulputate quis orci a viverra. Nullam tempor non mi eu tincidunt. Suspendisse ullamcorper, nibh vitae pharetra iaculis, ipsum felis posuere ante, id varius odio purus ornare mi. Praesent fringilla hendrerit iaculis.<br />Pellentesque arcu tellus, pretium ac arcu at, commodo feugiat nunc. Duis at volutpat nunc, eu cursus massa. Nulla maximus bibendum nisi, eu congue ipsum cursus venenatis. Etiam commodo pharetra tellus, et posuere libero. Nunc vitae semper dolor. Curabitur sed lacus sed ante feugiat ullamcorper. Integer vitae posuere leo. Vivamus eget sagittis tellus, consequat feugiat libero. Suspendisse accumsan porta magna in dictum. Maecenas odio enim, elementum eu sem et, consectetur interdum tellus. Donec gravida massa eros, sodales mattis sapien ornare aliquet. Nunc hendrerit metus dui, vitae ultrices urna suscipit non. Nunc bibendum vestibulum maximus. Mauris vel imperdiet ipsum.<br />Aenean luctus vulputate lacinia. Aenean facilisis convallis semper. Donec mattis urna id lorem euismod sollicitudin. Nunc ultrices accumsan velit id aliquet. Suspendisse potenti. Pellentesque luctus cursus orci pharetra condimentum. Fusce ut sapien quis magna convallis tincidunt.<br />Nullam id varius felis, quis scelerisque velit. Nunc fermentum ligula eget orci pharetra, quis malesuada nisl elementum. Proin ut consectetur erat. Fusce ac odio in nibh vestibulum eleifend. Duis vel erat est. Mauris nisl nulla, cursus vitae odio non, bibendum pretium orci. Nullam vitae sapien nibh. Fusce ultricies vulputate risus vel tincidunt.<br />Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras aliquam sollicitudin mi at malesuada. Vivamus et ante elit. Nunc volutpat dolor nisl, vel vulputate felis condimentum quis. Ut maximus vel nibh ac semper. Sed sodales lorem sit amet felis sagittis tincidunt. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras viverra neque vel vulputate aliquet. Vivamus porta magna vel libero consequat, quis tristique ligula fringilla.','fr',2,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(6,'Lorem ipsum dolor sit amet','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pharetra fringilla est dapibus dictum. Etiam eu lacus aliquam, pretium nisl vestibulum, aliquet ante. Integer feugiat vel libero quis bibendum. Cras a gravida tellus, a pharetra sapien. Cras vel finibus leo. Proin blandit lacus vitae condimentum cursus. Aliquam erat volutpat. Aenean venenatis neque at libero commodo, a vulputate augue vulputate. Sed vitae ultricies justo. Pellentesque molestie rhoncus risus ut volutpat. Morbi sit amet facilisis eros. Nunc vulputate quis orci a viverra. Nullam tempor non mi eu tincidunt. Suspendisse ullamcorper, nibh vitae pharetra iaculis, ipsum felis posuere ante, id varius odio purus ornare mi. Praesent fringilla hendrerit iaculis.<br />Pellentesque arcu tellus, pretium ac arcu at, commodo feugiat nunc. Duis at volutpat nunc, eu cursus massa. Nulla maximus bibendum nisi, eu congue ipsum cursus venenatis. Etiam commodo pharetra tellus, et posuere libero. Nunc vitae semper dolor. Curabitur sed lacus sed ante feugiat ullamcorper. Integer vitae posuere leo. Vivamus eget sagittis tellus, consequat feugiat libero. Suspendisse accumsan porta magna in dictum. Maecenas odio enim, elementum eu sem et, consectetur interdum tellus. Donec gravida massa eros, sodales mattis sapien ornare aliquet. Nunc hendrerit metus dui, vitae ultrices urna suscipit non. Nunc bibendum vestibulum maximus. Mauris vel imperdiet ipsum.<br />Aenean luctus vulputate lacinia. Aenean facilisis convallis semper. Donec mattis urna id lorem euismod sollicitudin. Nunc ultrices accumsan velit id aliquet. Suspendisse potenti. Pellentesque luctus cursus orci pharetra condimentum. Fusce ut sapien quis magna convallis tincidunt.<br />Nullam id varius felis, quis scelerisque velit. Nunc fermentum ligula eget orci pharetra, quis malesuada nisl elementum. Proin ut consectetur erat. Fusce ac odio in nibh vestibulum eleifend. Duis vel erat est. Mauris nisl nulla, cursus vitae odio non, bibendum pretium orci. Nullam vitae sapien nibh. Fusce ultricies vulputate risus vel tincidunt.<br />Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras aliquam sollicitudin mi at malesuada. Vivamus et ante elit. Nunc volutpat dolor nisl, vel vulputate felis condimentum quis. Ut maximus vel nibh ac semper. Sed sodales lorem sit amet felis sagittis tincidunt. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras viverra neque vel vulputate aliquet. Vivamus porta magna vel libero consequat, quis tristique ligula fringilla.','fr',3,'2016-06-06 21:08:37','2016-06-06 21:08:37');
/*!40000 ALTER TABLE `docs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docs_types`
--

DROP TABLE IF EXISTS `docs_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docs_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docs_types`
--

LOCK TABLES `docs_types` WRITE;
/*!40000 ALTER TABLE `docs_types` DISABLE KEYS */;
INSERT INTO `docs_types` VALUES (1,'tnc'),(2,'privacy_policy'),(3,'legal_notes');
/*!40000 ALTER TABLE `docs_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2016_04_07_184547_create_products_table',1),('2016_05_17_141030_create_request_access_table',1),('2016_05_25_155659_create_report_tables',1),('2016_05_25_200350_create_terms_and_conditions_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_settings`
--

DROP TABLE IF EXISTS `notification_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `notification_type_id` int(10) unsigned NOT NULL,
  `allowed` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `notification_settings_user_id_foreign` (`user_id`),
  KEY `notification_settings_notification_type_id_foreign` (`notification_type_id`),
  CONSTRAINT `notification_settings_notification_type_id_foreign` FOREIGN KEY (`notification_type_id`) REFERENCES `notification_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notification_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_settings`
--

LOCK TABLES `notification_settings` WRITE;
/*!40000 ALTER TABLE `notification_settings` DISABLE KEYS */;
INSERT INTO `notification_settings` VALUES (1,1,1,1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(2,1,2,1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(3,1,3,1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(4,1,4,1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(5,1,5,1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(6,1,6,1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(7,1,7,1,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(8,1,8,1,'2016-06-06 21:08:37','2016-06-06 21:08:37');
/*!40000 ALTER TABLE `notification_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_types`
--

DROP TABLE IF EXISTS `notification_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_types`
--

LOCK TABLES `notification_types` WRITE;
/*!40000 ALTER TABLE `notification_types` DISABLE KEYS */;
INSERT INTO `notification_types` VALUES (1,'Send me a message','send_message'),(2,'Made an offer on your post','made_offer'),(3,'Denied your offer','denied_offer'),(4,'Approved your offer','approved_offer'),(5,'Has confirmed your transaction','confirmed_transaction'),(6,'Has canceled your transaction','canceled_transaction'),(7,'A transaction started','transaction_start'),(8,'A transaction Ended','end_transaction');
/*!40000 ALTER TABLE `notification_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `pin` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `password_resets_user_id_unique` (`user_id`),
  UNIQUE KEY `password_resets_pin_unique` (`pin`),
  CONSTRAINT `password_resets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'all','Can do all the things','2016-06-06 21:08:37','2016-06-06 21:08:37'),(2,'create_post','Can create a post','2016-06-06 21:08:37','2016-06-06 21:08:37'),(3,'update_post','Can update a post','2016-06-06 21:08:37','2016-06-06 21:08:37');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_media`
--

DROP TABLE IF EXISTS `product_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_media_product_id_foreign` (`product_id`),
  CONSTRAINT `product_media_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_media`
--

LOCK TABLES `product_media` WRITE;
/*!40000 ALTER TABLE `product_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_meta`
--

DROP TABLE IF EXISTS `product_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_meta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_meta_product_id_foreign` (`product_id`),
  CONSTRAINT `product_meta_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_meta`
--

LOCK TABLES `product_meta` WRITE;
/*!40000 ALTER TABLE `product_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_statuses`
--

DROP TABLE IF EXISTS `product_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_statuses`
--

LOCK TABLES `product_statuses` WRITE;
/*!40000 ALTER TABLE `product_statuses` DISABLE KEYS */;
INSERT INTO `product_statuses` VALUES (1,'created','When user creates a new post'),(2,'approved1','When the post is moved into the create state, the application will query the database to verify the user privileges. If the user is authorized to create the post, the states will be changed to \"approved1\"'),(3,'posted','Right after post status change from approved1'),(4,'offer','A customer shows interest and initiates into the post'),(5,'approved2','Any changes made to the original post details then this is required'),(6,'sold','Immediately after successfully changed to approved2 state'),(7,'completed','When Post creator mark complete'),(8,'rated','Both parties have successfully completed the review process'),(9,'archived','A post only available by external super-users'),(10,'expired','A date listed has arrived with out changing from a \"posted\" state');
/*!40000 ALTER TABLE `product_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('buy','sell') COLLATE utf8_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `available_from` date NOT NULL,
  `available_to` date NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_country_id_foreign` (`country_id`),
  KEY `products_status_id_foreign` (`status_id`),
  KEY `products_user_id_foreign` (`user_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `product_statuses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Test Product 1','sell','TST0001','This is a test 1 product.',65784.87,'2016-04-24','2016-06-24',1,3,37,14,NULL,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(2,'Test Product 2','buy','TST0002','This is a test 2 product.',65784.87,'2016-04-26','2016-06-30',1,3,37,14,NULL,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(3,'Test Product 3','sell','TST0003','This is a test 3 product.',65784.87,'2016-02-01','2016-10-17',1,3,94,14,NULL,'2016-06-06 21:08:37','2016-06-06 21:08:37'),(4,'Test Product 4','buy','TST0004','This is a test 4 product.',65784.87,'2016-03-23','2016-09-03',1,3,94,14,NULL,'2016-06-06 21:08:37','2016-06-06 21:08:37');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `total_ratings` int(11) NOT NULL,
  `total_votes` int(11) NOT NULL,
  `avg_rate` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratings_user_id_unique` (`user_id`),
  CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
INSERT INTO `ratings` VALUES (1,1,0,0,0,'2016-06-06 21:08:37','2016-06-06 21:08:37');
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regions`
--

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` VALUES (1,'North America'),(2,'Central America'),(3,'Caribbean/ South America'),(4,'Europe'),(5,'Africa'),(6,'Russia'),(7,'Middle East'),(8,'Asia'),(9,'Australia/ South Pacific');
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_types`
--

DROP TABLE IF EXISTS `report_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_types`
--

LOCK TABLES `report_types` WRITE;
/*!40000 ALTER TABLE `report_types` DISABLE KEYS */;
INSERT INTO `report_types` VALUES (1,'spam'),(2,'broken'),(3,'feedback');
/*!40000 ALTER TABLE `report_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `report_type_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `reports_user_id_foreign` (`user_id`),
  KEY `reports_report_type_id_foreign` (`report_type_id`),
  CONSTRAINT `reports_report_type_id_foreign` FOREIGN KEY (`report_type_id`) REFERENCES `report_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_accesses`
--

DROP TABLE IF EXISTS `request_accesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_accesses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_accesses`
--

LOCK TABLES `request_accesses` WRITE;
/*!40000 ALTER TABLE `request_accesses` DISABLE KEYS */;
/*!40000 ALTER TABLE `request_accesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super User','super_user','2016-06-06 21:08:37','2016-06-06 21:08:37');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_permissions`
--

DROP TABLE IF EXISTS `roles_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `roles_permissions_role_id_foreign` (`role_id`),
  KEY `roles_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `roles_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `roles_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_permissions`
--

LOCK TABLES `roles_permissions` WRITE;
/*!40000 ALTER TABLE `roles_permissions` DISABLE KEYS */;
INSERT INTO `roles_permissions` VALUES (1,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,1,3,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `roles_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `rest_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `region_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `sessions_user_id_foreign` (`user_id`),
  KEY `sessions_region_id_foreign` (`region_id`),
  CONSTRAINT `sessions_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('bbab732981d09160720488bf9a3b59bf',1,NULL,'2016-06-06 21:09:10');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` bigint(20) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passcode` int(11) NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_identifier_unique` (`identifier`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_company_id_foreign` (`company_id`),
  CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mehul','Katpara','mehul8236','mehul8236',6478678236,1,'mehul@kpd-i.com',8236,'$2y$10$pusBQwVvfZtmHbUOxBhKU.8IQK3KstkHzIz7HJYOikjWEJrTb9vH.',NULL,NULL,'2016-06-06 21:08:37','2016-06-06 21:08:37');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `users_roles_role_id_foreign` (`role_id`),
  KEY `users_roles_user_id_foreign` (`user_id`),
  CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_roles`
--

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` VALUES (1,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-07 16:17:12
