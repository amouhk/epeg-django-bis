from django.urls import path
from . import views

urlpatterns = [
    path('accueil',     views.home),
    path('about',       views.about),
    path('activity',    views.activity),
    path('gallery',     views.gallery_photo),
]