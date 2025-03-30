 <!-- Pour afficher les messages d'information avec SweetAlert quand l'utilisateur fait une action, 
 par exemple : quand il ajoute un covoiturage, quand il modifie un covoiturage, quand il supprime un covoiturage, etc...
 -->
 <?php if (!empty($_SESSION['message_to_User']) && $_SESSION['message_code'] != "") { ?>
     <script>
         // On affiche le message
         Swal.fire({
             title: '<?= $_SESSION['message_to_User'] ?>',
             icon: '<?= $_SESSION['message_code'] ?>',
         }).then(() => {
             // Pour recharger la page
             window.location.href = window.location.pathname + window.location.search;
         })
     </script>
 <?php
        // Après d'avoir afficher le message, on supprime la session
        unset($_SESSION['status']);
    } ?>