<?php
// HEADER
require_once './Templates/header.php';
?>

<!-- Formulaire pour valider que le covoiturage s'est bien passé -->
<section class="container mt-5 mb-5">
    <form method="post" class="content-text covoiturage-form-validate">
        <!-- Est-ce que le covoiturage c'est bine passé -->
        <div class="good-travel">
            <label class="form-label" for="">Est-ce que le covoiturage c'est bien passé?</label>
            <div class="checkbox-group">
                <!-- OUI -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="oui" name="questionRadio" id="yesCheckedRadio" required>
                    <label class="form-check-label" for="yesCheckedRadio">
                        Oui
                    </label>
                </div>
                <!-- NON -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="non" name="questionRadio" id="noCheckedRadio" required>
                    <label class="form-check-label" for="noCheckedRadio">
                        Non
                    </label>
                </div>
            </div>
            <!-- Si le covoiturage ne s'est pas bien passé, le passager peut laisser un comentaire -->
            <div class="comment-about-travel" id="commentAboutTravel">
                <textarea class="form-control" name="commentaire" rows="2" placeholder="Dites-nous ce qui n’a pas fonctionné 😕"></textarea>
            </div>
        </div>
        <!-- Pour donner une note au chauffuer -->
        <div class="driver-note">
            <!-- Le label et le text de '(facultatif)' -->
            <div>
                <label class="form-label" for="">Donner une note au chauffeur</label>
                <span class="small-text fst-italic">(facultatif)</span>
            </div>
            <!-- Étoiles pour noter le chauffeur -->
            <div class="note-stars">
                <!-- Input caché pour envoyer la valeur de la note du chauffeur, selon la quantité des étoiles séléctionées -->
                <input type="hidden" name="note" id="inputNote" value=""></input>
                <i class="bi bi-star-fill star" data-value="1"></i>
                <i class="bi bi-star-fill star" data-value="2"></i>
                <i class="bi bi-star-fill star" data-value="3"></i>
                <i class="bi bi-star-fill star" data-value="4"></i>
                <i class="bi bi-star-fill star" data-value="5"></i>
            </div>
        </div>
        <!-- Pour laisser un avis -->
        <div class="driver-comment">
            <!-- Le label et le text de '(facultatif)' -->
            <div>
                <label class="form-label" for="">Laisser votre avis</label>
                <span class="small-text fst-italic">(facultatif)</span>
            </div>
            <input type="text" name="titre" id="" class="form-control" placeholder="Titre">
            <textarea class="form-control" name="avis" rows="3" placeholder="Avis"></textarea>
        </div>
        </div>
        <!-- Bouton pour envoyer le formulaire -->
        <div>
            <button type="submit" class="btn btn-primary secondary-btn text-light" name="validateCovoiturageForm">Envoyer</button>
        </div>
    </form>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>