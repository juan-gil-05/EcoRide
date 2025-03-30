<!-- Pour afficher les message de succès quand l'user participe dans un covoiturage, ou annule sa participation -->
<?php if (!empty($_SESSION['successParticipation'])) { ?>
    <script>
        // On affiche le message de succès
        Swal.fire({
            title: '<?= $_SESSION['successParticipation'] ?>',
            icon: "success",
        }).then(() => {
            // on envoi ver la page de mes covoiturages et on affiche tous les covoiturages auxquels l'utilisateur participe 
            window.location.href = "?controller=covoiturages&action=mesCovoiturages"
        })
    </script>
<?php
    // Après d'avoir afficher le message, on supprime la session
    unset($_SESSION['successParticipation']);
} elseif (!empty($_SESSION['covoiturageDeletedMsg'])) { ?>
    <script>
        // On affiche le message de succès
        Swal.fire({
            title: '<?= $_SESSION['covoiturageDeletedMsg'] ?>',
            icon: "success",
        }).then(() => {
            // on envoi ver la page de mes covoiturages
            window.location.href = "?controller=covoiturages&action=mesCovoiturages"
        })
    </script>
<?php }
// Après d'avoir afficher le message, on supprime la session
unset($_SESSION['covoiturageDeletedMsg']);
?>