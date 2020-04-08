from django.http import HttpResponse
from django.shortcuts import render


def home(request):
    return render(request, 'appv/index.html', locals())


def about(request):
    welcome = "Bienvenue à l 'Eglise Protestante Evangélique \n aux Gobelins"
    return render(request, 'appv/about-us.html', locals())


def activity(request):
    welcome = "Bienvenue à l 'Eglise Protestante Evangélique \n aux Gobelins"
    announce = "appv/pdf/programme_avril_2020.pdf"
    return render(request, 'appv/activity.html', locals())
