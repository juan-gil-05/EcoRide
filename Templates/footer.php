</main>

<footer>
    <div class="footer small-text">
        <!--Les informations du footer-->
        <div class="footer-info">
            <!--Mail-->
            <p>contact@ecoride.fr</p>
            <div class="separator"></div>
            <!--Nom-->
            <p class="principal content-text">EcoRide</p>
            <div class="separator"></div>
            <!--Mentions légales-->
            <p>Mentions légales</p>
        </div>
        <!--Petit text du footer-->
        <p class="text">Réduisez votre empreinte écologique en covoiturant.</p>
        <!--Le copyright-->
        <p class="copyright ligne">© 2024 EcoRide. Tous droits réservés.</p>
    </div>
</footer>

<!--Import du JS du Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<!-- Import du JS pour la librairie DataTable -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
<!-- Import du JS pour la librairie Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Import du propre JS-->
<?php
// Tableau avec les scripts js pour chaque page, dont l'action est la clé et les scripts les valeurs
$scripts = [
    'showAll' => ['driverNote.js'],
    'validateCovoiturage' => ['driverNote.js', 'validateCovoiturage.js'],
    'logIn' => ['showPassword.js'],
    'singUp' => ['showPassword.js', 'driverForm.js'],
    'preferencesInscription' => ['preferencesForm.js'],
    'profil' => ['preferencesForm.js'],
    'accueil' => ['searchCovoiturage.js'],
    'mesCovoiturages' => ['startCovoiturage.js'],
    'validateAvisAndComments' => ['employeEspace.js'],
    'adminEspace' => ['showPassword.js', 'adminEspace.js'],
    'adminGraphs' => ['adminGraphs.js']
];
// Pour récupérer l'action dans l'url 
$currentAction = $_GET['action'] ?? '';
// Si l'action est dans le tableau, alors, 
// on parcours le tableau et on crée une balise script pour chaque script de l'action
if (isset($scripts[$currentAction])) {
    foreach ($scripts[$currentAction] as $script) {
        echo "<script src=\"../Scripts/{$script}\"></script>\n";
    }
}
?>
</body>

</html>