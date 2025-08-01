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
    <!-- DataTable JS library CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css" />
    <!-- Import les Bootstrap icons avec CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!--Import des styles-->
    <link rel="stylesheet" href="/Styles/main.css" />
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">

    <title>EcoRide – Covoiturage écologique et économique en France</title>
    <!-- Pour améliorer le SEO -->
    <meta name="description" content="EcoRide, la plateforme de covoiturage écologique et économique. Trouvez un trajet, partagez votre voyage et réduisez votre empreinte carbone.">

</head>

<body>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>
    <!-- Pour afficher le loader -->
    <div class="loader" id="loader"></div>

    <header>
        <!--Navbar du site-->
        <nav class="navbar navbar-expand-lg bg-light header">
            <div class="container-fluid">
                <!--Logo du site-->
                <a class="navbar-brand headline-text" href="/page/accueil">EcoRide</a>
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
                            <a class="nav-link" href="/page/accueil">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/covoiturage/tous">Covoiturage</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/page/contact">Contact</a>
                        </li>
                        <!-- On verifie si l'utilisateur est connecté ou pas pour afficher le message indicat -->
                        <li class="nav-item">
                            <?php if (Security::islogged()) { ?>
                                <a class="nav-link" href="/user/profil">
                                    Mon profil
                                    <i class="ms-2 bi bi-person-circle"></i>
                                </a>
                            <?php } else { ?>
                                <a class="nav-link" href="/auth/connexion">Se connecter</a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>