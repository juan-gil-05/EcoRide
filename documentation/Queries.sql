/* Voici un fichier .sql avec plusieurs requêtes qui sont été 
utilisées pour la gestion de la base des données MySQL. */


-- Création de la base de donées
CREATE DATABASE ecorideDB;

-- Création de lutilisateur, le mot de passe n'est pas affiché
CREATE USER 'juandb'@'localhost' IDENTIFIED BY mot_de_passe;

-- Ajouter tous les droits a lutilisateur 
GRANT ALL PRIVILEGES ON *.* TO 'juandb'@'localhost' WITH GRANT OPTION;

-- Blocage de lutilisateur root
ALTER USER 'root'@'localhost' ACCOUNT LOCK;

USE ecorideDB;

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

/* Pour voir tous les constraints de la table */
SELECT CONSTRAINT_NAME
FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
WHERE TABLE_NAME = 'User_Covoiturage'
AND CONSTRAINT_TYPE = 'FOREIGN KEY';

/* Ici on elimine la constraint de la foreign key de la table User_Covoiturage
pour en ajouter une nouvelle avec le ON DELETE CASCADE, comme ca, si l'user chauffeur supprime 
un covoiturage, alors, tous ces covoiturages qu'eteint dans la table User_Covoiturage seront supprimés
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
ADD statut_id int UNSIGNED;

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


