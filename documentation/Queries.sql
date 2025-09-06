/* Voici un fichier .sql avec plusieurs requêtes qui sont été 
utilisées pour la gestion de la base des données MySQL. */


-- Création de la base de données
CREATE DATABASE ecorideDB;

-- Création de l'utilisateur, le mot de passe n'est pas affiché
CREATE USER 'juandb'@'localhost' IDENTIFIED BY 'mot_de_passe';

-- Ajouter tous les droits a l'utilisateur 
GRANT ALL PRIVILEGES ON *.* TO 'juandb'@'localhost' WITH GRANT OPTION;

-- Blocage de l'utilisateur root
ALTER USER 'root'@'localhost' ACCOUNT LOCK;

USE ecorideDB;

--
-- Structure de la table Commentaire
--

CREATE TABLE Commentaire (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  commentaire VARCHAR(255) NOT NULL,
  user_covoiturage_id INT UNSIGNED NOT NULL,
  CONSTRAINT fk_Commentaire_User_Covoiturage
  FOREIGN KEY (user_covoiturage_id) 
  REFERENCES User_Covoiturage(id)
  ON DELETE CASCADE ON UPDATE CASCADE 
);

--
-- Structure de la table Covoiturage
--

CREATE TABLE Covoiturage (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nb_place_disponible TINYINT UNSIGNED NOT NULL,
  prix DECIMAL(8,2) UNSIGNED NOT NULL,
  date_heure_depart DATETIME NOT NULL,
  date_heure_arrivee DATETIME NOT NULL,
  adresse_depart VARCHAR(255) NOT NULL,
  adresse_arrivee VARCHAR(255) NOT NULL,
  voiture_id INT UNSIGNED NOT NULL,
  statut_id INT UNSIGNED NOT NULL,
  CONSTRAINT fk_Covoiturage_Voiture
    FOREIGN KEY (voiture_id)
    REFERENCES Voiture(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_Covoiturage_Statut
    FOREIGN KEY (statut_id)
    REFERENCES Statut(id)
);

--
-- Structure de la table Energie
--

CREATE TABLE Energie (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(255) NOT NULL
);

--
-- Structure de la table Preference
--

CREATE TABLE Preference (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(255) NOT NULL
);

--
-- Structure de la table Preference_Personnelle
--

CREATE TABLE Preference_Personnelle (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  preference VARCHAR(255) NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  CONSTRAINT fk_Preference_Personnelle_User
    FOREIGN KEY (user_id)
    REFERENCES User(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Structure de la table Role
--

CREATE TABLE Role (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL
);

--
-- Structure de la table Statut
--

CREATE TABLE Statut (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL
);

--
-- Structure de la table User
--

CREATE TABLE User (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nb_credits INT UNSIGNED DEFAULT 20,
  pseudo VARCHAR(50) NOT NULL,
  mail VARCHAR(255) NOT NULL UNIQUE,
  password char(60) NOT NULL,
  photo VARCHAR(255) DEFAULT NULL,
  photo_uniqId VARCHAR(255) DEFAULT NULL,
  active TINYINT(1) DEFAULT 1,
  login_attempts TINYINT UNSIGNED DEFAULT 0,
  locked_until DATETIME DEFAULT NULL,
  role_id INT UNSIGNED NOT NULL,
  CONSTRAINT fk_User_Role
    FOREIGN KEY (role_id)
    REFERENCES Role(id)
);

--
-- Structure de la table User_Covoiturage
--

CREATE TABLE User_Covoiturage (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL,
  covoiturage_id INT UNSIGNED NOT NULL,
  statut_id INT UNSIGNED NOT NULL,
  CONSTRAINT fk_User_Covoiturage_1
    FOREIGN KEY (user_id)
    REFERENCES User(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_User_Covoiturage_2
    FOREIGN KEY (covoiturage_id)
    REFERENCES Covoiturage(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_User_Covoiturage_3
    FOREIGN KEY (statut_id)
    REFERENCES Statut(id)
);

--
-- Structure de la table User_Preference
--

CREATE TABLE User_Preference (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  preference_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  CONSTRAINT fk_User_Preference_1
    FOREIGN KEY (preference_id)
    REFERENCES Preference(id),
  CONSTRAINT fk_User_Preference_2
    FOREIGN KEY (user_id)
    REFERENCES User(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Structure de la table Voiture
--

CREATE TABLE Voiture (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  modele VARCHAR(255) NOT NULL,
  couleur VARCHAR(50) NOT NULL,
  marque VARCHAR(50) NOT NULL,
  immatriculation VARCHAR(9) NOT NULL,
  date_premiere_immatriculation date NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  energie_id INT UNSIGNED NOT NULL,
  CONSTRAINT fk_Voiture_User
    FOREIGN KEY (user_id)
    REFERENCES User(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_Voiture_Energie
    FOREIGN KEY (energie_id)
    REFERENCES Energie(id)
);


SELECT * FROM Role;
SELECT * FROM User;


INSERT INTO Role (libelle) VALUES ('passager');
INSERT INTO Role (libelle) VALUES ('chauffeur');
INSERT INTO Role (libelle) VALUES ('passager_chauffeur');



UPDATE Role  
SET libelle = "chauffeur - Passager"
WHERE id = 3;

SELECT * FROM Role;

SELECT User.pseudo, User.mail, Role.libelle 
FROM User
INNER JOIN Role ON User.role_id = Role.id
WHERE User.id = 42;

SELECT libelle FROM Role WHERE id = 1;

SELECT * FROM Energie;
SELECT * FROM Preference;

ALTER TABLE Preference 
MODIFY COLUMN statut BOOLEAN;

UPDATE Energie 
SET libelle = "Diesel - Gazole"
WHERE id =  3;

INSERT INTO Energie (libelle) VALUE("GPL");

INSERT INTO Preference (libelle, statut) VALUE ('Fumeur', false);
INSERT INTO Preference (libelle, statut) VALUE ('Animal', false);


SELECT * FROM Voiture;

SELECT * FROM User;

SELECT User.pseudo, Voiture.marque, Voiture.modele
FROM Voiture
INNER JOIN User ON Voiture.user_id = User.id
WHERE Voiture.couleur = "rojo";

SELECT * FROM Preference;

UPDATE Preference
SET libelle = "Non_animal"
WHERE id = 4;

SELECT * FROM Preference
WHERE statut = 0;

SELECT Voiture.marque, User.pseudo
FROM Voiture
INNER JOIN User ON Voiture.user_id = User.id
WHERE User.id = 47;


INSERT INTO User_Preference (preference_personnelle, preference_id, user_id) VALUES ("seguna",4, 47);

SELECT * FROM User_Preference;
SELECT * FROM Preference;


SELECT User.pseudo,
User_Preference.preference_personnelle, 
Preference.libelle
FROM User_Preference
INNER JOIN User ON User_Preference.User_id = User.id
INNER JOIN Preference ON User_Preference.preference_id = Preference.id
WHERE User.id = 10;

CREATE TABLE User_Preference(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    preference_personnelle VARCHAR(500) NULL,
    preference_id INT UNSIGNED,
    user_id INT UNSIGNED,
    FOREIGN KEY (preference_id) REFERENCES Preference(id),
    FOREIGN KEY (user_id) REFERENCES User(id)
);

SELECT User_Preference.id FROM User_Preference
INNER JOIN User ON User_Preference.User_id = User.id
WHERE User.id = "47";

SELECT Voiture.id FROM Voiture
WHERE user_id = "60";

SELECT * FROM Statut;

INSERT INTO Statut (libelle) VALUES ("Annulé");


SELECT * FROM Covoiturage;
SELECT * FROM Voiture;
SELECT * FROM User WHERE id = 47;
SELECT * FROM Energie;

DELETE FROM Covoiturage WHERE id = 9;

SELECT User.pseudo, User.photo, Covoiturage.id
FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN User ON Voiture.user_id = User.id
WHERE Covoiturage.id = 1;

SELECT DISTINCT Preference.libelle, User_Preference.preference_personnelle
FROM User_Preference
INNER JOIN User ON User_Preference.user_id = User.id
INNER JOIN Preference ON User_Preference.preference_id = Preference.id
WHERE User.id = 47;

SELECT DISTINCT Preference.libelle, User_Preference.preference_personnelle, User.pseudo
FROM User_Preference
INNER JOIN User ON User_Preference.user_id = User.id
INNER JOIN Preference ON User_Preference.preference_id = Preference.id
WHERE User.id = 64;


SELECT * FROM Preference;
SELECT * FROM User_Preference;

DELETE FROM User_Preference
WHERE User_id = 47 AND Preference_id = 4;

SELECT * FROM Voiture
WHERE Voiture.energie_id = 1;

SELECT Energie.id as Énergie_id, Covoiturage.id as Covoiturage_id
FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN Energie ON Voiture.energie_id = Energie.id
WHERE Covoiturage.id = 1;


ALTER TABLE User
ADD photo_uniqId VARCHAR(255);
SELECT * FROM User;


DELETE FROM Voiture WHERE id = 11;

SELECT Voiture.id, Voiture.marque, Voiture.modele, Voiture.immatriculation FROM Voiture WHERE user_id = 47;

SELECT User.pseudo, User.photo, Voiture.id
FROM Voiture
INNER JOIN User ON Voiture.user_id = User.id
WHERE Voiture.id = 9;


SELECT User.pseudo, User.photo, Voiture.id as voiture_id, Voiture.marque, Covoiturage.id as Covoiturage_id
FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN User ON Voiture.user_id = User.id
WHERE Covoiturage.id = 1;


SELECT * FROM User;
SELECT * FROM Voiture
WHERE id = 9;


SELECT Voiture.marque, Voiture.modele, Energie.libelle as energie
FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN Energie ON Voiture.energie_id = Energie.id
WHERE Covoiturage.id = 1;


SELECT Voiture.marque, Voiture.modele
FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
WHERE Covoiturage.id = 1;

SELECT * FROM Covoiturage
WHERE adresse_depart = "lyon" && adresse_arrivee = "barcelona";

SELECT * FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN Energie ON Voiture.energie_id = Energie.id
WHERE Energie.id = 1;

SELECT TIMEDIFF(date_heure_depart, date_heure_arrivee) as difference
FROM Covoiturage
WHERE id = 12;

SELECT TIMESTAMPDIFF(HOUR, date_heure_depart, date_heure_arrivee) as difference
FROM Covoiturage
WHERE id = 12;


SELECT * FROM Covoiturage WHERE Id = 8;


SELECT Covoiturage.* FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN Energie ON Voiture.energie_id = Energie.id
WHERE adresse_depart = "lyon" AND 
adresse_arrivee = "barcelona" AND TIMESTAMPDIFF(HOUR, date_heure_depart, date_heure_arrivee) < 2;

USE ecorideDB;

SELECT * FROM User_Covoiturage;

SELECT * FROM Covoiturage
WHERE id = 14;

-- Pour récuperer les covoiturages auxquels luser conduit'
SELECT Covoiturage.id, Covoiturage.date_heure_depart, Covoiturage.date_heure_arrivee, Covoiturage.adresse_depart, Covoiturage.adresse_arrivee,
User.pseudo, User.photo_uniqId
FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN User ON Voiture.user_id = User.id
WHERE User.id = 47;


-- Pour récuperer les covoiturages auxquels l'user participe'
SELECT Covoiturage.id, Covoiturage.date_heure_depart, Covoiturage.date_heure_arrivee, 
Covoiturage.adresse_depart, Covoiturage.adresse_arrivee
FROM User_Covoiturage 
INNER JOIN Covoiturage ON User_Covoiturage.covoiturage_id = Covoiturage.id 
WHERE user_id = 47;


SELECT * FROM User_Covoiturage;
SELECT * FROM User WHERE id = 59;
SELECT User.pseudo, User.photo_uniqId FROM Covoiturage 
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
WHERE user_id = 65;

SELECT Covoiturage.id as covoiturage_id, User.id as User_id, User.pseudo FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN User ON Voiture.user_id = User.id
WHERE covoiturage.id = 14;



/* Fonction pour modifier les crédits de l'user */
UPDATE User 
SET nb_credits = if(User.nb_credits > 0, User.nb_credits - 2, false)
WHERE id = 7;
SELECT * FROM User;

UPDATE User 
SET nb_credits = User.nb_credits - 2
WHERE id = 7;

UPDATE User 
SET nb_credits = if(User.nb_credits > 0, User.nb_credits - 2, false)
WHERE id = 7;

ALTER TABLE User MODIFY COLUMN nb_credits INT DEFAULT 20;

DESC User;



SELECT * FROM User_Covoiturage WHERE user_id = 59;

DELETE FROM User_Covoiturage WHERE user_id = 59;


SELECT * FROM Covoiturage WHERE id = 4;
/* Fonction pour modifier les nombres des places du covoiturage */

UPDATE Covoiturage
SET nb_place_disponible = if(nb_place_disponible > 0, nb_place_disponible - 1, false)
WHERE id = 4;

UPDATE User 
SET nb_credits = 20 
WHERE id = 47;

SELECT * FROM User_Covoiturage WHERE covoiturage_id = 17;

UPDATE Covoiturage
SET nb_place_disponible = 10
WHERE id = 17;

/* Fonction pour annuler la participation au covoiturage en tant que passager */
DELETE FROM User_Covoiturage WHERE user_id = 47 AND covoiturage_id = 17;

/* Fonction pour annuler la participation au covoiturage en tant que chauffeur */
DELETE FROM Covoiturage WHERE id = 17;
SHOW CREATE TABLE User_Covoiturage;
SELECT * FROM User_Covoiturage WHERE covoiturage_id = 2;

SELECT nb_credits FROM User WHERE id = 65;

SELECT user_id 
FROM User_Covoiturage 
WHERE covoiturage_id = 8;

SELECT * FROM Covoiturage WHERE id = 2;

/* Pour voir tous les constraINTs de la table */
SELECT CONSTRAINT_NAME
FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
WHERE TABLE_NAME = 'User_Covoiturage'
AND CONSTRAINT_TYPE = 'FOREIGN KEY';

/* Ici on elimine la constraINT de la foreign key de la table User_Covoiturage
pour en ajouter une nouvelle avec le ON DELETE CASCADE, comme ca, si l'user chauffeur supprime 
un covoiturage, alors, tous ces covoiturages qu'eteINT dans la table User_Covoiturage seront supprimés
 */
ALTER TABLE User_Covoiturage DROP FOREIGN KEY user_covoiturage_ibfk_2;
ALTER TABLE User_Covoiturage 
ADD CONSTRAINT user_covoiturage_ibfk_2
FOREIGN KEY (covoiturage_id) REFERENCES Covoiturage(id) 
ON DELETE CASCADE;

/* Fonction pour chercher le mail de tous les participants d'un covoiturage */

SELECT User_Covoiturage.user_id, passager.mail, driver.pseudo
FROM User_Covoiturage
INNER JOIN User as passager ON User_Covoiturage.user_id = passager.id
INNER JOIN Covoiturage ON User_Covoiturage.covoiturage_id = Covoiturage.id
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN User as driver ON Voiture.user_id = driver.id
WHERE covoiturage_id = 8;


UPDATE User 
SET mail = "carlitospro12457@gmail.com"
WHERE id = 47;

/* Pour désactiver le safe mode de sql, afin de supprimer tous les users dont le mot de passe
est inferieure à 10 digits, et après on reactive le safe mode du sql
*/
SET SQL_SAFE_UPDATES = 0;
DELETE FROM User WHERE LENGTH(password) < 10;
SET SQL_SAFE_UPDATES = 1;

SELECT * FROM Covoiturage WHERE id = 16;

UPDATE Covoiturage 
SET nb_place_disponible = 10
WHERE id = 16;


/* Pour savoir si l'user participe déjà au covoiturage */
SELECT * FROM User_Covoiturage
WHERE user_id = 59 AND covoiturage_id = 14;


SELECT C.id FROM Covoiturage C
INNER JOIN Voiture V ON C.voiture_id = V.id
INNER JOIN User U ON V.user_id = U.id
WHERE U.id = 47;

UPDATE User SET nb_credits = 10 WHERE id = 65;

SELECT * FROM Statut;

SELECT * FROM Covoiturage WHERE id = 16;


UPDATE Covoiturage 
SET statut_id = 1
WHERE id = 16;

SELECT Statut.id, Statut.libelle, Covoiturage.adresse_depart, Covoiturage.adresse_arrivee
FROM Covoiturage
INNER JOIN Statut ON Covoiturage.statut_id = Statut.id
WHERE Covoiturage.id = 16;

/* Mettre à jour les crédts du chauffeur après la validation */

UPDATE User 
SET nb_credits = nb_credits + 10
WHERE id = 47;

/* Enregistrer les commentaires quand le covoiturage s'est mal passé */

SELECT * FROM Commentaire;

SELECT * FROM User_Covoiturage WHERE user_id = 65 AND covoiturage_id = 16;

DESCRIBE Commentaire;
SELECT * FROM User_Covoiturage WHERE id = 78; 

/* Rêquete pour chercher l'info de chaque commmentaire laissait concernant un covoiturage mal passé */
SELECT C.id AS covoiturage_id, C.date_heure_depart, C.date_heure_arrivee, C.adresse_depart, C.adresse_arrivee,
Passager.id AS passager_id, Passager.pseudo AS passager_pseudo, Passager.mail AS passager_mail, 
Driver.id AS driver_id, Driver.pseudo AS driver_pseudo, Driver.mail AS driver_mail,
Comment.commentaire, Comment.id as commentaire_id
FROM Commentaire AS Comment
INNER JOIN User_Covoiturage AS UC ON Comment.user_covoiturage_id = UC.id
INNER JOIN Covoiturage AS C ON UC.covoiturage_id = C.id
INNER JOIN Voiture AS V ON C.voiture_id = V.id
INNER JOIN User AS Driver ON V.user_id = Driver.id
INNER JOIN User AS Passager ON UC.user_id = Passager.id;

SELECT * FROM Commentaire;

SELECT * FROM Covoiturage WHERE id = 16;
SELECT * FROM Statut;


INSERT INTO Commentaire(commentaire, user_covoiturage_id) 
VALUES ("Voici un test comme quoi cette partie fonctionne, test 2", 24);
/* ESPACE EMPLOYÉ */

SELECT * FROM Role;

UPDATE User 
SET role_id = 4
WHERE id = 66;


SELECT * FROM User WHERE id =66;


/* Espace Admin */

INSERT INTO Role(libelle) VALUES("Administrateur");
SELECT * FROM Role;

SELECT * FROM User WHERE id = 67;

SELECT COUNT(pseudo) FROM User;
SELECT * FROM User WHERE role_id IS NOT NULL;

DELETE FROM User WHERE role_id IS NULL;

UPDATE User
SET active = 1
WHERE id = 66;

DELETE FROM User WHERE id = 35;	

SELECT User.id, pseudo, mail, Role.libelle as user_role, nb_credits
FROM User
INNER JOIN Role ON User.role_id = Role.id;

SELECT * FROM User WHERE active = 0;

ALTER TABLE User ADD COLUMN active BOOLEAN DEFAULT 1;

/* Nombres des covoiturages par jour */

SELECT * FROM Covoiturage GROUP BY date_heure_depart;

SELECT * FROM Covoiturage ORDER BY date_heure_depart ASC;

SELECT COUNT(id) FROM Covoiturage;

SELECT prix FROM Covoiturage WHERE date_heure_depart = "2025-02-04";

SELECT * FROM Covoiturage;

SELECT Covoiturage.*, User.id AS driver_id 
FROM Covoiturage
INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
INNER JOIN User ON Voiture.user_id = User.id
ORDER BY date_heure_depart ASC;


UPDATE User SET active = 1 WHERE id = 47;

/* combien la plateforme gagne de crédit en fonction des jours */

SELECT * FROM User_Covoiturage;

/* Avec cette requete on peut savoir combien de credits la plataforme a gagne par jour 
selon la participation dans le covoiturage*/
SELECT c.id AS covoiturage_id,DATE(c.date_heure_depart) AS jour,
COUNT(UC.id) * 2 AS gain_journalier,
COUNT(DISTINCT c.id) AS nb_trajets
FROM covoiturage c
INNER JOIN User_Covoiturage UC ON UC.covoiturage_id = c.id
/*WHERE UC.statut_id = 4*/
GROUP BY c.id, jour
ORDER BY jour ASC;

SELECT * FROM Covoiturage WHERE id = 16;

SELECT * FROM Covoiturage WHERE id = 16;
SELECT * FROM User_Covoiturage;

UPDATE Covoiturage SET statut_id = 1 WHERE id = 16;

ALTER TABLE User_Covoiturage
ADD statut_id INT UNSIGNED;

SELECT * FROM User_Covoiturage WHERE user_id = 65 AND covoiturage_id = 16;
UPDATE User_Covoiturage 
SET statut_id = null
WHERE covoiturage_id = 16 AND user_id = 65;

ALTER TABLE User_Covoiturage
ADD FOREIGN KEY (statut_id) REFERENCES Statut(id);

DESCRIBE User_Covoiturage;

SELECT 
DATE_FORMAT(c.date_heure_depart, '%d-%m-%Y') AS jour,
COUNT(DISTINCT c.id) AS nb_trajets,
COUNT(uc.id) * 2 AS gain
FROM covoiturage c
LEFT JOIN user_covoiturage uc ON uc.covoiturage_id = c.id
GROUP BY jour
ORDER BY STR_TO_DATE(jour, '%d-%m-%Y') ASC;


SELECT * FROM Covoiturage;


