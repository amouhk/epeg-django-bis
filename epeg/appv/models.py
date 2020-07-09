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

EMPTY_CHOICES = (
    ('Autre', 'Autre'),
)


# Create your models here.
class Gallery(models.Model):
    id = models.AutoField(primary_key=True)
    name = models.CharField(max_length=25, default="name")
    type = models.CharField(max_length=6, choices=ALBUM_CHOICES)
    album = models.CharField(max_length=25)
    filepath = models.FileField()

    class Meta:
        db_table = "gallery"


class Predication(models.Model):
    # id = models.AutoField(primary_key=True)
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


class Agenda(models.Model):
    date = models.DateField(default=django.utils.timezone.now)
    filepath = models.FileField()
    name = models.TextField(max_length=50)

    class Meta:
        db_table = "agenda"

class MeditationFluxRss(models.Model):
    title = models.CharField(max_length=200)
    link = models.CharField(max_length=2048)
    desc = models.TextField(null=True, blank=True)
    date = models.DateTimeField()

class Meditation(models.Model):
    reference = models.CharField(max_length=200)
    desc = models.TextField(null=True, blank=True)
    date = models.DateField(default=django.utils.timezone.now)

    class Meta:
        db_table = "meditation"