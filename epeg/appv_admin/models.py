import django
from django.db import models


# Create your models here.
class User(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField(max_length=100)
    password = models.CharField(max_length=100)

    class Meta:
        db_table = "user"


class Predication(models.Model):
    id = models.AutoField(primary_key=True)
    title = models.TextField(max_length=100)
    predicator = models.CharField(max_length=25)
    description = models.TextField()
    date = models.DateField(default=django.utils.timezone.now)
    audio = models.FileField()
    type = models.CharField(max_length=25)
    avatar = models.FileField()
    note = models.FileField()

    class Meta:
        managed = False
        db_table = "predication"
