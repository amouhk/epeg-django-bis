from django.contrib import admin

# Register your models here.
from django.contrib import admin
from .models import MediaAudio, GalleryItem

admin.site.register(GalleryItem)
admin.site.register(MediaAudio)