<?php
// HEADER
require_once './Templates/header.php';
?>

<!-- main -->
<div class="container mt-4">
    <form method="post">
        <div>
            <label for="nom">mail</label>
            <input type="text" name="mail">
        </div>
        <br>
        <div>
            <label for="nom">mdp</label>
            <input type="password" name="password">
        </div>
        <br>
        <input type="submit" name="logIn" value="Ingreser">
    </form>
</div>


<?php
// FOOTER
require_once './Templates/footer.php';
?>