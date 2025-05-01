<?php
// HEADER
require_once './Templates/header.php';
?>

<!-- Section avec la table de tous les utilisateurs -->
<section class="container mt-5 mb-5">
    <!-- Div pour faire la table responsive -->
    <div class="table-responsive small-text">
        <table class="table table-hover user-table table-striped" id="userTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Role</th>
                    <th scope="col"># Crédits</th>
                    <th scope="col" class="actions-row">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Php avec les donées de la table -->
                <?php
                $modals = ''; // On initialise une variable pour stocker les modals qui sont générées automatiquement par DataTable
                // On parcour le tableau des utilisateurs pour remplir la table avec les données de chaque user
                foreach ($allUsers as $user) { ?>
                    <tr>
                        <th scope="row" class="id-row"><?= $user['id'] ?></th>
                        <td><?= $user['pseudo'] ?></td>
                        <td><?= $user['mail'] ?></td>
                        <td><?= $user['user_role'] ?></td>
                        <td><?= $user['nb_credits'] ?></td>
                        <!-- La collone avec les bouton d'action : Supprimer un utilisateur -->
                        <td class="actions-col"><i class="bi bi-trash-fill" data-bs-toggle="modal" data-bs-target="#deleteUserConfirm<?= $user['id'] ?>"></i></td>
                    </tr>
                    <!-- On ajout le html de la modale à la vaiable $modals -->
                    <?php $modals .= "
                        <div class='modal fade modal-delete-user' id='deleteUserConfirm{$user['id']}' tabindex='-1' aria-labelledby='deleteUserConfirmLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered'>
                                <div class='modal-content bg-light'>
                                    <div class='btn-close-div'>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <form method='post' class='gap-4 delete-user-form'>
                                        <input type='hidden' name='id' value='{$user['id']}'>
                                        <label class='content-text text-center fw-medium'>
                                            Voulez-vous vraiment supprimer le compte de <br>
                                            <strong>{$user['pseudo']}</strong>
                                            ({$user['mail']}) ?
                                         </label>
                                        <div class='d-flex gap-3 justify-content-center'>
                                            <input type='submit' class='btn btn-danger text-white small-text secondary-btn' value='Confirmer' name='deleteUser'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";
                    ?>
                <?php } ?>
            </tbody>
        </table>

    </div>
</section>
<!-- Section avec toutes les modales générées -->
<!-- Il faut appeler la modal en dehors de la table générée par DataTable, afin d'eviter des erreurs -->
<section>
    <!-- Appèl des modales -->
    <?= $modals ?>
</section>


<?php
// FOOTER
require_once './Templates/footer.php';
?>