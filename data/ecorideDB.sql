--
-- Table structure for table `Commentaire`
--

DROP TABLE IF EXISTS `Commentaire`;
CREATE TABLE `Commentaire` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `commentaire` varchar(250) NOT NULL,
  `user_covoiturage_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_covoiturage_id` (`user_covoiturage_id`),
  CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`user_covoiturage_id`) REFERENCES `User_Covoiturages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Dumping data for table `Commentaire`
--

LOCK TABLES `Commentaire` WRITE;
INSERT INTO `Commentaire` VALUES (1,'Le chauffeur roulait trop vite',78),(2,'test',78),(3,'Voici un test comme quoi cette partie fonctionne',77),(4,'Voici un test comme quoi cette partie fonctionne, test 2',24);
UNLOCK TABLES;

--
-- Table structure for table `Covoiturage`
--

DROP TABLE IF EXISTS `Covoiturage`;
CREATE TABLE `Covoiturage` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nb_place_disponible` int NOT NULL,
  `prix` float NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_arrivee` datetime NOT NULL,
  `adresse_depart` varchar(255) NOT NULL,
  `adresse_arrivee` varchar(255) NOT NULL,
  `voiture_id` int unsigned DEFAULT NULL,
  `statut_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `voiture_id` (`voiture_id`),
  KEY `statut_id` (`statut_id`),
  CONSTRAINT `covoiturage_ibfk_1` FOREIGN KEY (`voiture_id`) REFERENCES `Voiture` (`id`),
  CONSTRAINT `covoiturage_ibfk_2` FOREIGN KEY (`statut_id`) REFERENCES `Statut` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Covoiturage`
--

LOCK TABLES `Covoiturage` WRITE;
INSERT INTO `Covoiturage` VALUES (4,0,500,'2025-02-19 16:36:00','2025-02-19 16:36:00','paris','colombia',12,1),(10,1,40,'2025-02-04 21:29:00','2025-02-04 22:29:00','Lyon','Barcelona',20,1),(11,2,5,'2025-02-16 19:42:00','2025-02-17 22:42:00','lyon','Paris',21,1),(12,2,6,'2025-02-04 22:03:00','2025-02-08 22:03:00','lyon','Barcelona',21,1),(13,2,2,'2025-03-09 23:09:00','2025-03-10 02:08:00','lyon','barcelona',21,1),(14,11,11,'2025-02-04 23:31:00','2025-02-05 03:34:00','lyon','barcelona',21,1),(15,3,4,'2025-01-02 18:50:00','2025-01-02 21:53:00','lyon','barcelona',21,1),(16,9,5,'2025-03-22 10:16:00','2025-03-22 15:16:00','Lyon','Voreppe',22,3),(17,10,3,'2025-03-01 11:34:00','2025-03-01 13:39:00','lyon','Voreppe',21,1),(18,3,10,'2025-03-22 11:43:00','2025-03-22 21:43:00','lyon','voreppe',23,1),(19,3,6,'2025-02-16 19:24:00','2025-02-16 22:24:00','lyon','barcelona',9,1),(20,6,10,'2025-07-23 18:59:00','2025-07-23 22:59:00','lyon','barcelona',23,1);
UNLOCK TABLES;

--
-- Table structure for table `Energie`
--

DROP TABLE IF EXISTS `Energie`;
CREATE TABLE `Energie` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Energie`
--

LOCK TABLES `Energie` WRITE;
INSERT INTO `Energie` VALUES (1,'Électrique'),(2,'Hybride'),(3,'Diesel - Gazole'),(4,'Essence'),(5,'GPL');
UNLOCK TABLES;

--
-- Table structure for table `Preference`
--

DROP TABLE IF EXISTS `Preference`;
CREATE TABLE `Preference` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(500) NOT NULL,
  `statut` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Preference`
--

LOCK TABLES `Preference` WRITE;
INSERT INTO `Preference` VALUES (1,'Fumeur',1),(2,'Animal',1),(3,'Non_fumeur',0),(4,'Non_animal',0);
UNLOCK TABLES;

--
-- Table structure for table `Role`
--

DROP TABLE IF EXISTS `Role`;
CREATE TABLE `Role` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Role`
--

LOCK TABLES `Role` WRITE;
INSERT INTO `Role` VALUES (1,'Passager'),(2,'Chauffuer'),(3,'Chauffuer - Passager'),(4,'Employé'),(5,'Administrateur');
UNLOCK TABLES;

--
-- Table structure for table `Statut`
--

DROP TABLE IF EXISTS `Statut`;
CREATE TABLE `Statut` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Statut`
--

LOCK TABLES `Statut` WRITE;
INSERT INTO `Statut` VALUES (1,'Crée'),(2,'Démarré'),(3,'Arrivé'),(4,'Validé'),(5,'Annulé');
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nb_credits` int DEFAULT '20',
  `pseudo` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role_id` int unsigned DEFAULT NULL,
  `photo_uniqId` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
INSERT INTO `User` VALUES (44,20,'pedri','pedri@mail.com','$2y$10$2Zf4ELm5u6CyyOlaRuiqAeiDkN9o9jm1M7THDesPCn/2J.n3VGYHm',NULL,2,NULL,0),(46,20,'drive','drvie@gmail.com','$2y$10$GmSpKM0jMTHWp/URIMIMGeOju1CzuK1/h9XcIx41U7bpQ.UEn/97i',NULL,2,NULL,0),(47,124,'car','carlitospro12457@gmail.com','$2y$10$FgXHSRp7Le.apy5kpleJ6.l3NBqZfezeZakrEzUbATJnu1FYDbOoa',NULL,2,NULL,1),(48,20,'juan','juan@mail.comeae','$2y$10$o6ja2Uh5sym5jLCqYU74I.Q0e2vt.eDltCIxb2cKKiF3OlZeuIofK',NULL,2,NULL,1),(49,20,'juan','pepe@mail.comadzd','$2y$10$KhRBeaU8hZIymT7PKNnqrekTwFmm8hrGigx6GAkVrWknlUMBbb1ka',NULL,2,NULL,1),(50,20,'jose','Jose@gmail.com','$2y$10$nuzDqTHBon2rsiBJ8GW1ou32RONQJqZ6QNAXTuSp6RIbJqfKCS6k.',NULL,3,NULL,1),(51,20,'pepe','juan@mail.comqsq','$2y$10$GK.2RAaAX5lM/lci3cGepuNZJSip3O0/a6XNZizhs0LxEdWEns.hm',NULL,1,NULL,1),(53,20,'foto','foto@k.cdd','$2y$10$HQnEp1bAaJaAQJXBntdp0eWpLlZ0deGxkWnuAaH4qjsLL1z9XOQQG','emoji.png',2,NULL,1),(54,20,'mate','mate@gmail.com','$2y$10$sUYODHs8nPqnKEqSjyXO1OOyUGWTQVrFjoqpKq/0nsye2enTtD/nG','js.png',2,NULL,1),(55,20,'dd','sdspepe@mail.com','$2y$10$5p6iHS6Mz.d.kvkMTXXAt.akTWoYOG0.5XeTiDOkGRWOaZGuRWsfO',NULL,1,NULL,1),(56,20,'pepe','juan@mail.comd','$2y$10$IU5fDNWk6zALqxxI/qDpSeaxL2HQevth.CLP/r/pNcNYKacF7YZpi',NULL,1,NULL,1),(57,20,'juan','tete@g.comxx','$2y$10$ULnzxxaUHoKghNP/SIm63e2Q3zqTEhG6AnsLJYLasckws1CRmfNMC','raton-laveur.jpg',2,NULL,1),(58,20,'juan','drvie@gmail.comdq','$2y$10$h7J2Ll3B4ziJ/ydp7neeW.bqlBtO0AMwtwomoPMAmXhnM0vIOVpmW',NULL,1,NULL,1),(59,6,'passager','passager734@gmail.com','$2y$10$TPpwvjShwUwX78TtOVoDSeJD6jYjhioe2S75NKldTnijcP1xZospu',NULL,1,NULL,1),(60,20,'juan','nocarro@gmail.com','$2y$10$jtWtlXWGt..r.9c/XfK8GOHCYU4aNmLQftdWrVmxHgFS6Wu4hI0cG','emoji.png',2,NULL,1),(61,20,'cdss','tete@g.comc','$2y$10$Ww1r29Zn/7IcXyeGKL/ZK.2R.D4LtOPgqSWH.0NXlmX/K59xRdXQi',NULL,1,NULL,1),(62,20,'juan','sincarro@gmaiml.com','$2y$10$UI6M6wIq0mjfi2vSSoqFKenvG/fgbD4vjO48JeEwy9qtyq2XGM1NS','emoji.png',3,NULL,1),(63,20,'juan','sincarro@gmail.com','$2y$10$2EvZiDKMQudXi4QkTeWQQ.C3yniarFqmDAej481BnIDx7IADTqOuu','emoji.png',2,NULL,1),(64,20,'Juanes','juanes@gmail.com','$2y$10$33D4UPT.4if4GK5N3ayE.e0OnBRMC3W4UQhaUegkpLzI8c1Ya8Yoi','emoji.png',3,NULL,1),(65,10,'Pepito','pepitopro214@gmail.com','$2y$10$W52X8HJ1zDECoou1WoOfaeyeM66lvs1Opvg111zJ6.Byhvx.q1dqa','emoji.png',3,'67b2308aa76212.23436902.png',1),(66,20,'Employé','employe@gmail.com','$2y$12$FUqcA6UYdAM5l0xC6KBxIOYohLFB2GCQYjKRPtTfJ0V7goQAQQObC',NULL,4,NULL,1),(67,20,'Admin','admin@gmail.com','$2y$12$.sKPwBdcKYHz2ahb9wBkR.z9S9V/LHqdXCs5LqDOtE29YW5Fqt3Y2',NULL,5,NULL,1),(68,20,'Employe_2','Employe_2@gmail.com','$2y$12$KlFdyGjjIqVskVKB.Hv9quWNMdLNQgAYvp5t.BYuuNn6ZoBDBHNlK',NULL,4,NULL,0),(69,20,'Employe_3','Employe_3@gmail.com','$2y$12$xqdPEPSaxuIEViEaF5QMselKsKMDEFD/lgVP/cQwHYcbAihg3fJmy',NULL,4,NULL,1),(70,20,'Employe_4','Employe_4@gmail.com','$2y$12$QsQjXep2/AQrqv/dSRTs8uAIHJoCvJoL/nD6jSp79iQ4QqMArgUiO',NULL,4,NULL,1);
UNLOCK TABLES;

--
-- Table structure for table `User_Covoiturages`
--

DROP TABLE IF EXISTS `User_Covoiturages`;
CREATE TABLE `User_Covoiturages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `covoiturage_id` int unsigned DEFAULT NULL,
  `statut_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_covoiturages_ibfk_2` (`covoiturage_id`),
  KEY `statut_id` (`statut_id`),
  CONSTRAINT `user_covoiturages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`),
  CONSTRAINT `user_covoiturages_ibfk_2` FOREIGN KEY (`covoiturage_id`) REFERENCES `Covoiturage` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_covoiturages_ibfk_3` FOREIGN KEY (`statut_id`) REFERENCES `Statut` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User_Covoiturages`
--

LOCK TABLES `User_Covoiturages` WRITE;
INSERT INTO `User_Covoiturages` VALUES (24,59,14,NULL),(25,59,12,NULL),(76,47,14,NULL),(77,59,16,NULL),(78,65,16,4),(79,47,11,NULL),(80,59,17,NULL),(81,59,15,NULL);
UNLOCK TABLES;

--
-- Table structure for table `User_Preferences`
--

DROP TABLE IF EXISTS `User_Preferences`;
CREATE TABLE `User_Preferences` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `preference_personnelle` varchar(500) DEFAULT NULL,
  `preference_id` int unsigned DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `preference_id` (`preference_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_preferences_ibfk_1` FOREIGN KEY (`preference_id`) REFERENCES `Preference` (`id`),
  CONSTRAINT `user_preferences_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User_Preferences`
--

LOCK TABLES `User_Preferences` WRITE;
INSERT INTO `User_Preferences` VALUES (1,'prueba',1,47),(3,'',1,47),(4,'',1,47),(6,'',1,47),(7,'',1,47),(8,'',1,47),(9,'',1,47),(10,'',1,47),(13,'ceci est une preuve, ca fonctionne!!!',2,47),(15,'',1,47),(25,'',1,47),(26,'',1,47),(27,'',1,47),(28,'',1,47),(29,'',1,47),(31,'',1,47),(32,'',2,47),(33,'xd',2,47),(34,'',3,50),(35,'J\'écoute pop en anglais',2,50),(36,'',3,50),(37,'',2,50),(38,'',3,54),(39,'Je suis amie du rayo MCqueen',2,54),(40,'',1,60),(41,'',2,60),(42,'',3,63),(43,'',3,63),(44,'',3,63),(45,'xd',2,63),(46,'',3,64),(47,'J\'écoute pop en anglais',2,64),(48,'',1,65),(49,'',4,65),(55,'J\'écoute pop en francais',1,65),(56,'J\'aime bien parler avec les passagers ',1,65);
UNLOCK TABLES;

--
-- Table structure for table `Voiture`
--

DROP TABLE IF EXISTS `Voiture`;
CREATE TABLE `Voiture` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `modele` varchar(255) NOT NULL,
  `couleur` varchar(50) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `immatriculation` varchar(50) NOT NULL,
  `date_premiere_immatriculation` date NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `energie_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Voiture`
--

LOCK TABLES `Voiture` WRITE;
INSERT INTO `Voiture` VALUES (9,'mercedes','rojo','benz','AA-123-BC','2025-01-17',47,3),(12,'cars','rojo','toyota','AA-123-DC','2025-01-04',47,3),(13,'mc4','Blue','ferrari','BB-123-BC','2005-05-14',50,3),(14,'XM3','rojo','lambo','AA-123-DN','2025-01-30',54,3),(15,'zasas','sas','azsazs','AA-123-AM','2025-02-12',60,2),(16,'mamma','csdcds','csdcd','AA-123-BM','2025-02-06',63,3),(17,'mb06','Negro','Chevrolet','BB-123-BX','2010-06-17',47,3),(18,'Max12','Grise','Volvo','AA-123-MN','2025-01-28',47,3),(19,'md23','rojo','BMW','AA-123-NM','2025-02-03',47,1),(20,'XM33','Rouge','Lambo','BB-123-BB','2025-01-30',64,1),(21,'XM234','Noir','lambo','CC-123-BC','2025-01-27',65,1),(22,'A8','Grise','Audi','AA-123-FF','2024-10-17',47,1),(23,'AC45','Rouge','Nissan','AA-123-MW','2025-02-25',65,3);
UNLOCK TABLES;