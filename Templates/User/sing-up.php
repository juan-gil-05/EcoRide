<?php
// HEADER
require_once './Templates/header.php';

// /** @var \App\Security\UserValidator $ */
?>

<section class="container mt-4">
    <form>
        <h1 class="h3 mb-3 text-center">Please sign in</h1>
    
        <div class="form-floating">
          <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Email address</label>
        </div>
        
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>
    
        <div class="form-check text-start my-3">
          <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Remember me
          </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-body-secondary">© 2017–2024</p>
      </form>
</section>




  <!-- main -->
<!-- <div class="container mt-4">
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
</div> -->

<?php
// FOOTER
require_once './Templates/footer.php';
?>