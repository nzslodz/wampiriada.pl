-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: wampiriada
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `action_data`
--

DROP TABLE IF EXISTS `action_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_data` (
  `id` int(10) unsigned NOT NULL,
  `zero_plus` int(10) unsigned NOT NULL DEFAULT '0',
  `zero_minus` int(10) unsigned NOT NULL DEFAULT '0',
  `a_plus` int(10) unsigned NOT NULL DEFAULT '0',
  `a_minus` int(10) unsigned NOT NULL DEFAULT '0',
  `b_plus` int(10) unsigned NOT NULL DEFAULT '0',
  `b_minus` int(10) unsigned NOT NULL DEFAULT '0',
  `ab_plus` int(10) unsigned NOT NULL DEFAULT '0',
  `ab_minus` int(10) unsigned NOT NULL DEFAULT '0',
  `unknown` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  CONSTRAINT `action_data_id_foreign` FOREIGN KEY (`id`) REFERENCES `action_days` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_data`
--

LOCK TABLES `action_data` WRITE;
/*!40000 ALTER TABLE `action_data` DISABLE KEYS */;
INSERT INTO `action_data` VALUES (118,31,3,19,3,9,4,10,3,8),(119,7,1,12,1,7,1,5,0,8),(120,23,6,25,4,12,3,7,2,19),(121,17,4,21,2,8,3,4,1,15),(122,3,0,0,1,6,0,1,0,6),(123,6,1,3,1,3,0,3,0,1),(124,18,5,24,8,18,1,15,3,17),(125,19,4,13,2,12,3,6,2,11),(126,12,1,10,1,2,0,1,0,11),(127,24,7,27,7,10,3,4,5,28),(128,13,3,13,6,8,6,5,0,23),(129,24,4,20,7,10,1,6,0,22),(130,9,4,7,10,7,3,3,0,33),(131,0,0,0,0,0,0,0,0,19),(132,0,0,0,0,0,0,0,0,83),(133,0,0,0,0,0,0,0,0,25),(134,0,0,0,0,0,0,0,0,32),(135,0,0,0,0,0,0,0,0,32),(136,0,0,0,0,0,0,0,0,107),(137,0,0,0,0,0,0,0,0,98),(138,0,0,0,0,0,0,0,0,11),(139,0,0,0,0,0,0,0,0,97),(140,0,0,0,0,0,0,0,0,106),(141,0,0,0,0,0,0,0,0,66),(142,0,0,0,0,0,0,0,0,114),(143,0,0,0,0,0,0,0,0,105),(144,0,0,0,0,0,0,0,0,57),(145,0,0,0,0,0,0,0,0,99),(146,0,0,0,0,0,0,0,0,23),(147,0,0,0,0,0,0,0,0,120),(148,0,0,0,0,0,0,0,0,124),(149,0,0,0,0,0,0,0,0,24),(150,0,0,0,0,0,0,0,0,111),(151,0,0,0,0,0,0,0,0,126),(152,0,0,0,0,0,0,0,0,103),(153,0,0,0,0,0,0,0,0,86),(154,0,0,0,0,0,0,0,0,81),(155,0,0,0,0,0,0,0,0,123),(156,0,0,0,0,0,0,0,0,60),(157,8,3,19,6,4,2,6,0,1),(158,24,5,36,8,22,2,8,4,14),(159,25,8,33,13,17,0,3,2,15),(160,28,5,21,12,13,5,4,0,13),(161,12,5,13,2,9,3,1,2,4),(162,23,6,22,2,10,2,5,2,31),(163,16,3,9,3,5,3,4,1,7),(164,20,2,19,2,5,1,6,1,18),(165,29,7,21,6,15,3,2,1,24),(166,14,6,15,3,10,1,6,0,32),(167,23,5,19,6,10,2,5,0,11),(168,27,9,24,4,16,4,9,1,25),(169,0,0,0,0,0,0,0,0,59),(170,7,1,8,2,1,0,1,0,6),(171,15,4,18,2,6,1,4,0,11),(172,27,7,23,8,13,5,4,2,20),(173,0,0,0,0,0,0,0,0,0),(174,0,0,0,0,0,0,0,0,0),(175,0,0,0,0,0,0,0,0,0),(176,0,0,0,0,0,0,0,0,0),(177,0,0,0,0,0,0,0,0,0),(178,0,0,0,0,0,0,0,0,0),(179,0,0,0,0,0,0,0,0,0),(180,0,0,0,0,0,0,0,0,0),(181,0,0,0,0,0,0,0,0,0),(182,0,0,0,0,0,0,0,0,0),(183,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `action_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_days`
--

DROP TABLE IF EXISTS `action_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `place_id` int(10) unsigned NOT NULL,
  `edition_id` int(10) unsigned NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `marrow` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `action_days_place_id_foreign` (`place_id`),
  KEY `action_days_edition_id_foreign` (`edition_id`),
  CONSTRAINT `action_days_edition_id_foreign` FOREIGN KEY (`edition_id`) REFERENCES `editions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `action_days_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_days`
--

LOCK TABLES `action_days` WRITE;
/*!40000 ALTER TABLE `action_days` DISABLE KEYS */;
INSERT INTO `action_days` VALUES (118,49,10,'10:00:00','16:00:00','2013-05-12 22:00:00','2013-05-12 22:00:00',0),(119,52,10,'10:00:00','16:00:00','2013-05-13 22:00:00','2013-05-13 22:00:00',0),(120,56,10,'10:00:00','16:00:00','2013-05-14 22:00:00','2013-05-14 22:00:00',0),(121,50,10,'10:00:00','16:00:00','2013-05-16 22:00:00','2013-05-16 22:00:00',0),(122,61,10,'10:00:00','14:00:00','2013-05-17 22:00:00','2013-05-17 22:00:00',0),(123,52,10,'10:00:00','16:00:00','2013-05-19 22:00:00','2013-05-19 22:00:00',0),(124,51,10,'10:00:00','16:00:00','2013-05-20 22:00:00','2013-05-20 22:00:00',0),(125,57,10,'10:00:00','16:00:00','2013-05-21 22:00:00','2013-05-21 22:00:00',0),(126,62,10,'10:00:00','16:00:00','2013-05-25 22:00:00','2013-05-25 22:00:00',0),(127,50,10,'10:00:00','16:00:00','2013-05-27 22:00:00','2013-05-27 22:00:00',0),(128,58,10,'10:00:00','16:00:00','2013-05-28 22:00:00','2013-05-28 22:00:00',0),(129,59,10,'10:00:00','16:00:00','2013-06-02 22:00:00','2013-06-02 22:00:00',0),(130,60,10,'10:00:00','16:00:00','2013-06-03 22:00:00','2013-06-03 22:00:00',0),(131,63,11,'15:00:00','17:00:00','2012-05-07 22:00:00','2012-05-07 22:00:00',0),(132,57,11,'10:00:00','16:00:00','2012-05-08 22:00:00','2012-05-08 22:00:00',0),(133,58,11,'10:00:00','16:00:00','2012-05-09 22:00:00','2012-05-09 22:00:00',0),(134,61,11,'10:00:00','14:00:00','2012-05-11 22:00:00','2012-05-11 22:00:00',0),(135,54,11,'10:00:00','16:00:00','2012-05-14 22:00:00','2012-05-14 22:00:00',0),(136,55,11,'10:00:00','16:00:00','2012-05-15 22:00:00','2012-05-15 22:00:00',0),(137,53,11,'10:00:00','16:00:00','2012-05-16 22:00:00','2012-05-16 22:00:00',0),(138,64,11,'10:00:00','14:00:00','2012-05-18 22:00:00','2012-05-18 22:00:00',0),(139,56,11,'10:00:00','16:00:00','2012-05-21 22:00:00','2012-05-21 22:00:00',0),(140,50,11,'10:00:00','16:00:00','2012-05-22 22:00:00','2012-05-22 22:00:00',0),(141,53,11,'10:00:00','16:00:00','2012-05-23 22:00:00','2012-05-23 22:00:00',0),(142,49,11,'10:00:00','16:00:00','2012-05-28 22:00:00','2012-05-28 22:00:00',0),(143,59,11,'10:00:00','16:00:00','2012-05-30 22:00:00','2012-05-30 22:00:00',0),(144,60,11,'10:00:00','16:00:00','2012-05-30 22:00:00','2012-05-30 22:00:00',0),(145,57,12,'10:00:00','16:00:00','2012-11-21 23:00:00','2012-11-21 23:00:00',0),(146,61,12,'10:00:00','14:00:00','2012-11-23 23:00:00','2012-11-23 23:00:00',0),(147,50,12,'10:00:00','16:00:00','2012-11-25 23:00:00','2012-11-25 23:00:00',0),(148,53,12,'10:00:00','16:00:00','2012-11-28 23:00:00','2012-11-28 23:00:00',0),(149,64,12,'10:00:00','14:00:00','2012-11-30 23:00:00','2012-11-30 23:00:00',0),(150,59,12,'10:00:00','16:00:00','2012-12-02 23:00:00','2012-12-02 23:00:00',0),(151,55,12,'10:00:00','16:00:00','2012-12-03 23:00:00','2012-12-03 23:00:00',0),(152,56,12,'10:00:00','16:00:00','2012-12-04 23:00:00','2012-12-04 23:00:00',0),(153,60,12,'10:00:00','16:00:00','2012-12-09 23:00:00','2012-12-09 23:00:00',0),(154,52,12,'10:00:00','16:00:00','2012-12-11 23:00:00','2012-12-11 23:00:00',0),(155,49,12,'10:00:00','16:00:00','2012-12-12 23:00:00','2012-12-12 23:00:00',0),(156,62,12,'10:00:00','15:00:00','2012-12-14 23:00:00','2012-12-14 23:00:00',0),(157,53,10,'10:00:00','16:00:00','2013-06-05 22:00:00','2013-06-05 22:00:00',0),(158,57,13,'10:00:00','16:00:00','2013-11-17 23:00:00','2013-11-17 23:00:00',1),(159,50,13,'10:00:00','16:00:00','2013-11-18 23:00:00','2013-11-18 23:00:00',1),(160,49,13,'10:00:00','16:00:00','2013-11-24 23:00:00','2013-11-24 23:00:00',0),(161,54,13,'10:00:00','16:00:00','2013-11-25 23:00:00','2013-11-25 23:00:00',1),(162,59,13,'10:00:00','16:00:00','2013-11-27 23:00:00','2013-11-27 23:00:00',1),(163,52,13,'10:00:00','14:00:00','2013-11-28 23:00:00','2013-11-28 23:00:00',1),(164,58,13,'10:00:00','16:00:00','2013-12-02 23:00:00','2013-12-02 23:00:00',1),(165,65,13,'10:00:00','16:00:00','2013-12-03 23:00:00','2013-12-03 23:00:00',1),(166,60,13,'10:00:00','16:00:00','2013-12-04 23:00:00','2013-12-04 23:00:00',1),(167,55,13,'10:00:00','16:00:00','2013-12-08 23:00:00','2013-12-08 23:00:00',0),(168,56,13,'10:00:00','16:00:00','2013-12-09 23:00:00','2013-12-09 23:00:00',1),(169,54,13,'10:00:00','16:00:00','2013-12-11 23:00:00','2013-12-11 23:00:00',1),(170,61,13,'10:00:00','14:00:00','2013-11-22 23:00:00','2013-11-22 23:00:00',0),(171,57,14,'10:00:00','16:00:00','2014-05-18 22:00:00','2014-05-18 22:00:00',1),(172,65,14,'10:00:00','16:00:00','2014-05-19 22:00:00','2014-05-19 22:00:00',1),(173,58,14,'10:00:00','16:00:00','2014-05-20 22:00:00','2014-05-20 22:00:00',1),(174,59,14,'10:00:00','16:00:00','2014-05-21 22:00:00','2014-05-21 22:00:00',1),(175,61,14,'10:00:00','14:00:00','2014-05-23 22:00:00','2014-05-23 22:00:00',0),(176,55,14,'10:00:00','16:00:00','2014-05-25 22:00:00','2014-05-25 22:00:00',0),(177,56,14,'10:00:00','16:00:00','2014-05-26 22:00:00','2014-05-26 22:00:00',1),(178,52,14,'10:00:00','14:00:00','2014-05-27 22:00:00','2014-05-27 22:00:00',1),(179,66,14,'10:00:00','14:00:00','2014-05-28 22:00:00','2014-05-28 22:00:00',0),(180,49,14,'10:00:00','16:00:00','2014-06-01 22:00:00','2014-06-01 22:00:00',0),(181,50,14,'10:00:00','16:00:00','2014-06-03 22:00:00','2014-06-03 22:00:00',1),(182,60,14,'10:00:00','16:00:00','2014-06-04 22:00:00','2014-06-04 22:00:00',1),(183,54,14,'10:00:00','16:00:00','2014-06-08 22:00:00','2014-06-08 22:00:00',1);
/*!40000 ALTER TABLE `action_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `action_results`
--

DROP TABLE IF EXISTS `action_results`;
/*!50001 DROP VIEW IF EXISTS `action_results`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `action_results` (
 `created_at` tinyint NOT NULL,
  `updated_at` tinyint NOT NULL,
  `edition_id` tinyint NOT NULL,
  `place_id` tinyint NOT NULL,
  `school_id` tinyint NOT NULL,
  `edition_type` tinyint NOT NULL,
  `zero_plus` tinyint NOT NULL,
  `zero_minus` tinyint NOT NULL,
  `a_plus` tinyint NOT NULL,
  `a_minus` tinyint NOT NULL,
  `b_plus` tinyint NOT NULL,
  `b_minus` tinyint NOT NULL,
  `ab_plus` tinyint NOT NULL,
  `ab_minus` tinyint NOT NULL,
  `unknown` tinyint NOT NULL,
  `overall` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `editions`
--

DROP TABLE IF EXISTS `editions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `editions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `when` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editions`
--

LOCK TABLES `editions` WRITE;
/*!40000 ALTER TABLE `editions` DISABLE KEYS */;
INSERT INTO `editions` VALUES (10,22,'22. edycja','05/2013'),(11,21,'21. edycja','11/2012'),(12,20,'20. edycja','05/2012'),(13,23,'23. edycja','11/2013'),(14,24,'24. edycja','05/2014');
/*!40000 ALTER TABLE `editions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kuznia_liderow`
--

DROP TABLE IF EXISTS `kuznia_liderow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kuznia_liderow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` text,
  `topic1` text,
  `topic2` text,
  `source` varchar(255) DEFAULT NULL,
  `check` tinyint(1) DEFAULT NULL,
  `accepted` tinyint(1) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kuznia_liderow`
--

LOCK TABLES `kuznia_liderow` WRITE;
/*!40000 ALTER TABLE `kuznia_liderow` DISABLE KEYS */;
INSERT INTO `kuznia_liderow` VALUES (2,'Justyna','Kierzkowska','justynakierzkowska89@gmail.com','Szkolenie pozwoli mi nabyć cenne doświadczenie i myślę, że udział w takim przedsięwzięciu pomoże mi efektywnie wykorzystywać zdobytą wiedzę w praktyce. Preferuje pracę w grupie i współdziałanie do osiągnięcia wspólnego celu.','Jak odnieść  sukces by blog internetowy był rozpznawalny?','Co robić by praca zespołu menadżerskiego była efektywna i by ludzie pracujący w zespole stanowili zgraną grupę?','z FB',1,1,''),(3,'Anna','Szałkiewicz','anna.szalkiewicz@wp.pl','W ciągu ostatnich 7 dni nauczyłam się więcej niż w ciągu ostatnich kilku lat. Wszystko za sprawą zastosowania w życiu kilku zasad, których nauczyłam się na jednym ze szkoleń na temat rozwoju osobistego.  Bardzo chciałabym kontynuować ten rozwój i podążać dalej w tym kierunku. ','Jak czerpać korzyści ze swojej wiedzy?','Jak wykorzystywać swoją wiedze w praktyce? ','z facebooka',1,1,''),(4,'Radosław','Zalewski','rado.zalewski@gmail.com','Organizowałem pierwsze spotkanie z Alexem w Łodzi \"Co robić na studiach  żeby potem żyć lepiej niz dobrze\" a także jestem wieloletnim fanem alexba.eu.','W swojej książce Alex pisze, żeby nie wybuchac jak żeliwo tylko byc jak deska - bardziej elastycznym i sygnalizować problemy. A jak czasem się nie da bo druga strona nie czyta, albo udaje ze nie czyta tej sygnalizacji i wtedy pozostaje wybuch?','Czy Alex uważa, że książka jest dla czytelników jego bloga? (pytanie przewrotne, ale tylko z pozoru, ponieważ moim zdaniem - a jestem czytelnikiem jego bloga - książka nie jest absolutnie dla jego fanów ponieważ mieli okazję oni przeczytać większość tez i rad zawartych w książce. Traktuje ją jak takie podsumowanie, a przyznam że spodziewałem się paru rewolucyjnych myśli. Kwestia oczekiwań - następnym razem będą inne)','z FB',1,1,''),(5,'Joanna','Stompel','stompel@gmail.com','Bo organizujecie to spotkanie dla takich osób jak ja. Interesuję się wspieraniem rozwoju osobowości, dbam o pogłębianie własnej samoświadomości i pomagam innym odkryć swój potencjał. Uwielbiam pracę z ludźmi. Takie spotkania, gdzie gromadzą się ludzie, dla których istotną wartością jest rozwój, są niezwykle inspirujące i motywujące do działania. Muszę tam być!','Jak najefektywniej przeprowadzić proces zmiany w zespole współpracowników?','Jaka jest Twoja ulubiona technika coachingowa?','z ngo.pl',1,1,''),(6,'Ewa','Mospinek','ewa.mar@op.pl','Jestem pracownikiem budżetowym, ale chciałabym zacząć w jakiś sposób włączyć się w wolontariat.  Mam nadzieje, że spotkanie z Panem pozwoli szerzej spojrzeć mi na otaczający świat i będzie inspiracją, w którym obszarze mogłabym zacząć działać.  Poza tym wierzę, że aby pomagać innym w pierwszej kolejności należy samemu mieć \"porządek\" u siebie. Zatem spotkanie, które Pan proponuje będzie dla mnie \"próbą\" ogarnięcia własnego życia. Z jednej strony może jakaś podpowiedź, z drugiej może wybór czegoś konkretnego (fala możliwości powoduje, ze z decyzyjnością i selekcją mam problem). Oprócz, że tak to określę \"wolontaryjnych\" ambicji chciałabym zrozumieć, zapanować nad relacjami z ludźmi w życiu zawodowym i w osobistym. Mam tu na myśli zdrowe relacje i \"zaproszenie\" niejako do własnego świata ludzi, którzy pozwolą \"rozbudzić\" mój potencjał i którym również ja w jakiś sposób \"pozwolę rozwinąć skrzydła\".  Myślę nad tym co dzieje się w moim życiu, analizuje i mam wrażenie że schemat powtarza się... Mam poprostu problem w zbudowaniu głębszej więzi przyjacielskiej. Mogłabym tu jeszcze wiele dodać ale życie \"przyspiesza\" i moja córka próbuje zwróci na siebie uwagę :) A zatem podsumowując spotkanie=myślenie u mnie. Pozdrawiam i liczę, że się spotkamy :) Z pozdrowieniami Ewa Mospinek','Jak byc dobrym i mądrym przyjacielem dla innych?','Co Nas uszczęsliwia i dlaczego tak bardzo to jest inne dla poszczególnych ludzi?','ze strony www.ngo.pl',1,1,''),(7,'Agnieszka','Klimionek','agnieszka.klimionek@vp.pl','Sukces w moich relacjach z innymi spędza mi ostatnio sen z powiek - zgłębiam tajniki zarządzania projektami i część poświęcona kompetencjom miękkim jest dla mnie szczególnie istotna, tym bardziej że to moja słaba strona. ','Jak walczyć se stresem w sytuacji dużego skupienia uwagi i odpowiedzialności na osobie podejmującej decyzje? Na czym się wówczas koncentrować?','Jak w relacjach interpesonalnych zachować twarz, czyli pozostać w zgodzie ze sobą a jednocześnie nie naruszyć dobrych relacji z każdą z osób ze swojego otoczenia?','facebook',1,1,''),(8,'Robert','Cybulak','robert.cybulak@o2.pl','Gdyż, w tematyce relacji między ludzkich, czuję się jak przysłowiowa \" ryba w wodzie \" i chciałbym poszerzyć swoje horyzonty o profesjonalną wiedzę, co bardzo pomogłoby mi w rozwijaniu się w tej dziedzinie życia. ','Jak pozbyć się skutków problemu XXI wieku, jakim jest tzw. efekt \"YOLO\" - \" You only live online \", który dotyka dziś wielu młodych ludzi i w dużym stopniu upośledza ich kompetencje w relacjach międzyludzkich?. ','Jak duży wpływ na nasz światopogląd, wartości, którymi się kierujemy w życiu i czyny których dokonujemy, ma poziom naszej zamożności?.','Od koleżanki',1,1,''),(9,'Marta','Zwierzchowska','m.k.zwierzchowska@gmail.com','Studiuję organizację produkcji filmowej i telewizyjnej, w mojej pracy relacje międzyludzkie są niezwykle istotne, chciałabym się dowiedziec jak rozmawiac z ludźmi tak aby w ich świadomości funkcjonowac jako pewna siebie osoba, jednocześnie nie zatracając w tym siebie, i swojej wrażliwości. W przyszłości chciałabym zostac reżyserem, w tym zawodzie chyba najważniejsze jest połączenie umiejętności przywódczych z pracą na emocjach - stąd moje zainteresowanie organizowanym przez was spotkaniem. ','Czy dobry lider może byc introwertykiem? ','Jak rozmawiac z ludźmi żeby zostac w ich pamięci na dłużej?','od Martyna Kapitułka ',1,1,''),(10,'Martyna','Lewandowska','martyna_lewandowska@interia.pl','Jestem otwarta i ciekawa świata. Staram się dossonalić swoje umiejętności budowania i podtrzymywania zdrowych i owocnych relacji międzyludzkich. Wiem, że to spotkanie będzie dla mnie inspirujące! Wiem to również dlatego, ponieważ uczestniczyłam w wyjazdowej Kuźni Liderów i bardzo miło ją wspominam - wszystko co organizuje NZS jest warte uwagi i uczestnictwa.','Jak nauczyć się reagować w zgodzie ze sobą pomimo otaczajacych nas standardów, oczekiwań?','Jak sprawdzić, którzy ludzie do nas \'pasują\', a których lepiej \'usunąć\' ze swojego życia?','facebook',1,1,''),(11,'Adam','Rutkowski','a-rutkowski14@wp.pl','Czytałem blog Alexa. Chciałbym kupić na spotkaniu książkę po promocyjnej cenie. Szczególnie interesuje mnie jak nawiązywać i podtrzymywać relacje z ludźmi.','Czytałeś \"Outliers\" Malcolma Gladwella? (PL tytuł \"Poza schematem\") Czy zgadzasz się że to skąd pochodzimy ma ogromny wpływ na nasz sukces w życiu?','Czy byłeś trenerem personalnym kogoś znanego? Np. aktor, piosenkarz.','Koleżanka wysłała mi link na facebooku.',0,1,''),(12,'Mateusz','Deszyński','e.matdes@gmail.com','Ponieważ chciałbym wysłuchać głosu człowieka, któremu naprawdę zależy na nas młodych. Który to nie próbuje mieszać nam w głowach i realizować jakichś ukrytych celów. Chciałbym się uczyć od najlepszych, a za takiego uważam Alex\'a i chciałbym w przyszłości dać z siebie coś dla innych ludzi potrzebujących pomocy. Moje pytania do Alex\'a podparte by były osobistymi doświadczeniami.','W jaki sposób reagować na umniejszanie swoich dokonań/kompetencji przez swoich przełożonych?','W jaki sposób przepraszać za swoje błędy? ','Dowiedziałem się niedawno od swojego kolegi zajmującego się HR-em.',1,1,''),(13,'Gerard ','Stańczak','gerard.stanczak@gmail.com','Jeśli zależy wam na uczestnikach, którzy pragną się rozwijać, są aktywni i dążą do sukcesu, a tego typu wydarzenia traktują jako okazję do nauczenia się czegoś nowego i przydatnego w życiu osobistym i zawodowym, to będę właśnie takim uczestnikiem :)','Co uważasz za najważniejsze w wywieraniu dobrego pierwszego wrażenia?','Jakie są najczęstrze błędy popełniane w nawiązywaniu pozytywnych relacji międzyludzkich? ','Informacje w mediach uczelnianych',1,1,''),(14,'Bartosz','Świtoń','bartosz.switon@gmail.com','Interesuję się zarządzaniem ludźmi oraz projektem, ostatnimi czasy dokształcam się bo chciałbym działać i pomagać w zarządzaniu zasobami ludzkimi i projektami, interesuję się także projektami mediów alternatywnych, w których grupa ludzi działa ze sobą by stworzyć darmowe źródło rzetelnych informacji.\r\nMarzy mi się także otworzenie własnej firmy.','Jak zarządzać zespołem by uwzględnić potrzeby wszystkich uczestników?','Jak zacząć przygodę z biznesem i założeniem własnej firmy, od strony projektu ','od znajomych',1,1,''),(15,'Anna','Sałagacka','aniatonie@gmail.com','Studiuję na UŁ, mam masę niespożytej energii i chcę doskonalić swoje umiejętności oraz rozwijać zdolności komunikacyjne.','Jak nawiązać relacje z ciekawymi, ale nieznanymi nam ludźmi i - przede wszystkim - utrzymać je?','Co może pomóc nam realizować swoje cele?','Dziennikarskie Koło Naukowe Uniwersytetu Łódzkiego',0,1,''),(16,'Mateusz','Świąder','swiadermateusz@gmail.com','Zaszczyt uczestniczenia w szkoleniu powinien przypaść mnie z racji mojego nastawienia na osiągniecie sukcesu poprzez rozwój osobisty. Jedyne co posiadam, ale za to najcenniejsze to doświadczenie interpersonalne oraz obycie w świecie wszelakich zasad i norm, które ograniczają nas na co dzień. Pragnę również podnieść swoje umiejętności budowania i podtrzymywania relacji międzyludzkich w celu wykorzystania tych zdolności nie tylko na szczeblu prywatnym ale i zawodowym.','Czy w ogóle możliwe jest osiągnięcie pełni szczęścia życia prywatnego w sytuacji gdy brak znaczącego postępu w życiu zawodowym ','Gdy w głowie mamy wiele wątpliwości nt, naszego obecnego trybu pracy, wynagrodzenia czy najważniejszego, samopoczucia i swojej samooceny, czy możliwe jest osiągnięcie sukcesu z tak bogatym bagażem doświadczeń?','Od znajomego, oraz z mediów społecznościowych',1,1,''),(17,'Monika','Miłosz','monikamilosz89@gmail.com','ciekawe spotkanie na ktorym chcialabym uczstniczyc ... ','w jaki sposob rozmawiac by uzyskac satysfakcje z rozmowy? ','w jaki sposob rozmawiac by zanteresowac soba innych? ','z NZSu',1,1,''),(18,'Patrycja','Plesiak','ppdesign-management@wp.pl','Ponieważ, jestem ambitną studentką, która odnalazła swoją pasję, dokładnie wie co chce robić w życiu i stara się do tego dążyć. Otworzyłam własną firmę i mam plan na to jak sprawić, aby osiągnęła sukces, ale po wielu sytuacjach, które \"przycięły mi skrzydła\" zablokowałam się w pewien sposób i chciałabym uwolnić na nowo potencjał jaki we mnie żyje i czerpać z niego garściami.  Mam nadzieję, że to spotkanie będzie krokiem do uwolnienia go i możliwością nauczenia się bezgranicznej wiary we własnej możliwości.','Jaka cecha jest najbardziej ceniona i pomocna dla osób chcących osiągnąć sukces w biznesie? ','Jak nauczyć się czerpania z bogactwa własnego potencjału i nie pozwolić nikomu i niczemu zablokować drogi do jego źródeł.?','ze strony szkolenia.ngo.pl',1,1,''),(19,'Katarzyna','Kamińska','kasia-kaminska91@wp.pl','bo jestem baaardzo zainteresowana tematyką spotkania i wykorzystam wyniesioną wiedzę w stu procentach!','Czemu tak trudno jest nam nawiązywać relacje z (ciekawymi) ludźmi? Czy to kwestia cech charakteru, osobowości?','Jak we właściwy sposób zachowywać swoją niezależność, by nie przekroczyć granicy egoizmu etc.?','od znajomych',1,1,''),(20,'Robert','Zadzimski','bercikzdwola@gmail.com','Bo mogę wszystko.\r\nA chcę tylko niektórych rzeczy, np. chcę posłuchać Alexa.','Dlaczego sugeruje się, by realizować piramidę Maslowa poprzez wspinanie się na nią z poziomu ziemi? Czym grozi celowanie od razu w wierzchołek piramidy, niczym zesłaniec z niebios ? Ostateczne spełnienie życia to samorealizacja, reszta poziomów to tylko egzystencja.','Czy w społecznej banicji człowiek może się skutecznie rozwijać i samorealizować ?','e-mail od NZS',1,1,''),(21,'Konstancja','Barnaś','k.barnas@op.pl','Jestem bardzo ambitną, kreatywną, pomysłową i myślącą nieszablonowo studentką. Pragnę się rozwijać i iść ciągle w obranym przez siebie kierunku, czyli w stronę własnego rozwoju i sukcesu, nawet jeśli oznacza to płynięcie pod prąd. Jedynym moim problemem (choć zamiast słowa problem, wolę słowo wyzwanie) są relacje międzyludzkie. Zatem z wielką chęcią podejmuję się tego wyzwania, gdy tylko jest to możliwe i staram się pracować nad moimi relacjami. Wierzę, że udział w tym szkoleniu pomoże mi w nawiązywaniu i utrzymywaniu relacji z ciekawymi ludźmi i dzięki temu będzie kolejnym krokiem milowym na drodze mojego sukcesu.','Co spowodowało, że w 1981 roku odważył się Pan wyjechać z kraju zabierając ze sobą jedynie 100 dolarów?','Co sprawiło, że nie stał się Pan szarym, przeciętnym człowiekiem pracującym w korporacji na etacie od 8:00 do 16:00?','Brałam udział w ostatniej edycji',1,1,''),(22,'Mateusz','Słonecki','slomka0308@gmail.com','Zostanę niedługo absolwentem wydziału Filologicznego UŁ. W bliskiej perspektywie życiowej pojawia się bezrobocie, albo mało interesująca praca. Być może coaching jest rozwiązaniem dla mnie.','Czy coaching jest tylko dla psychologów ? Jeśli nie, to dlaczego ?','Jaką rolę coaching odgrywa w świecie sportu ? ','www',0,1,''),(23,'Aleksandra','Uznańska','aleksandrauznanska@icloud.com','Powinniście wybrać mnie ponieważ psychologia to dziedzina która jest moim hobby chciałabym poszerzyć swoja wiedzę byłby to cudowny spóźniony prezent urodzinowy ;)','Czy poruszony bedzie temat technik NLP? ','Czy bedzie to jednorazowe spotkanie ?','O Kuźni Liderów wiem od dawna z internetu',1,1,''),(25,'Karol','Tomaszewski','karol.stc@gmail.com','Bo będę słuchał i zadawał ciekawe pytania :)','Czy bycie bardzo pewnym siebie jest w polskim społeczenstwie źle odbierane?',' Jak to wpływa na relacje z osobami nieśmiałymi z brakiem poczucia własnej wartosci. ','Działałem kiedyś w NZS',0,1,''),(26,'Beata','Komańska','beata.komanska@gmail.com','Szkolenie to jest dla mnie niezbędne (ponieważ chciałabym polepszyć swoje umiejętności pracy w grupie) poza tym, chciałabym poznać odpowiedzi na zadane przeze mnie pytania oraz chciałabym poznać i porozmawiać z osobami tworzącymi projekt Kuźnia Liderów. Serdecznie pozdrawiam- Beata','Jak pozbyć się \"pasożytów\" w zespole? (gdy podział grup jest narzucony)','W jaki sposób pobudzać zespół do kreatywnego działania? (oprócz metod heurystycznych)','facebook',1,1,''),(27,'Aneta','Banasiak','aneta_1986@o2.pl','Dzięki temu spotkaniu moje relacje innymi będą lepsze niż obecnie są. ','Co robić aby utrzymywać trwałe relacje z drugim człowiekiem?','Jak przekonać drugiego człowiek do mojego zdania?','Facebook',1,1,''),(28,'Ewelina','Balcerzak','ebeluszka@wp.pl','Chciałabym poszerzyć swoją wiedzę na temat rozwoju osobistego, który w bardzo dużym stopniu wspiera karierę zawodową. Interesuje mnie również możliwość poznania środowisk, które nas otaczają i są ważne dla realizacji naszych planów. Poza tym ciekawy jest dla mnie temat relacji międzyludzkich, który będzie przedstawiony z punktu widzenia profesjonalisty. Być może to spotkanie stanie się moim pierwszym krokiem do \"osiągnięcia sukcesu w relacjach międzyludzkich\".','Od czego rozpocząć swój rozwój osobisty?','Jak bronić niezależności swojego zdania, bez wdawania się w konflikty?',NULL,1,1,''),(29,'Katarzyna ','Kałdońska','kaldonska.kasia@wp.pl','Ponieważ chciałabym poszerzyć wiedzę na temat kontaktów interpersonalnych, a także  dowiedzieć się jak budować i podtrzymywać relacje , które pozwolą mi osiągnąć zadowolenie w życiu. Jestem niezmiernie ciekawa jak osoba kompetentna w tym zakresie prezentuje wiedzę i umiejętności praktyczne odnoszące się do relacji. Tego typu spotkanie na pewno zmotywuje mnie do pracy nad komunikacją, a być może  to w własnie dzięki temu spotkaniu osiągnę życiowy sukces. ','Czy umiejętność budowania relacji interpersonalnych jest ważniejszym czynnikiem niż poziom zdobytej wiedzy na drodze do sukcesu ?','Jak podtrzymywać kontakty interpersonalne i nie zrazić do siebie innych ludzi ?','Od koleżanki, która także wysłała formularz.',1,1,''),(30,'Justyna ','Grzesiak ','justyna.grzesiak@op.pl','Ponieważ jako praktykująca absolwentka prawa chciałabym zweryfikować swoje spostrzeżenia dotyczące pewnych powtarzalnych zachowań ludzkich, które z jednej strony jednym pozwalają na nieustanne osiągnie sukcesów i awansów, podczas gdy z drugiej innym nie pozwalają ruszyć się z miejsca pomimo posiadania takich samych kwalifikacji, co zapewne wynika z posiadania lub braku \"tego czegoś wewnętrznego\", co jest obecnie przedmiotem wielu interesujących szkoleń, jak również tematów poruszanych w literaturze typu jak osiągnąć sukces, jak mieć wpływ na innych, jak być asertywnym itd. ','Czy kwestia odpowiedniego nastawienia i podejścia do danej osoby w danej chwili może mieć w zasadzie zawsze pozytywny wpływ na osiągnięcie założonego celu? (np. wybranie mnie spośród grona potencjalnych pracowników, uzyskanie podwyżki, awansu. dobrego wyniku pracy w danym dniu)','Czy istnieją takie techniki manipulacji działające na praktycznie każdego człowieka, że wraz z ich zastosowaniem zawsze jesteśmy w stanie osiągnąć założony cel? ','Dowiedziałam się wchodząć na stronę WPiA',1,1,''),(31,'Kamila ','Surowiecka','kamilka_mila@poczta.onet.pl','chcę poszerzyć swoje umiejętność','Jak skutecznie przekonać ludzi do swoich racji ','Jak być lubianym ','z internetu',1,1,''),(32,'Ireneusz','Skrońc','i.skronc@gmail.com','Byłaby to niezmierna przyjemność spotkać się i móc obcować z Alexem twarzą w twarz z perspektywy wiernego od lat czytelnika jego bloga. Ciekawym byłoby zobaczenie jak radzi sobie w praktyce – w jaki sposób radzi sobie w praktyce oraz jak łatwo obnaża osobiste słabości, dając tym samym powód do przemyśleń, a następnie – poprzez wyciągnięte wnioski – bodziec do pracy nad sobą i ciągłego doskonalenia. Ze względu na wartość Alexa biorąc pod uwagę jego osobę i doświadczenie, jest to wydarzenie, którego nie można ominąć.','W jaki sposób młoda osoba, bez większego doświadczenia, może \"wychylać się\" zdobywając wartościowe kontakty oraz jakie techniki mogą okazać się pomocne przy ich nawiązywaniu i późniejszym podtrzymywaniu?','Czego można oczekiwać od takich kontaktów? W jaki sposób się do nich dobrze przygotować?','Aktualności strony wydziałowej wpia.uni.lodz.pl',1,1,''),(34,'Ewelina','Kominak','ewelina.kominiak@wp.pl','Usłyszałam kilka razy o p. Alexie, zaglądałam na jego bloga, przymierzałam się nawet do kupna jego książki, a okazuje się, że mogę go nawet spotkać osobiście i porozmawiać krótko, to byłoby dla mnie ważne wydarzenie. Pan Alex jest trenerem i coachem, czyli idzie tą ścieżką, którą i ja w przyszlości chciałabym kroczyć, gdyż dostrzegam ogromne znaczenie w świadomym kierowaniu rozwoju osobistym i zawodowym.','Dlaczego nie wszyscy skazani są na sukces?','Jak działać, żeby zadziałać? Aby było widać wymierne efekty naszych starań?','Z facebooka',0,1,''),(35,'Marcin','Stachowicz','stachowicz.marcin@yahoo.com','Ponieważ od kilku lat prowadzę projekty w małych i średnich grupach osobowych i moim celem w życiu jest znalezienie i rozwinięcie najlepszej części samego siebie oraz spowodowanie, że moje kontakty z innymi ludźmi będą całkowicie naturalne i pozbawione jakiegokolwiek stresu.','Jak zmotywować się do rozwijania trenowanych umiejętności w praktyce, tj. w kontakcie z poznawanymi ludźmi?','Jaki jest najlepszy sposób doskonalenia swoich umiejętności (zapisywanie przemyśleń, spontaniczny trening z innymi ludźmi, itd.)?','Samorząd Studencki PŁ',1,1,''),(36,'Paulina','Brożek','paulinabrozek2621@gmail.com','Jestem studentką kierunku Zarządzanie Zasobami Ludzkimi., więc tematyka jest mi niezwykle bliska. Ponadto, jestem prezesem Studenckiego Koła Naukowego Zarządzania Personelem PERSONALNI. Pragnę pogłębić wiedzę dotyczącą relacji międzyludzkich, aby efektywniej zarządzać kołem oraz  aby osiągnąć sukces zawodowy w przyszłości. Uważam również, że taka wiedza ułatwi mi kontakty na stopie prywatnej.Jestem wielką fanka pana Aleksa, więc myślę, że będzie to dobrze wykorzystany czas! ','Jak efektywnie budować relacje międzyludzkie w środowisku wielokulturowym?','Jak się odnaleść w gronie osób bardziej doświadczonych i usytuowanych w hierarchi firmy, szkoły itp.?','od znajomej',1,1,''),(37,'Elżbieta ','Łakoma','haletu@vp.pl','Zdobytą na szkoleniu wiedzę na pewno wykorzystam w życiu zawodowym i prywatnym. Natomiast książka Pana Alexa Barszczewskiego z pewnością dołączy do mojego zbioru \"lektur obowiązkowych\".   ','Jak rozpoznać wampira energetycznego i poradzić sobie z negatywnymi skutkami jego działania?','Jak skutecznie motywować do działania siebie oraz innych?','www.eksoc.uni.lodz.pl',1,1,''),(38,'Paweł','Kucejko','kucejko.pawel@gmail.com','Żywo interesuję się tematyką skutecznej i nieantagonizującej komunikacji w stosunkach międzyludzkich. W dzisiejszych czasach umiejętność kontaktu z drugim człowiekiem jest niezbędna w stosunkach biznesowych. Chętnie wezmę udział w praktycznych warsztatach dających możliwość uczenia się od najlepszych praktyków. Jestem osobą energiczną i ambitną. Z mojej strony można liczyć na aktywny udział i owocny wkład w przebieg szkolenia.','W jaki sposób uzyskać informację do jakiej pracy jesteśmy predestynowani?','Skuteczny sposób na zwalczenie złych nawyków i niechcianych odruchów?','strona internetowa wpia',1,1,''),(39,'Julia','Zimnicka','julia.zimnicka@gmail.com','Jestem zainteresowana tematyką spotkania - chcę dowiedzieć się ciekawych rzeczy o rozwoju osobistym i o \"zarządzaniu\" swoim życiem.','Jak wyznaczać sobie cele życiowe, aby łatwiej przyszło nam ich osiągnięcie?','Jak się motywować do pracy, nauki?','Z Facebooka',1,1,''),(40,'Agnieszka','Sroka','agnieszka.sroka09@gmail.com','Jestem osobą nieśmiałą, która ostrożnie nawiązuje kontakty, stąd bardzo chciałabym zdobyć wiedzę z obszaru relacji międzyludzkich. Spotkanie z Panem Alexem, z pewnością pomogło by mi w budowaniu mojego wizerunku na polu zawodowym i prywatnym.','Czy możemy nauczyć się pewności siebie poprzez odpowiednie warsztaty?','Jakie zachowania niewerbalne, mogą negatywnie wpłynąć na nasz wizerunek w czasie rozmowy kwalifikacyjnej?','Z internetu',1,1,''),(41,'Paweł','Banul','tiklol@o2.pl','Jako wieczny lider wśród rówieśników niewątpliwie jestem w stanie jeszcze polepszyć swoje umiejętności. A zawsze lepiej ulepszać by stworzyć ideał, niż budować od początku.','Jak ujarzmić w grupie osoby rywalizujące między sobą o prymat?','Kto może mnie pomóc w polepszeniu sztuki retoryki?','z internetu',0,1,''),(42,'Magdalena','Pabiańśka','magda21p@poczta.onet.pl','Jestem studentką V roku andragogiki i po zakończeniu studiów magisterskich planuję podjąć studia podyplomowe w zakrecie coachingu na jednej z dwóch warszawskich uczelni. Wzięcie udziału w tym wykładzie było by ogromnym zaszczytem i krokiem w nowy etap edukacji. :)','Czy mieć więcej to zawsze dać z siebie więcej?','Wykształcenie czy doświadczenie? ','facebook',1,1,''),(43,'Dominik','Tama','dominik.tama@wp.pl','Brałem udział w Kuźni Liderów, jestem zainteresowany tematyką szkolenia,  staram się być na bieżąco, jestem ciekawy inicjatyw podejmowanych przez NZS. ','Czy firmy, w których prowadzi Pan szkolenia stosują następujące rozwiązanie: jest osoba zdolna i posiadająca szerokie umiejętności i chęci do poszerzania swej wiedzy, znająca języki obce  = ma szansę na zatrudnienie także na stanowisku nie związanym z jej wykształceniem kierunkowym lub firma ją na własne potrzeby dokształca/przekształca na pożądane dla firmy stanowisko?','Czym osoba powinna się wyróżniać, czym powinien zaskoczyć , by przyszły pracodawca wybrał akurat tę osobę spośród innych?','Z sieci (strony internetowej NZS Łódź).',1,1,'Dominik rozwija się pode mną w sekcji IT, więc z mojej strony akcept :)'),(44,'Małgorzata ','Pagieła','gosia3@interia.eu','Ponieważ,mam problem  z wystąpieniami publicznymi a będę brała udział w wyborach na radnych. Na  co powinnam zwrócić uwagę,co zmienić w sobie.','czy po takim spotkaniu,będę wiedzieć co powinnam zmienic w sobie?','Czy takie  szkolenie  poprawi mi wizji mojej drogi życia?','internet',1,1,''),(45,'Emil','Pytka','emilpytka@gmail.com','Pasjonuje się zagadnieniami z rozwoju osobistego od kilku dobrych lat. Pana Alexa znam między innymi z jego bloga alexba.eu, gdzie często porusza bardzo ciekawe tematy. Zawsze chciałem poznać go na żywo, dlatego mam nadzieję, że będę miał możliwość go spotkać już 7 maja :) ','Jak wydobyć się z wyścigu szczurów i co zrobić aby móc się utrzymać i rozwijać własny biznes?','Czy warto utrzymywać dobre relacje ze wszystkimi czy lepiej utrzymywać głębsze relacje z wybranymi osobami?','Z plakatu, który zobaczyłem idąc na zajęcia.',1,1,'szef sekcji .NET koła informatyków na FTIMSie. Good Job, plakatowanie :)'),(46,'Krzysztof','Nowak','nowack818@gmail.com','Jestem założycielem i wiceprezesem Stowarzyszenia Akademickie Forum Biznesu, które ma na celu łączenie świata nauki ze światem biznesu. Chcemy pokazywać studentom możliwe drogi rozwoju i kariery przygotować na ten moment gdy będziemy musieli \'porzucić ławki szkolne\' i zderzyć się z dorosłym życiem. Ponadto od 14 miesięcy działam w MLM. Bardzo przyda mi się ten kurs.','Jak skutecznie przekonać drugiego człowieka do swojej racji, poglądów?','W jaki sposób radzić sobie z drobnymi niepowodzeniami i porażkami?','od NZS Regionu Łódzkiego',0,1,''),(47,'Agnieszka ','Subczyńska','asubczynska@wp.pl','Temat pokrywa się z moimi zainteresowaniami i kierunkiem studiów. ','1','2','NZS',0,1,''),(48,'Jakub','Soborski','soborski.jakub@outlook.com','Bo w końcu się zmotywowałem żeby wypełnić to zgłoszenie :P','Jak nawiązywać i utrzymywać relacje z osobami,  które w przyszłości mogą nam się \"przydać\" w rozwijaniu kariery zawodowej.','Gdzie znajdował Pan motywację i inspirację do rozwijania swojej kariery oraz spełniania marzeń zawodowych. Ile pracy i czasu musiał Pan poświęcać na realizację swoich celów.','Bo ja wiem wszystko.',1,1,''),(49,'Ewelina ','Rykała','arletka06@op.pl','Jestem osobą, która lubi ludzi. Myślę że przyszedł czas na rozszerzenie wiedzy na temat relacji interpersonalnych oraz na ukształtowanie zdolności przywódczych, zwłaszcza  dlatego że jako przyszły prawnik powinnam rozumieć ludzi aby efektywnie im pomagać.','W jaki sposób dążyć do wyznaczonych celów gdy pojawiają się komplikacje ?','Jak zjednywać sobie ludzi?','NZS Regionu Łódzkiego',1,1,''),(50,'Jakub','Koszewski','mckosa@gmail.com','A dlaczego mielibyście mnie nie wybrać ?','Czy gdyby mógł Pan cofnąć czas, zdecydowałby się Pan na tą samą ścieżkę kariery, czy może widziałby się Pan gdzieś indziej ?','Czy wśród ludzi z Polski coaching cieszy się dużym zainteresowaniem ?','NZS',0,1,''),(51,'Michał','Moroz','michalmoroz@gmail.com','Komunikacja interpersonalna i bycie `ciekawym i angażującym\' dla innych ludzi jest dla mnie koniecznym wymaganiem, żeby móc przyciągać ludzi do organizacji takiej jak Niezależne Zrzeszenie Studentów Regionu Łódzkiego. Jestem świadom, że jest to najmniej rozwinięta część mojej osobowości, dlatego też skuteczne trenowanie tego fragmentu spowoduje dużą zmianę w krótkim czasie w moim otoczeniu.','Emocje w komunikacji w grupie - w jaki sposób nie podążać za nastrojem otoczenia i jak nauczyć się zmieniać ten nastrój na lepszy w naturalny sposób bez działania na siłę? Czym i jakimi narzędziami można się tu posługiwać?','Utrzymywanie kontaktów - ile czasu na to poświęcasz, jak często i bardzo angażujesz się w utrzymywanie sieci kontaktów z ciekawymi dla Ciebie osobami? W jaki sposób balansujesz sobie to w życiu z innymi aktywnościami, które wykonujesz?',':)',1,1,''),(52,'Maciej','Kossowski','fotowujekkosa@gmail.com','Mój pomysł na biznes może dać światu nowe spojrzenie na jego własne problemy, chciałbym posłuchać kogoś takiego jak Alex, by po poznać Człowieka który umie panować nad sukcesem.','Ludzie często pragną sukcesu jak chleba, lecz co kiedy sukces zaczyna przeszkadzać? Jak znaleźć własną granicę?','Często gdy ludzie osiągną klęskę nie potrafią z sobą zrobić nic dobrego, jak się podnosić?','od Michała Moroza',1,1,''),(53,'Tamer','KHAROUB','tkharoub@gmail.com','takie niesamowite umietnosci, kazdego mozna uczyc. Tylko liderem kazdy nie jest. ','Jak przyjąc rolę nad innymi głosami w głab siebie ?','Jak przyjąć kontrolę nad przekonaniami i emocjami, i udzielić nowe wydarzenie od wczesniejszych doświadczeń!','NZS -internet',1,1,''),(54,'Konrad','Sodol','konradzrw@gmail.com','Przez całe życie próbowałem różnych rzeczy jak studia czy własna firma. Większość ludzi na studiach kieruje się na bycie specjalistą, jest to jakaś z opcji, Jednak póki jesteś specjalistą i masz pracę to jesteś kimś, lecz kim będziesz jeżeli tej pracy nie będzie? Zamykać drogę zdobywania wiedzy można sobie, ale nieładnie jest to robić innym.','Za Napoleona Hilla sprzedaż opierała się na relacjach, następnie przesunęła się w strone metod z NLP, jaki w ciagu najbliższych 5 lat może być model sprzedaży oraz w którym kierunku będzie to podążało. ','Od czego zacząć i jak podążać, przez jakie kolejne \"stacje\", aby ukształtować w sobie na nowo pozytywne odruchy międzyludzkie? ','Z internetu',1,1,''),(55,'Rafał','Borzym ','rborzym@gmail.com','Interesują mnie relacje miedzyludzkie','Jakie pytanie','tez','facebook',1,0,''),(56,'Rafał','Kołomański','rafal.kolomanski@onet.pl','Interesuję się tematyką relacji międzyludzkich od wielu lat, wykorzystuje ją w codziennej pracy oraz stosunkach z innymi. Czytałem wiele książek oraz uczestniczyłem w szkoleniach z zakresu negocjacji, wywierania wpływu i marketingu. Po ukończeniu studiów prawniczych ta wiedza będzie dla mnie przydatna w karierze zawodowej dlatego chcę dalej rozwijać swoje umiejętności w tym zakresie. ','Dlaczego Pana zdaniem wiedza z zakresu chociażby umiejętności negocjacji, relacji międzyludzkich czy perswazji jest wciąż pomijana w stadardowej edukacji w Polsce mimo, iż większość pracodawców wymaga takiej wiedzy do zajmowania wyżyszch stanowisk oraz jest ona często niezbędna do skutecznego prowadzenia własnej działalności ? ','Jakie ksiązki/warsztaty/szkolenia moze Pan polecić osobom zainteresowanym tematyką biznesu/stosunków międzyludzkich/perswazji itp. ? ','Z plakatu na uczelni.',1,1,''),(57,'Jerzy','Buczyński','jerzy.buczynski@gmail.com','Jestem młodym, dynamicznym przedsiębiorcą. Rozwijam łódzką kulturę i płacę łódzkie podatki. Dzięki wiedzy z tego spotkanie będę mógł robić to lepiej.','Jaki był Pana największy sukces zawodowy - Pana zdaniem - i dlaczego akurat ten?','Czy Pana największe sukcesy mieściły się w ramach celów, które Pan sobie wcześniej postawił?','z internetu',1,1,''),(58,'Adrianna','Piekuś','adrianna.piekus@wp.pl','Chciałabym pracować w międzynarodowej firmie HR. Interesują mnie tematy związane z komunikacją interpersonalną. Czytam książki o takich charakterze, min. \'Getting thingd done\' Allen\'a.','Co zrobić by nie zabłądzić w drodze do celu, jak się go trzymać i nie puszczać?','Jak ćwiczyć asertywność?','facebook',1,1,''),(59,'Małgorzata','Baranowska','malgorzata.baranowska07@gmail.com',':*','Jak oczarować sobą drugą osobę, np. pracodawcę podczas rozmowy kwalifikacyjnej?','Jak w bardziej efektywny sposób pracować nad swoimi wadami, złymi nawykami?',NULL,1,1,''),(60,'Krzysztof','Polipowski','kontakt@krzysztofpolipowski.pl','Od lat pasjonuję się zagadnieniami zarządzania, przywództwa, od lat próbuję też zmieniać otaczającą mnie rzeczywistość, by była lepsza :-) \r\nNiezależnie prezentowana wiedza jest dla mnie niezmiernie ważna, jako osoby chcącej zatrudniać w przyszłości licznych specjalistów różnych branż. \r\nPoszukuję rozwiązań, inspiracji, pasji i wiedzy. \r\nStaram się też dawać innym jak najwięcej z siebie. \r\nWierzę, że moje uzasadnienie wystarczy, aby móc uczestniczyć w organizowanym przez Państwa wydarzeniu :-) \r\nPozdrawiam serdecznie :-)','Jak budować efektywne zespoły nie mogąc osób zatrudnić na etacie, gdy możliwa jest tylko współrpaca na zasadach prowizyjnych lub organizowanie praktyk dla studentów?','Jak w praktyce inspirować ludzi? Do bycia lepszym człowiekiem, skuteczniejszym specjalistą, osobą efektywniejszą, ale też bardziej uśmiechniętą i pogodną?','Z Akademickich Inkubatorów Przedsiębiorczości',1,1,''),(61,'Justyna','Stanowska','justyna2500@wp.pl','Interesuję się psychologią biznesu, ponadto chciałabym poszerzyć swoją wiedzę z komunikacji społecznej. Studiuję matematykę stosowaną na PŁ, więc niestety nie mam możliwości uczestniczenia w tego typu kursach, a uważam je za bardzo praktyczne. Wiedzy zdobytej na tym spotkaniu na pewno nie zaprzepaszczę!\r\n Pozdrawiam!','Interesuję się psychologią biznesu, ponadto chciałabym poszerzyć swoją wiedzę z komunikacji społecznej. Studiuję matematykę stosowaną na PŁ, więc niestety nie mam możliwości uczestniczenia w tego typu kursach, a uważam je za bardzo praktyczne. Wiedzy zdobytej na tym spotkaniu na pewno nie zaprzepaszczę!  Pozdrawiam serdecznie!','Regularnie czytam magazyn Coaching, a tam często pojawiają się wzmianki o Kuźni Liderów. ','Regularnie czytam magazyn Coaching, a tam często pojawiają się wzmianki o Kuźni Liderów. ',1,1,''),(62,'AGNIESZKA','CZARNOJAN','agnieszka.czarnojan@gmail.com','Kontakt z ludźmi jest dla mnie bardzo ważny, a każde nowe spotkanie staje się inspirujące i wartościowe. Wybrałam studia socjologiczne nieprzypadkowo, interesuje mnie to, co ludzie mają do powiedzenia i jak oddziałują względem otoczenia. Komunikacja i relacje międzyludzkie mają duże znaczenie w życiu codziennym. Chcę się rozwijać i w jakimś stopniu wiążę swoją przyszłość z pracą coucha. Chcę uczyć się od najlepszych. Już cztery lata działam w międzynarodowej organizacji non-profit, wspierając mobilność studencką i rozwój, więc zdobytą wiedzę ze szkolenia mogę przekazywać dalej, niosąc za sobą pozytywną zmianę.','Jak zostać dobrym couchem? Od czego zacząć? (8 wskazówek na start do kariery)','Co jest sukcesem w relacjach międzyludzkich?','Dowiedziałam się o Kuźni Liderów, dzięki portalowi Młodzi w Łodzi.',1,1,''),(63,'Stanisław','Lipiński','lipinski123@gmail.com','Od zawsze zastanawiałem się pomiędzy studiami filmowymi, a marketingiem, ponieważ były to moje pasje.\r\nWybrałem marketing, a na ostatnim roku studiów, pół roku temu założyłem agencje videomarketingową. Jak nigdy wcześniej potrzebuje drogowskazu i motywacji- bo od chwili rozpoczęcia działalności sam odpowiadam za siebie i współpracowników, przyjmując niezwykle odpowiedzialną, ale i inspirującą pracę.','Jaką przyjąć strategię, aby dotrzeć do najważniejszych decyzyjnych osób w firmie ze swoją ofertą i mieć więcej niż 5 minut czasu?','Banalne pytanie, ale od czego zaczynać rozmowę na spotkaniach branżowych, konferencjach itp? ','facebook',1,1,''),(64,'Adam','Bobrowski','bobrowski.adamo@gmail.com','Jestem osobą, która postanowiła przełamać swoje bariery, wyjść ze swojej strefy komfortu i rozpocząć nowy etap w życiu. Chcę osiągnąć wielkie rzeczy, a przy tym wiele się nauczyć i dobrze się bawić. Od niedawna interesuję się tematyką samorozwoju oraz rozwoju osobistego, także uczestnictwo w takim szkoleniu byłoby dla mnie niesamowitym doświadczeniem :)','Przez cały okres bycia coachem, jaką najciekawszą i największą przemianę zaobserwował pan w swoim podopiecznym?','Co spowodowało, że zdecydował się Pan na tę ścieżkę życiową? Czy spowodowane to było jakimś konkretnym zdarzeniem, które popchnęło pana do bycia mentorem i coachem?','od znajomych',1,1,''),(65,'Katarzyna','Chrząszcz','k-chrzaszcz@wp.pl','Chciałabym wziąć udział w szkoleniu, jako, że pomaga ono zdobyć konkretne umiejętności \"miękkie\". Jest więc bardzo dobrym i pożądanym uzupełnieniem do wiedzy zdobywanej na studiach.','W jakim stopniu zawdzięcza Pan swój sukces zawodowy i osobisty dobrej znajomości zasad kierujących relacjami międzyludzkimi?','Nad którymi cechami charakteru czy osobowości powinny wg Pana szczególnie pracować osoby młode (np. studenci), aby osiągnąć sukces w życiu zawodowym?','Od znajomych działających w NZS. ',0,1,''),(66,'Bartłomiej','Petera','bpetera@gmail.com','Ponieważ bardzo chcę być na tym spotkaniu! Tytuł wystąpienia jest identyczny z tytułem promowanej książki – zajrzałem więc do karty informacyjnej „Dla Kogo”. Profil odbiorcy książki jest zbieżny z moją osobą. Jestem studentem 3-go roku logistyki na Politechnice Łódzkiej i czuję, że to dobry moment aby doskonalić coś więcej niż rozwijane obecnie twarde, wyuczane umiejętności. Jako przyszły manager, osoba pracująca z ludźmi szukam źródła wiedzy i umiejętności, które pomogą mi w sprawnej komunikacji. ','W jaki sposób radzić współpracownikom nie dając im poczucia krytyki?','Jak ograniczać presję otoczenia (grupy ludzi, współpracowników) na nasze zachowanie, decyzje, zdanie by nie odchodzić od własnych założeń?','Poinformował mnie plakat na uczelni.',1,1,''),(67,'Justyna','Wal','justyna.wal.94@gmail.com','Chciałabym wziąć udział w spotkaniu prowadzonym przez pana Alexa Barszczewskiego.','Jak osiągnąć sukces w życiu?','Skąd czerpać motywację do osiągania wyznaczonych sobie celów?','z Internetu',1,1,''),(68,'Justyna ','Wójcikowska','justyna_wojcikowska@onet.eu','Interesuję się coachingiem, psychologia, psychoterapią, dlatego ten warsztat jest dla mnie','Jakie są warunki satysfakcjonującyhc relacji z innymi ludźmi?','Co przyczyniło się do coraz większej popularności coachingu?','internet',0,1,''),(69,'Marcin','Orczykowski','martin.orczykowski@gmail.com','Każdego przyszłego lidera powinno charakteryzować ciągłe dążenie do niedoścignionej doskonałości, czego kolejną możliwością jest dla mnie to szkolenie. Stawiam na rozwój i ulepszanie siebie. Bo żeby wymagać od innych, trzeba najpierw wymagać od siebie.','Jak stać się dobrym liderem? ','Jak zmotywować innych do działania? ','Z Akademickiego Biura Karier umed',0,1,''),(70,'Kamil','Bąk','kamilbak@gmail.com','Bo nie jestem przeciętnym studentem. Od skończenia technikum stale pracowałem studiując i jednocześnie będąc prezesem koła naukowego Stratos oraz czynnym członkiem oraz koordynatorem konferencji w kole naukowym IM-Tech. Obecnie po za studiowaniem, stałą pracą w agencji jestem freelancerem zakładającym własną agencje. Najprawdopodobniej dużo lepiej wykorzystam wiedzę zdobytą na Kuźni od przeciętnej osoby','Jak skutecznie pozyskać klientów (bez kontaktu) w branży internetowej jako freelancer?','Jak utrzymać stałe relacje z współpracownikami i jak skutecznie wybrać osoby do współpracy w tworzeniu agencji?','od znajomych',1,1,''),(71,'Ilona','Marusik','ilonamarusik@gmail.com','jest to proste jestem liderem.  przez całe studia aktywnie działałam w organizacji studenckiej, organizowałam wiele eventów. byłam również prezesem tej organizacji. wcześniej przez dwie kadencje pełniłam funkcję viceprezesa do spraw finansów. nabyłam wtedy bardzo wiele umiejętności dzięki którym byłam coraz lepszym liderem. uczestniczyłam w wielu szkoleniach dlatego patrzę teraz na nie trochę inaczej niż zwykły student. ważny jest sam prelegent i to co powie. wasze szkolenia są na wysokim poziomie i myślę, że mogłabym z nich wyciągnąć coś czego jeszcze nie wiem. ','jak wykorzystywać crowdsourcing w działalności firmy czy może on tak zmniejszyć nasze koszty aby dane środki przesunąć np. na większą reklamę produktu','jak dobierać swoich współpracowników i kiedy ufać im na tyle, aby powoli zacząć opuszczać firmę i dawać im więcej swobody','od mojego chłopaka',1,1,''),(72,'Basia','Kubicka','kubicka.basia@gmail.com','Natchniona spotkaniem z Aleksem oraz jego ksiązką, postanowiłam rzucić pracę i zacząć przygodę z eksperymentowaniem ;) To spotkanie da mi możliwość zadania nurtujących mnie pytań związanych z moimi ekseprymentami :) ','Uczymy się jak zadawać pytania innym w celu uzyskiwania ważnych dla nas informacji. Jakie pytania warto zadawać sobie, aby dowiedzieć się jakiej informacji tak na prawdę poszukujemy?? ','Jakie kluczowe przekonania nt. zycia/pieniedzy/siebie zmieniłeś, które spowodowały że zmieniło się też Twoje życie??','z bloga Alexa',0,1,''),(73,'Marta ','Majewska','majewskamarta@onet.pl','Bo chcę odnaleźć w sobie dziecko ;) ','Dlaczego ludzie tak dziwne czyli z podejrzliwością, ostrożnością reagują na pozytywne emocje?  ','Czy wahania nastrojów są nam tak naprawdę potrzebne?','Od znajomych ',1,1,''),(74,'Karolina','Feder','karolinafeder@wp.pl','Ponieważ interesuje mnie tematyka spotkania i myślę, że wiedza na nim zdobyta przyda mi się w przyszłości.','Jak dokonać dobrej autoprezentacji?','Co zrobić, aby osiągać sukces w wystąpieniach publicznych?','Dostałam wiadomość z koła naukowego',1,1,''),(75,'Ewa ','Kacprzyk','ewa_kacprzyk@onet.eu','Posiadam gruntowne wykształcenie humanistyczne, jednak chciałabym odnieść sukces w nawiązywaniu relacji interpersonalnych. Moje życie jako aktywistki społecznej jest bogate, jednak zawsze warto zdobywać nowe doświadczenia.','Największe problemy młodych ludzi w podjęciu decyzji o aktywnym życiu społecznym?','Jak ocenia Pan przedsiębiorczość ludzi urodzonych po 1989 r. na tle osób starszych od nich?','Internet',1,1,''),(76,'Konrad','Pawlik','pawlik.konrad@gmail.com','Ponieważ w przyszłości chciałbym pracować w zespole menedżerskim, i chciałbym się dowiedzieć więcej na ten temat.','Jak osiągnąć sukces międzyludzki w dzisiejszych czasach?','Jaką drogą powinniśmy dążyć aby osiągnąć sukces?','Od członków NZS Politechniki Łódzkiej',1,1,''),(77,'Maciej','Budzisz','maciej@budzisz.net','Jako freelancer chcę przenieść swój biznes na wyższy poziom i skorzystać przy tym z wiedzy Alexa','jak przestać się bać zatrudnić pierwszego pracownika?','Co robić, by dobrze tymi pracownikami zarządzać? ','z FB',1,1,''),(78,'Norbert','Sadlik','sadlik.norbert@gmail.com','Bo mam już 2 żółte koszulki lidera.','Co powoduje, że jedni ludzie są charyzmatycznymi liderami, a inni zamulają przed komputerem i grają w gry?','Jak osiągnąć sukces, zarówno w życiu prywatnym jak i zawodowym?','Od kolegi, który po przeczytaniu książki pana Alexa zaczął odnosić sukcesy.',1,1,''),(79,'Robert','Pikala','robert.pikala@gmail.com','Jestem ambitnym studentem, który zawsze bardzo chętnie korzysta ze wszelkich możliwości rozwoju własnej osoby.','Co zrobić gdy nie wiesz co robić w życiu?','Czym kierować się w trakcie szukania pierwszej poważnej pracy?','Od znajomych działających w NZS.',1,1,''),(80,'Patrycja','Biniek','biniek.patrycja@gmail.com',':)','Jak odnaleźć \"właściwą drogę\", znaleźć satysfakcjonujące zajęcie?','Jak otworzyć się na ciekawych ludzi, nowe doświadczenia?','NZS!',1,1,''),(81,'Wioleta','Słodka','wiola.slodka@wp.pl','Kończę niedługo studia i myślę, że to jeden z lepszych momentów mojego życia, aby czerpać jak najwięcej inspiracji i motywować się do działania. Dlatego też, chciałabym dostać szanse na poznanie człowieka sukcesu, jakim niewątpliwie jest Pan Alex Barszczewski i wyniesienie z tego spotkania wielu korzyści  dla siebie oraz korzystanie ze zdobytej wiedzy w codziennym życiu. Proszę o szanse.','Jak polubić poniedziałki?','Jak odkryć w sobie mocne strony, rozwijać je i potrafić eksponować?','z internetu',1,1,''),(82,'Bayasgalan','Myagmarsuren','bayasa@wp.pl','Do tej pory nie byłem na takich spotkaniach, dlatego chciałbym to zmienić.','Jaką umiejętność najlepiej nabyć aby osiągnąć w czymś sukces?','...','od Patajów',1,1,''),(83,'Reubenmt','Reubenmt','qazujapoduwy@hotmail.com',' \r\nThat is a beautiful shot with very good light-weight :) \r\n \r\nmy website - http://onlinesmpt200.com','I like','I like',NULL,1,0,''),(84,'Wioleta','Cichal','wioleta_cichal@onet.pl','Inicjatywa spotkania z panem Alexem Barszczewskim to fantastyczna idea dla ludzi chcących rozwijać się w sferze umiejętności miękkich. Jestem w gronie tych osób, ponieważ uważam, że dzięki dobrej komunikacji z innymi można wiele osiągnąć. Poza tym obie strony zawsze na tym korzystają, więc warto zgłębiać wiedzę na ten temat, szczególnie, że możemy uczyć się od najlepszych. Sukces jest marzeniem każdego, ale należy pamiętać, że najpierw trzeba podjąć pewien wysiłek. Chyba, że posługujemy się słownikiem, ale to są tylko skróty, które niczego nie wniosą w nasze życie. Dlatego chcę być częścią tego spotkania, podejmować wysiłek i dążyć do sukcesu. Dzięki praktycznej wiedzy, którą z pewnością przekaże pan Alex Barszczewski będę bliżej celu. Między ludźmi to znaczy żyć w zgodzie z innymi i ze sobą samym, chciałabym uczyć się od najlepszych w tej sferze życia. ','Czy chęć napisania tej książki wzięła się z obserwacji Pana otoczenia i stwierdził Pan, że dzięki swojemu doświadczeniu jest Pan w stanie pomóc innym?','Bycie autorem i wydawcą jednocześnie to na pewno jest wielki wysiłek, jakie wątpliwości się Panu nasuwały, kiedy już Pan był w trakcie wydawania książki? Dlaczego Pan na własną rękę podjął się wydania książki? ','Od znajomych, z ogłoszeń na Wydziałach UŁ, z internetu',1,1,''),(85,'Martyna','Urban','martyna3338@wp.pl','Bardzo interesują mnie tematy dotycząc relacji międzyludzkich, a zdobytą wiedzę zamierzam wykorzystać 2 swoim codziennym życiu.','Jak niebanalnie rozpocząć relacje z innymi osobami?','Jakich błędów należy szczególnie unikać?','Facebook',1,1,''),(86,'Karolina','Nowak','karolina.maria.nowak@gmail.com','Ponieważ jestem osobą silnie dążącą do celu i takie spotkania są krokami umożliwiające realizowanie wyznaczonego zamysłu i spełniania marzeń.','Czy zdolności przywódcze wynikają z  cech wrodzonych czy tez można je nabyć?','Jak dużo dobry lider jest w stanie poświęcić w  związku  ze zrealizowaniem zaplanowanego  zadania?','Internetowe Biuro Karier UMED',1,1,''),(87,'Helena','Bogusz','helena.bogusz@wp.pl','Jestem bardzo aktywną studencką działaczką.  Jako członkiem wielu organizacji studenckich tj. Samorząd Studencki, Koło Naukowe Ferment, BEST Łódź pełnię funkcje lidera na stałych pozycjach lub jako koordynator zupełnie nowych projektów. W swoim działaniu staram się dawać z siebie wszystko, cały czas dążę do tego, aby poprawiać moje umiejętności przywódcze i sposób komunikacji. Każde podjęte działanie pozwala mi poznać siebie, dlatego też zdaję sobie sprawę , że wiele muszę się nauczyć i chciałabym poznać narzędzia jak to zrobić. Studiuję na Politechnice Łódzkiej, ale mój umysł domaga się humanistyczne dokładki;)  Myślę, że to szkolenie jest właśnie dla mnie, stwarza dla mnie ogromne możliwości zdobywania wiedzy i narzędzi, które wykorzystam w swoim codziennym działaniu.','Jak wg Pana należy wykształcić w sobie praktyczne narzędzia do umiejętnego zdobywania wartościowej wiedzy?','Zakładam, że na takich spotkaniach korzystają tylko słuchacze, ale również Pan. Czego czy się Pan np. od studentów? ','Koleżanka była kiedyś na szkoleniu z Alexem Barczewskim. Doskonale wie o tym, że bardzo interesuję się tematem rozwoju osobistego i kiedy znalazła w sieci to szkolenie, od razu przesłała mi na facebooku.',1,1,''),(88,'Paulina','Kopacka','paulinakopacka585@gmail.com','Wśród moich znajomych panuje opinia, że mam zdolności przywódcze, po za tym bardzo mi zależy na rozwoju osobistym i podnoszeniu umiejętności komunikacyjnych i interpersonalnych. ','jakie znaczenie ma inteligencja emocjonalna w pracy?','jak zostać trenerem zespołów menedżerskich?','internet',1,1,''),(89,'Łukasz','Zakrzewski','l.zakrzewski@o2.pl','Widziałem wystąpienie Pana Alexa na TEDx w Sopocie. Powiedział tam Pan bardzo fajne zdanie, że trzeba próbować, mieć odwagę na nowe rzeczy. Studiując na Politechnice Łódzkiej nie zawsze mamy okazję podszkolić nasze kompetencje miękkie. Wydaje mi się, że ten wykład byłby świetną okazją do tego.','Czy czasem dla podtrzymania lepszych relacji z drugą osobą można kłamać?','Jeśli miałby Pan podać jedną najważniejszą rzecz o której należy pamiętać w życiu codziennym dotyczącą relacji międzyludzkich to jaka by ona była?','Z facebooka',0,1,'');
/*!40000 ALTER TABLE `kuznia_liderow` ENABLE KEYS */;
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
INSERT INTO `migrations` VALUES ('2013_05_20_130746_installation',1),('2013_05_20_140503_db_views',1),('2014_04_20_182347_confide_setup_users_table',2),('2014_04_21_175856_remember_token',3),('2014_05_04_191054_options',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (1,'entry.sent','1');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `overall_results`
--

DROP TABLE IF EXISTS `overall_results`;
/*!50001 DROP VIEW IF EXISTS `overall_results`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `overall_results` (
 `year` tinyint NOT NULL,
  `edition_type` tinyint NOT NULL,
  `zero_plus` tinyint NOT NULL,
  `zero_minus` tinyint NOT NULL,
  `a_plus` tinyint NOT NULL,
  `a_minus` tinyint NOT NULL,
  `b_plus` tinyint NOT NULL,
  `b_minus` tinyint NOT NULL,
  `ab_plus` tinyint NOT NULL,
  `ab_minus` tinyint NOT NULL,
  `unknown` tinyint NOT NULL,
  `overall` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `overall_school_results`
--

DROP TABLE IF EXISTS `overall_school_results`;
/*!50001 DROP VIEW IF EXISTS `overall_school_results`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `overall_school_results` (
 `year` tinyint NOT NULL,
  `school_id` tinyint NOT NULL,
  `edition_type` tinyint NOT NULL,
  `zero_plus` tinyint NOT NULL,
  `zero_minus` tinyint NOT NULL,
  `a_plus` tinyint NOT NULL,
  `a_minus` tinyint NOT NULL,
  `b_plus` tinyint NOT NULL,
  `b_minus` tinyint NOT NULL,
  `ab_plus` tinyint NOT NULL,
  `ab_minus` tinyint NOT NULL,
  `unknown` tinyint NOT NULL,
  `overall` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `password_reminders`
--

DROP TABLE IF EXISTS `password_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reminders`
--

LOCK TABLES `password_reminders` WRITE;
/*!40000 ALTER TABLE `password_reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `places`
--

DROP TABLE IF EXISTS `places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `places` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `school_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `places_school_id_foreign` (`school_id`),
  CONSTRAINT `places_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `places`
--

LOCK TABLES `places` WRITE;
/*!40000 ALTER TABLE `places` DISABLE KEYS */;
INSERT INTO `places` VALUES (49,'VIII Dom Studenta','ul. Radwańska 40',20),(50,'Centrum Językowe PŁ','al. Politechniki 12',20),(51,'Wydział Biotechnologii i Nauk o Żywności PŁ','ul. Wólczańska 171/173',20),(52,'Centrum Dydaktyczne UMed','ul. Pomorska 251',21),(53,'Plac Hallera','pl. Hallera 1',21),(54,'Biblioteka UMed','ul. Muszyńskiego 1',21),(55,'Stołówka PŁ','al. Politechniki 3a',20),(56,'Wydział Zarządzania UŁ','ul. Matejki 22/26',19),(57,'Wydział Prawa i Administracji UŁ','ul. Kopcińskiego 8/12',19),(58,'Wydział Filologiczny UŁ','al. Kościuszki 65',19),(59,'Wydział Ekonomiczno-Socjologiczny UŁ','ul. Rewolucji 1905r. 41/43',19),(60,'Centrum WFiS UŁ','ul. Styrska 20/24',19),(61,'Wyższa Szkoła Informatyki i Umiejętności','ul. Rzgowska 17',22),(62,'Kino Odeon 3D','Koluszki, ul. 3-go Maja 2',24),(63,'Pasaż Schillera','ul. Piotrkowska 112',24),(64,'AHE w Łodzi','ul. Radwańska 40',23),(65,'Wydział Elektrotechniki, Elektroniki, Informatyki i Automatyki PŁ','ul. Stefanowskiego 18/22',20),(66,'Akademia Muzyczna w Łodzi','ul. Gdańska 32',25);
/*!40000 ALTER TABLE `places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schools` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schools`
--

LOCK TABLES `schools` WRITE;
/*!40000 ALTER TABLE `schools` DISABLE KEYS */;
INSERT INTO `schools` VALUES (19,'Uniwersytet Łódzki','UŁ'),(20,'Politechnika Łódzka','PŁ'),(21,'Uniwersytet Medyczny w Łodzi','UMed'),(22,'Wyższa Szkoła Informatyki i Umiejętności w Łodzi','WSInfiU'),(23,'Akademia Humanistyczno-Ekonomiczna w Łodzi','AHE'),(24,'Pozostałe','Pozostałe'),(25,'Akademia Muzyczna w Łodzi','AMuz');
/*!40000 ALTER TABLE `schools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'nzs','nzs@nzs.lodz.pl','$2y$10$ZMw5ATZ.0xyOOmE5ui33ZuJVGbjB9eGE1rW6I4gB0lC15t7d0tlmu','4477cf26ecb17f04a0878b458fe64161',1,'2014-04-20 22:35:19','2014-04-20 22:35:19','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `action_results`
--

/*!50001 DROP TABLE IF EXISTS `action_results`*/;
/*!50001 DROP VIEW IF EXISTS `action_results`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `action_results` AS select `action_days`.`created_at` AS `created_at`,`action_days`.`updated_at` AS `updated_at`,`action_days`.`edition_id` AS `edition_id`,`action_days`.`place_id` AS `place_id`,`places`.`school_id` AS `school_id`,(case when (month(`action_days`.`created_at`) < 7) then 1 else 2 end) AS `edition_type`,`action_data`.`zero_plus` AS `zero_plus`,`action_data`.`zero_minus` AS `zero_minus`,`action_data`.`a_plus` AS `a_plus`,`action_data`.`a_minus` AS `a_minus`,`action_data`.`b_plus` AS `b_plus`,`action_data`.`b_minus` AS `b_minus`,`action_data`.`ab_plus` AS `ab_plus`,`action_data`.`ab_minus` AS `ab_minus`,`action_data`.`unknown` AS `unknown`,((((((((`action_data`.`zero_plus` + `action_data`.`zero_minus`) + `action_data`.`a_plus`) + `action_data`.`a_minus`) + `action_data`.`b_plus`) + `action_data`.`b_minus`) + `action_data`.`ab_plus`) + `action_data`.`ab_minus`) + `action_data`.`unknown`) AS `overall` from ((((`action_days` join `action_data` on((`action_days`.`id` = `action_data`.`id`))) join `editions` on((`action_days`.`edition_id` = `editions`.`id`))) join `places` on((`action_days`.`place_id` = `places`.`id`))) join `schools` on((`places`.`school_id` = `schools`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `overall_results`
--

/*!50001 DROP TABLE IF EXISTS `overall_results`*/;
/*!50001 DROP VIEW IF EXISTS `overall_results`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `overall_results` AS select year(`action_results`.`created_at`) AS `year`,(case when (month(`action_results`.`created_at`) < 7) then 1 else 2 end) AS `edition_type`,sum(`action_results`.`zero_plus`) AS `zero_plus`,sum(`action_results`.`zero_minus`) AS `zero_minus`,sum(`action_results`.`a_plus`) AS `a_plus`,sum(`action_results`.`a_minus`) AS `a_minus`,sum(`action_results`.`b_plus`) AS `b_plus`,sum(`action_results`.`b_minus`) AS `b_minus`,sum(`action_results`.`ab_plus`) AS `ab_plus`,sum(`action_results`.`ab_minus`) AS `ab_minus`,sum(`action_results`.`unknown`) AS `unknown`,sum(`action_results`.`overall`) AS `overall` from `action_results` group by `action_results`.`edition_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `overall_school_results`
--

/*!50001 DROP TABLE IF EXISTS `overall_school_results`*/;
/*!50001 DROP VIEW IF EXISTS `overall_school_results`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `overall_school_results` AS select year(`action_results`.`created_at`) AS `year`,`action_results`.`school_id` AS `school_id`,(case when (month(`action_results`.`created_at`) < 7) then 1 else 2 end) AS `edition_type`,sum(`action_results`.`zero_plus`) AS `zero_plus`,sum(`action_results`.`zero_minus`) AS `zero_minus`,sum(`action_results`.`a_plus`) AS `a_plus`,sum(`action_results`.`a_minus`) AS `a_minus`,sum(`action_results`.`b_plus`) AS `b_plus`,sum(`action_results`.`b_minus`) AS `b_minus`,sum(`action_results`.`ab_plus`) AS `ab_plus`,sum(`action_results`.`ab_minus`) AS `ab_minus`,sum(`action_results`.`unknown`) AS `unknown`,sum(`action_results`.`overall`) AS `overall` from `action_results` group by `action_results`.`edition_id`,`action_results`.`school_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-21  0:05:03
