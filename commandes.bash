# Création d'un fichier de documentation
touch Readme.md

# Initialisation du dépôt Git
git init

# Ajout du fichier à la zone de staging
git add Readme.md

# Premier commit 
git commit -m "First commit"

# Changement du nom de la branche principal
git branch -M main

# Lien vers le dépôt distant sur GitHub
git remote add origin https://github.com/juan-gil-05/EcoRide.git

# Envoi de la branche principale vers le dépôt distant
git push -u origin main




# Créer une branche issue de la branche développement
git checkout développement
git checkout -b contact_page

# Ajouter un fichier et le versionner
touch contact-page.php
git add contact-page.php
git commit -m "Ajout de la page de contact"

# Pousser la branche sur GitHub
git push -u origin contact_page

# Fusionner la branche dans développement
git checkout développement
git merge contact_page
git push

# Fusionner développement dans main (après validation)
git checkout main
git merge développement
git push
