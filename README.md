epeg-django-bis is a fork form v1.0 version of https://github.com/amouhk/epeg_django.git
Please do not modify this projet. It is here to historical commit.

**---------------** **-------------** **---------------**

Dépot officiel du site web de l'Eglise des Gobelins.
Tous les autres dépots sont obsolétes.
Ce dépot est à mettre sur le hébergeur. Ce nouveau site web utilise le framework django.
Son installation est donc differents des sites web classique.

/!\ Ne pas copier ses fichiers directement dans le repertoire web /!\ 


Installation :

1. Cloner le depot dans le repertoire home de votre système.

    cd $HOME
    git clone https://github.com/amouhk/epeg-django-bis.git www.my-domaine-name.com


2. Creer des fichiers avec des informations utiles pour le site django

    Creer ces fichiers dans le repertoire $HOME avec uniquement comme contenu une ligne
    avec l'info.

    - Le nom de votre site : domain_name.txt

    - Mot de passe django: django_secret_key.txt

    - Mot de passe de la base de donnée : django_db_password_key.txt

    - Mot de passe de l'email (pour la prise de contact) : django_host_mail_key.txt

    Example: 
        si mon site est www.example.com 
        echo "www.example.com" > domain_name.txt

3. Gestion des liens "static" et les "media"

    Seuls ses 2 dossiers seront gérés par les serveurs web "apache" ou "nginx"

    Créer le dossier "media" dans $HOME/www.my-domain-name.com
    Le dossier static existe déjà.

    Faire pointer le serveur web apache vers ses dossier:
    cd /var/www/html
    ln -s $HOME/www.my-domain-name.com/media media
    ln -s $HOME/www.my-domain-name.com/static static

4. Deployer le site web

Le site actuel est deployer avec pythonanywhere.com 




