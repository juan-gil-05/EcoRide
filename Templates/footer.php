<?php

use App\Tools\StringTools;

?>
</main>

<footer>
    <div class="footer small-text">
        <!--Les informations du footer-->
        <div class="footer-info">
            <!--Mail-->
            <p>contact@ecoride.fr</p>
            <div class="separator"></div>
            <!--Nom-->
            <a class="principal content-text text-white" href="/page/accueil">EcoRide</a>
            <div class="separator"></div>
            <!--Mentions légales-->
            <a href="/page/mentions-legales" class="text-white">Mentions légales</a>
        </div>
        <!--Petit text du footer-->
        <p class="text">Réduisez votre empreinte écologique en covoiturant.</p>
        <!--Le copyright-->
        <p class="copyright ligne">© 2025 EcoRide. Tous droits réservés.</p>
    </div>
</footer>

<!--Import du JS du Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous">
</script>
<!-- Import du JS pour la librairie DataTable -->
<?php
// Pour récupérer l'action dans l'url
$url = $_GET['url'] ?? "";
$url = trim($url, '/');
$segments = explode('/', $url);

$currentAction = ($segments[1]) ? StringTools::toCamelCase($segments[1]) : "accueil";

if (isset($currentAction) && $currentAction == 'espace') { ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
<?php } ?>
<!-- Import du JS pour la librairie Chart.js -->
<?php if (isset($currentAction) && $currentAction == 'graphique') { ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php } ?>
<!-- Import du propre JS-->
<script src="/Scripts/loader.js"></script>
<?php
// Tableau avec les scripts js pour chaque page, dont l'action est la clé et les scripts les valeurs
$scripts = [
    'tous' => ['driverNote.js'],
    'validerCovoiturage' => ['driverNote.js', 'validateCovoiturage.js'],
    'connexion' => ['showPassword.js'],
    'inscription' => ['showPassword.js', 'driverForm.js'],
    'profil' => ['preferencesForm.js'],
    'mesCovoiturages' => ['startCovoiturage.js'],
    'avisCommentaires' => ['employeEspace.js'],
    'espace' => ['showPassword.js', 'adminEspace.js'],
    'graphique' => ['adminGraphs.js']
];

// Si l'action est dans le tableau, alors,
// on parcours le tableau et on crée une balise script pour chaque script de l'action
if (isset($scripts[$currentAction])) {
    foreach ($scripts[$currentAction] as $script) {
        echo "<script src=\"/Scripts/{$script}\"></script>\n";
    }
}
?>
</body>

</html>