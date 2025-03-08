<?php

use App\Security\Security;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--Import des fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!--Import de Font Awesome pour les icons-->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!--Import des styles-->
    <link rel="stylesheet" href="./Styles/main.css" />
    <title>EcoRide</title>
</head>

<body>
    <header>
        <!--Navbar du site-->
        <nav class="navbar navbar-expand-lg bg-light header">
            <div class="container-fluid">
                <!--Logo du site-->
                <a class="navbar-brand headline-text" href="?controller=page&action=accueil">EcoRide</a>
                <!--Bouton du site en mode responsive-->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!--Le menu de la navbar-->
                <div
                    class="collapse navbar-collapse menu-list subtitle-text"
                    id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=page&action=accueil">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=covoiturages&action=showAll">Covoiturage</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <!-- On verifie si l'utilisateur est connecté ou pas pour afficher le message indicat -->
                        <li class="nav-item">
                            <?php if (Security::islogged()) { ?>
                                <a class="nav-link" href="?controller=user&action=profil">Mon profil<i class="ms-2 bi bi-person-circle"></i></a>
                            <?php } else { ?>
                                <a class="nav-link" href="?controller=auth&action=logIn">Se connecter</a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>