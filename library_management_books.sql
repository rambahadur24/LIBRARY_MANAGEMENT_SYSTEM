-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: library_management
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `book_id` int NOT NULL AUTO_INCREMENT,
  `isbn` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publication_year` int DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `pages` int DEFAULT NULL,
  `copies_available` int DEFAULT '1',
  `total_copies` int DEFAULT '1',
  `description` text,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`book_id`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `idx_title` (`title`),
  KEY `idx_author` (`author`),
  KEY `idx_genre` (`genre`),
  KEY `idx_year` (`publication_year`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'978-0-13-468599-1','Clean Code','Robert C. Martin','Prentice Hall',2008,'Technology',464,3,3,'A handbook of agile software craftsmanship',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15'),(2,'978-0-596-52068-7','JavaScript: The Good Parts','Douglas Crockford','O\'Reilly Media',2008,'Technology',176,2,2,'Unearthing the excellence in JavaScript',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15'),(3,'978-0-134-68599-1','The Pragmatic Programmer','Andrew Hunt','Addison-Wesley',2019,'Technology',352,4,4,'Your journey to mastery',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15'),(4,'978-0-061-96436-7','Dune','Frank Herbert','Ace Books',2019,'Science Fiction',688,5,5,'Epic science fiction masterpiece',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15'),(5,'978-0-547-92821-7','The Hobbit','J.R.R. Tolkien','Mariner Books',2012,'Fantasy',310,3,3,'A timeless classic of fantasy literature',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15'),(6,'978-0-451-52493-5','1984','George Orwell','Signet Classic',1950,'Science Fiction',328,6,6,'Dystopian social science fiction',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15'),(7,'978-0-316-76948-0','The Catcher in the Rye','J.D. Salinger','Little, Brown',1951,'Fiction',277,2,2,'Classic American literature',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15'),(8,'978-1-501-11061-8','The Testaments','Margaret Atwood','Anchor Books',2023,'Science Fiction',432,4,4,'Sequel to The Handmaid\'s Tale',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15'),(9,'978-0-593-31122-7','Project Hail Mary','Andy Weir','Ballantine Books',2023,'Science Fiction',496,3,3,'Thrilling space adventure',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15'),(10,'978-1-250-30270-7','Network Effect','Martha Wells','Tordotcom',2023,'Science Fiction',352,2,2,'Murderbot Diaries series',NULL,'2025-12-10 17:54:15','2025-12-10 17:54:15');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-11 21:14:14
