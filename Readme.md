# 🚘 EcoRide — Application de covoiturage

EcoRide est une startup française dont l'objectif est de réduire l'impact environnemental des déplacements en promouvant le covoiturage. Cette plateforme web, pensée pour les voyageurs soucieux de l’écologie et de leur budget, propose une solution pratique, économique et respectueuse de la planète.

## 🚀 Fonctionnalités principales

- Inscription / Connexion des utilisateurs
- Gestion de profils utilisateurs (chauffeurs / passagers)
- Personnalisation des préférences des chauffeurs
- Création et recherche de trajets en covoiturage
- Filtrer la recherche des covoiturages
- Validation du trajet par les passagers
- Interface employé pour modérer les trajets et avis
- Interface Administrateur pour la modération des comptes et la visualisation des graphiques dynamiques
- Notifications par email (phpMailer) et alertes (SweetAlert)
- Base de données MySQL et MongoDB
- Système de notes et d’avis

## 🛠️ Technologies utilisées

- HTML, CSS (Sass & Bootstrap 5.3), JavaScript
- PHP 8.4.5 (sans framework)
- MySQL & MongoDB
- PHPMailer pour les envois de mails
- SweetAlert pour les messages utilisateurs
- DataTables (JavaScript Bibliothèque)
- Chart JS (JavaScript Bibliothèque)
- Composer
- NPM

## 📦 Prérequis

- PHP >= 8.1
- Serveur web local (ex. : [XAMPP](https://www.apachefriends.org/), [MAMP](https://www.mamp.info/))
- MySQL 
    - ([Doc pour l'installation en Windows](https://dev.mysql.com/downloads/installer/))
    - ([Doc pour l'installation en macOS avec Homebrew](https://formulae.brew.sh/formula/mysql))
- MongoDB 
    - ([Doc pour l'installation en Windows](https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-windows/))
    - ([Doc pour l'installation en macOS](https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-os-x/))
- Composer ([Doc pour l'installation](https://getcomposer.org/download/))
- NPM ([Doc pour l'installation](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm))
- Driver PHP MongoDB (voir ci-dessous)

## 💻 Étapes pour déployer le projet en local

1. **Cloner le dépôt Git :**

    ```bash
    git clone https://github.com/juan-gil-05/EcoRide.git
    ```

2. **Déplacer les fichiers dans le répertoire de votre serveur local :**

    Par exemple pour MAMP :
    ```console
    mv EcoRide /Applications/MAMP/htdocs/
    ```

3. **Installer les dépendances**

    Depuis la racine de votre projet faites :

    ```bash
    composer install
    ````

    ```bash
    npm install
    ```

4. **Créer la base de données MySQL :**

    -   Crée une base de données depuis phpMyAdmin ou un client SQL. 
    -	Importer le fichier ecorideDB.sql disponible dans data/

5. **Créer la base de données MongoDB :**

    -   Crée une base de données depuis MongoDB Compass ou un client Mongo.
    -   Crée une nouvelle collection appelée 'Avis' 
	-	Importer le fichier EcoRideMongo.json disponible dans data/ dans la collection 'Avis'

6. **Configurer les accès aux bases de données :**

    1. Dans le fichier .env.exemple, adapter vos identifiants MySQL et MongoDB :
        ```dotenv
        # === MYSQL ===
        DB_NAME=db_name
        DB_USER=db_user
        DB_PASSWORD=db_password
        DB_PORT=port
        DB_HOST=host

        # === MONGODB ===
        MONGO_DB_NAME=mongo_db_name
        MONGO_DB_USER=mongo_db_user
        MONGO_DB_PASSWORD=mongo_db_password
        MONGO_DB_HOST=mongo_db_host
        MONGO_DB_PORT=port
        ```
    2. enlevez le .exemple, afin que le fichier soit lisible en tant que variables d'environement
        >🔐 Ne versionnez jamais le fichier `.env` : ajoutez-le dans votre fichier `.gitignore`.
    3. Dans le fichier App/Db/Mongodb.php -> decommentez la ligne 52 avec le string de connexion à Mongodb en local et commentez la ligne 54 avec le string de connexion à Mongodb Atlas. 
    Voici le code attendu :
        ```php
        try {
            // Connection string en LOCAL
            $connectionPath = "mongodb://".$user.":".$password."@".$host.":".$port."/".$dbName;
            // Connection string en mongoDB Atlas
            // $connectionPath = "mongodb+srv://" . $user . ":" . $password . "@" . $host . "/?retryWrites=true&w=majority&appName=" . $dbName;
            // Instance de la classe Client
            $mongo = new Client($connectionPath);
            $db = $mongo->selectDatabase($dbName); // Sélection de la base de données
            // On retourne l'instance de la base de données
            return $db;
        } catch (Exception $e) {
            echo ('Error : ' . $e->getMessage());
            exit;
        }
        ```
    4. Installation du driver PHP pour MongoDB (si non déjà installée)
    
        > L'application utilise MongoDB via la librairie `mongodb/mongodb`, qui nécessite l'extension PHP native `mongodb`.

        - Installer via [PECL](https://pecl.php.net), depuis la terminal:
            ```bash
            pecl install mongodb
            ```

        - Activer l'extension dans le fichier `php.ini` :
            Ouvrez le fichier `php.ini` et ajoutez cette ligne :
            ```ini
            extension=mongodb.so
            ```

        - Vérifier que l'extension est active :
            ```bash
            php -m | grep mongodb
            ```
             ➜ Si la ligne `mongodb` s’affiche, tout est bon ✅

   

7. **Configuration SMTP pour l'envoi d'emails (en local)**

    L'envoi d'e-mails est géré via PHPMailer. Pour tester les envois d'emails en local sans envoyer de véritables courriels, vous pouvez utiliser [Mailtrap](https://mailtrap.io/).

    **Étapes :**

    1. Créez un compte gratuit sur [Mailtrap](https://mailtrap.io/).
    2. Créez une Inbox et récupérez les informations SMTP dans "SMTP Settings" (choisir "PHP Mailer").
    3. Copiez les informations dans votre fichier `.env` :

    ```dotenv
    SMTP_HOST=sandbox.smtp.mailtrap.io
    SMTP_PORT=2525
    SMTP_USER=your_mailtrap_username
    SMTP_PASSWORD=your_mailtrap_password
    SMTP_FROM_NAME=EcoRide (DEV)
    SMTP_FROM_EMAIL=no-reply@ecoride.dev
    ````
    > 💡 Dans le fichier App/Tools/SendMail.php, assurez-vous d’utiliser le bon port et le bon protocole :
    - Par exemple:
        ```php
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Utilise TLS
        $mail->Port       = 2525;                           // Port utilisé par Mailtrap avec TLS
        ```

8. **Lancer l'application**

    1. Démarrer votre serveur Apache/Nginx et MySQL.
    2. Accéder à l'application
        - Par exepmle via :  
            [http://localhost:8888/EcoRide/Public/](http://localhost:8888/EcoRide/public/)
    3. Vous pouvez maintenant utiliser EcoRide en local !



## 👥 Auteur

    Développé par Juan Gil
    Contact : gilj06@hotmail.com
    