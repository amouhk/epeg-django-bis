import django
from django.db import models

ALBUM_CHOICES = (
    ('Photo', 'Photo'),
    ('Video', 'Video'),
)

TYPE_CHOICES = (
    ('Prédication', 'Prédication'),
    ('Témoignage', 'Témoignage'),
    ('Partage', 'Partage'),
    ('Autre', 'Autre'),
)


# Create your models here.
class Gallery(models.Model):
    id = models.AutoField(primary_key=True)
    name = models.CharField(max_length=25)
    type = models.CharField(max_length=6, choices=ALBUM_CHOICES)
    album = models.CharField(max_length=25)
    filepath = models.TextField()

    class Meta:
        db_table = "gallery"


class Predication(models.Model):
    id = models.AutoField(primary_key=True)
    title = models.TextField(max_length=100)
    predicator = models.CharField(max_length=25)
    description = models.TextField()
    date = models.DateField(default=django.utils.timezone.now)
    audio = models.FileField()
    type = models.CharField(max_length=25, choices=TYPE_CHOICES)
    avatar = models.FileField()
    note = models.FileField()

    class Meta:
        db_table = "predication"
