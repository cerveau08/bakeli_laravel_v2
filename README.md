## BAKELI SI API V2
Système d'information de Bakeli


# Installation
Ce projet est fait avec Laravel 6, Infyom Generator avec CoreUI Templates, JWT Authorization, Fruitcake CORS.
Avant de commencer, veuiller verifier les configurations requises du serveur dans la Documentation officielle de [Laravel](https://laravel.com/docs/6.x/installation), de [Infyom](https://labs.infyom.com/laravelgenerator/docs/6.0/introduction) et [Tymon JWT Auth](https://jwt-auth.readthedocs.io/en/docs/laravel-installation/)

- **Cloner le projet avec la commande git clone git@gitlab.com:volkeno/bakelisi-api-laravel6-v2.git <nom_de_votre_projet>**
- **Déplacer vous dans le dossier du projet : cd nom_de_votre_projet**
- **Crer votre branche : git checkout -b <nom_de_votre_branche>**
- **Installer les dépendances avec la commande : composer install**
- **Copier le fichier .env.example en .env**
- **Renseignez les informations de votre base de donnees**
- **Générez une nouvelle clé avec la commande : php artisan key:generate**
- **Générez un token : php artisan jwt:secret**
- **Lancez votre premiere migration avec la commande : php artisan migrate**

# Happy Coding