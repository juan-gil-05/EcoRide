<?php
// HEADER
require_once './Templates/header.php';

// /** @var \App\Security\UserValidator $ */
?>

<!-- main -->
<div class="container mt-4">
    <form method="post">
        <div>
            <label for="nom">nom</label>
            <input type="text" name="pseudo">
            <?php if (isset($errors['pseudo'])) { ?>
                <div><?= $errors['pseudo'] ?></div>
            <?php } ?>
        </div>
        <br>
        <div>
            <label for="nom">mail</label>
            <input type="text" name="mail">
            <?php if (isset($errors['mail'])) { ?>
                <div><?= $errors['mail'] ?></div>
            <?php } ?>
        </div>
        <br>
        <div>
            <label for="nom">mdp</label>
            <input type="password" name="password">
        </div>
        <?php if(isset($errors['password'])) { ?>
            <div ><?=$errors['password'] ?></div>
        <?php } ?>
        <br>
        <input type="submit" name="singUp" value="créer">
    </form>
</div>

<?php
// FOOTER
require_once './Templates/footer.php';
?>