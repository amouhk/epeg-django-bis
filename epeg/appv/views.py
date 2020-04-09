from django.http import Http404
from django.shortcuts import render

from appv.models import GalleryItem


def home(request):
    return render(request, 'appv/index.html', locals())


def about(request):
    welcome = "Bienvenue à l 'Église Protestante Évangélique \n aux Gobelins"
    return render(request, 'appv/about-us.html', locals())


def activity(request):
    welcome = "Bienvenue à l 'Eglise Protestante Evangélique \n aux Gobelins"
    announce = "appv/pdf/programme_avril_2020.pdf"
    return render(request, 'appv/activity.html', locals())


def gallery_photo(request):
    photos = GalleryItem.objects.all()
    albums = GalleryItem.objects.values('album').distinct()
    print(albums)
    welcome = "Bienvenue à l 'Eglise Protestante Evangélique \n aux Gobelins"
    # GalleryItem.objects.filter(type__contains="Photo")
    return render(request, 'appv/gallery.html', locals())


def gallery_video(request):
    videos = GalleryItem.objects.all()
    welcome = "Bienvenue à l 'Eglise Protestante Evangélique \n aux Gobelins"
    return render(request, 'appv/gallery.html', locals())
