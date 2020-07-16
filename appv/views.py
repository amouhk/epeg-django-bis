import pprint

from django.http import Http404
from django.shortcuts import redirect, render
from django.core.mail import send_mail
from django_user_agents.utils import get_user_agent
from time import mktime
from django.utils.datetime_safe import datetime
from django.views.decorators.clickjacking import xframe_options_exempt

from django.conf import settings as conf_settings

from .models import Gallery, Predication, Agenda, MeditationFluxRss
from .forms import ContactForm
from django import http



 

def home(request):
    MEDIA_URL =  conf_settings.MEDIA_URL # Get audio url 

    sermon_latest = Predication.objects.order_by('date').reverse()[0]
    return render(request, 'appv/index.html', locals())


def about(request):
    welcome = conf_settings.WELCOME_MSG
    MEDIA_URL =  conf_settings.MEDIA_URL  

    # Mail sending request
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = ContactForm(request.POST)
        # check whether it's valid:
        if form.is_valid():
           # Send confirm email to visitor 
            send_mail(
                subject=str("Confirmation de votre message à EPE des Goblelins"),
                message="Bonjour " + str(form.cleaned_data["name"]) + "\n,"  + 
                        "Vous avez ecris : " + "\n\n" +

                        str(form.cleaned_data['message']) + "\n\n"  +

                        str(""" Nous accusons de receptions votre pise de contact et vous repondrons rapidement.
                        
                        Fraternelement, 
                        L'église des Gobelins."""),

                from_email= conf_settings.EMAIL_HOST_USER,
                recipient_list=[str(form.cleaned_data['email'])],
                fail_silently=False
            )

           # Send visitor email to church official email 
            send_mail(
                subject = str("Prise de contact depuis votre site "),
                message="\n" + 
                        "Sujet : " + str(form.cleaned_data['subject'])  + "\n" + 
                        "Nom :" + str(form.cleaned_data['name']) + "\n" + 
                        "Email: " + str(form.cleaned_data['email'])  + "\n" + 
                        "Message: " + str(form.cleaned_data['message'])  + "\n",
                from_email = conf_settings.EMAIL_HOST_USER,
                recipient_list =[conf_settings.EMAIL_HOST_USER] ,
                fail_silently=False
            )
        
        form.clean()
        form = ContactForm()
        return http.HttpResponseRedirect('/appv/about#contact')

    else:
        form = ContactForm()

    return render(request, 'appv/about-us.html', locals())

@xframe_options_exempt
def activity(request):
    welcome = conf_settings.WELCOME_MSG
    MEDIA_URL = conf_settings.MEDIA_URL   

    agenda_current = Agenda.objects.order_by('date').last()
    agenda_history = Agenda.objects.order_by('date').reverse()
    return render(request, 'appv/activity.html', locals())


def gallery(request):
    welcome = conf_settings.WELCOME_MSG
    MEDIA_URL =  conf_settings.MEDIA_URL

    albums = Gallery.objects.values('album').distinct()
    photos = Gallery.objects.filter(type="Photo").reverse()
    videos = Gallery.objects.filter(type="Video").reverse()
    pprint.pprint(albums)
    return render(request, 'appv/gallery.html', locals())


def sermon(request):
    welcome = conf_settings.WELCOME_MSG
    MEDIA_URL =  conf_settings.MEDIA_URL
    
    sermons = Predication.objects.order_by('date').reverse()
    device_mobile = 0
    user_agent = get_user_agent(request)
    if user_agent.is_mobile or user_agent.is_tablet:
        device_mobile = 1
    return render(request, 'appv/sermon.html', locals())
