
let icon = document.getElementById("showPasswordIcon");
let password = document.getElementById("floatingPassword");
let showPasswordText = document.getElementById("showPasswordText");


icon.addEventListener('click', function(){
    if(password.type == "password"){
        password.type = "text"
        icon.classList.toggle('bi-square');
        icon.classList.toggle('bi-check-square');
        showPasswordText.textContent = "Cacher le mot de passe";
    } else {
        password.type = "password"
        icon.classList.toggle('bi-check-square');
        icon.classList .toggle('bi-square');
        showPasswordText.textContent = "Afficher le mot de passe";

    }
})





