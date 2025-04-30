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
                </tr>
            </thead>
            <tbody>
                <!-- On parcour le tableau des utilisateurs pour remplir la table avec les données de chaque user-->
                <?php foreach ($allUsers as $user) { ?>
                    <tr>
                        <th scope="row" class="id-row"><?= $user['id'] ?></th>
                        <td><?= $user['pseudo'] ?></td>
                        <td><?= $user['mail'] ?></td>
                        <td><?= $user['user_role'] ?></td>
                        <td><?= $user['nb_credits'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>


<?php
// FOOTER
require_once './Templates/footer.php';
?>