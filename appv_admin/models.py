import django
from django.db import models

ALBUM_CHOICES = (
    ('Photo', 'Photo'),
    ('Video', 'Video'),
)

EMPTY_CHOICES = (
    ('Autre', 'Autre'),
)


# Create your models here.
class Predication(models.Model):
    # id = models.AutoField(primary_key=True)
    title = models.TextField(max_length=100)
    predicator = models.CharField(max_length=25)
    description = models.TextField()
    date = models.DateField(default=django.utils.timezone.now)
    audio = models.FileField(default=None, blank=True, null=True, upload_to='audio/%Y/')
    type = models.CharField(max_length=25)
    avatar = models.FileField(default=None, blank=True, null=True)
    note = models.FileField(default=None, blank=True, null=True, upload_to='doc/%Y/')

    class Meta:
        managed = False
        db_table = "predication"


class Agenda(models.Model):
    date = models.DateField(default=django.utils.timezone.now)
    filepath = models.FileField(upload_to='agenda/%Y/')
    name = models.TextField(max_length=25, default="")

    class Meta:
        managed = False
        db_table = "agenda"


class Gallery(models.Model):
    id = models.AutoField(primary_key=True)
    name = models.CharField(max_length=25, default="name", blank=True, null=True)
    type = models.CharField(max_length=6, choices=ALBUM_CHOICES)
    album = models.CharField(max_length=25)
    filepath = models.FileField(upload_to="")

    class Meta:
        managed = False
        db_table = "gallery"
