from django.contrib import admin

# Register your models here.
from django.contrib import admin
from .models import Predication, Gallery

admin.site.register(Gallery)
admin.site.register(Predication)