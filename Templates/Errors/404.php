<?php
// HEADER
require_once './Templates/header.php';
?>

<!-- main -->
<div class="container text-white mt-3">
    <h1>404 - Page introuvable</h1>
    <p>oups, il semble que cette page n'existe pas</p>
    <p>Error : <?=$error;?></p>
    <a href="?controller=page&action=accueil" class="text-warning">Retour vers la page d'accueil</a>
</div>

<?php
// FOOTER
require_once './Templates/footer.php';
?>