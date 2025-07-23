<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- main -->
<section class="container my-5 bg-light shadow-lg rounded-4 p-4 p-md-5">
    <form method="post" class="contact-form">
        <!-- Titre -->
        <h2 class="text-primary headline-text fw-bold mb-4 text-center">Contactez nous</h2>
        <!-- Pseudo et Email-->
        <div class="row g-4">
            <!-- Pseudo -->
            <div class="col-md-6">
                <label for="Pseudo" class="form-label text-dark content-text fw-semibold">Pseudo</label>
                <input type="text" name="Pseudo" id="Pseudo"
                    class="form-control bg-light small-text form-control-lg shadow-sm"
                    placeholder="Juanito" required>
            </div>
            <!-- Email -->
            <div class="col-md-6">
                <label for="email" class="form-label text-dark content-text fw-semibold">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control bg-light small-text form-control-lg shadow-sm"
                    placeholder="juanito@gmail.com" required>
            </div>
        </div>
        <!-- Message -->
        <div class="content-text mt-4">
            <label for="message" class="form-label text-dark content-text fw-semibold">Message</label>
            <textarea name="message" id="message" class="form-control bg-light small-text form-control-lg shadow-sm"
                placeholder="Votre message" required></textarea>
        </div>
        <!-- Bouton pour envoyer le formulaire -->
        <button type="submit" class="btn btn-warning btn-lg text-dark content-text fw-semibold 
        w-50 mx-auto d-block mt-4">
            Envoyer
        </button>
    </form>
</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>