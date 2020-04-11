import django
from django.db import models


# Create your models here.
class Gallery(models.Model):
    id = models.IntegerField(primary_key=True)
    name = models.CharField(max_length=25)
    ALBUM_CHOICES = (('Photo', 'PHOTO'), ('Video', 'VIDEO'),)
    type = models.CharField(max_length=6, choices=ALBUM_CHOICES)
    album = models.CharField(max_length=25)
    filepath = models.TextField()


class Predication(models.Model):
    id = models.IntegerField(primary_key=True)
    titre = models.TextField(max_length=100)
    predicateur = models.CharField(max_length=25)
    description = models.TextField()
    date = models.DateField(default=django.utils.timezone.now)
    cheminFichier = models.TextField()
    type = models.CharField(max_length=25)
    artwork = models.TextField()
    cheminNotes = models.TextField()



