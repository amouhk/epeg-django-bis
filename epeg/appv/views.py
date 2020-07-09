import pprint

from django.http import Http404
from django.shortcuts import render
from django.core.mail import send_mail
from django_user_agents.utils import get_user_agent
from time import mktime
from django.utils.datetime_safe import datetime
import feedparser
from bs4 import BeautifulSoup

from .models import Gallery, Predication, Agenda, MeditationFluxRss
from .forms import ContactForm



FEEDS_LINK_E21_DON_CARSON = "https://evangile21.thegospelcoalition.org/dieu-qui-se-devoil/feed/"

def home(request):
    sermon_latest = Predication.objects.order_by('date').reverse()[0]
    
    meditation = MeditationFluxRss()
    feed_parser = feedparser.parse(FEEDS_LINK_E21_DON_CARSON)
    if feed_parser['entries'][0]:
        meditation.title = feed_parser['entries'][0].title
        meditation.link = feed_parser['entries'][0].link
        soup = BeautifulSoup(feed_parser['entries'][0].description)
        meditation.desc = soup.get_text()
        meditation.date = datetime.fromtimestamp(mktime(feed_parser['entries'][0].published_parsed))
       # meditation.save()

    return render(request, 'appv/index.html', locals())


def about(request):
    welcome = "Bienvenue à l 'Église Protestante Évangélique \n aux Gobelins"

    # Mail sending request
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = ContactForm(request.POST)
        # check whether it's valid:
        if form.is_valid():
            send_mail(
                subject=str(form["subject"].value()),
                message=str(form['message'].value()),
                from_email='kevin.amouh@gmail.com',
                recipient_list=[str(form['email'].value())],
                fail_silently=False
            )

        form.clean()
        form = ContactForm()

    else:
        form = ContactForm()

    return render(request, 'appv/about-us.html', locals())


def activity(request):
    welcome = "Bienvenue à l 'Eglise Protestante Evangélique \n aux Gobelins"
    agenda_svr_path = "http://82.64.149.128/media/"
    agenda_current = Agenda.objects.all()[:1].get()
    return render(request, 'appv/activity.html', locals())


def gallery(request):
    welcome = "Bienvenue à l 'Eglise Protestante Evangélique \n aux Gobelins"
    gallery_svr_path = "http://82.64.149.128/media/"
    albums = Gallery.objects.values('album').distinct()
    photos = Gallery.objects.filter(type="Photo")
    videos = Gallery.objects.filter(type="Video")
    return render(request, 'appv/gallery.html', locals())


def sermon(request):
    welcome = "Bienvenue à l 'Eglise Protestante Evangélique \n aux Gobelins"
    audio_svr_path = "http://82.64.149.128/media/"
    audio_doc_svr_path = "http://82.64.149.128/media/"
    sermons = Predication.objects.order_by('date').reverse()
    device_mobile = 0
    user_agent = get_user_agent(request)
    if user_agent.is_mobile or user_agent.is_tablet:
        device_mobile = 1
    return render(request, 'appv/sermon.html', locals())
