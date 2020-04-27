from django.urls import path
from . import views

urlpatterns = [
    path('login', views.login),
    path('home',  views.home),
    path('sermon',  views.sermon),
    path('agenda',  views.agenda),
    path('gallery', views.gallery),
]