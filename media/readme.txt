add symbolic link to this directory form /var/www/html/media

cd /var/www/html; mkdir media; cd media;
ln -s <link_to_django_media_folder> media
