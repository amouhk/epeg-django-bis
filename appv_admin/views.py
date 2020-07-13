import pprint

from django.shortcuts import render
from .forms import LoginForm, SermonForm, AgendaForm, GalleryForm, NewUserForm
from django.contrib.auth.hashers import make_password
from .models import Predication, Agenda, Gallery

from django.conf import settings as conf_settings
from django.contrib import auth
from django.contrib.auth.models import User
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect


# Create your views here.

def login(request):
    # Mail sending request
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = LoginForm(request.POST)
        # check whether it's valid:
        if form.is_valid():
            username = str(form['username'].value())
            password = str(form['password'].value())
            # pwd_hashed = make_password(password=password, salt=None)
            # print("{} {} {}".format(username, password, pwd_hashed))

            user = auth.authenticate(username=username, password=password)
            if user is not None and user.is_active:
                # print("Correct password, and the user is marked active")
                auth.login(request, user)
                # Redirect to a success page.
                return HttpResponseRedirect("/appv_admin/home")
            else:
                # print("uncorrect password, or the user is not marked active")
                # Show an error page
                return HttpResponseRedirect("/appv_admin/login")

    else:
        form = LoginForm()

    return render(request, 'appv_admin/login.html', locals())

@login_required
def logout(request):
    auth.logout(request)
    return HttpResponseRedirect("/appv_admin/login")

@login_required
def home(request):
    CHURCH_NAME = conf_settings.CHURCH_NAME

    if request.method == 'POST':
        form_new_user = NewUserForm(request.POST)
        if form_new_user.is_valid():
            user = User.objects.create_superuser( str(form_new_user['username'].value()),
                                                  str(form_new_user['email'].value()),
                                                  str(form_new_user['password'].value()))
            user.first_name = str(form_new_user['first_name'].value())
            user.last_name = str(form_new_user['last_name'].value())
            user.is_active = True
            user.save()

            form_new_user = NewUserForm()
            return HttpResponseRedirect("/appv_admin/home")

    else:
        form_new_user = NewUserForm()
            
    return render(request, 'appv_admin/home.html', locals())

@login_required
def sermon(request):
    form = SermonForm()

    if request.method == 'GET':
        # delete model data by id
        delete_id = request.GET.get('delete_id')
        if delete_id:
            Predication.objects.filter(id=int(delete_id)).delete()

    if request.method == 'POST':
        # update model data by id
        update_id = request.GET.get('update_id')
        print(" UPDATE ID : {}".format(update_id))
        if update_id:
            tmp_sermon = Predication.objects.get(id=int(update_id))
            form = SermonForm(request.POST, request.FILES)
            form.is_valid()
            for key in form.cleaned_data:
                print("{}={}".format(key, form[key].value()))

            form_data = form.cleaned_data
            tmp_sermon.title = form_data['title']
            tmp_sermon.predicator = form_data['predicator']
            # tmp_sermon.date = "01/01/1977"
            # print(form_data['date'])
            tmp_sermon.type = form_data['type']
            tmp_sermon.description = form_data['description']
            if form_data['audio']:
                tmp_sermon.audio = form_data['audio']
            if form_data['avatar']:
                tmp_sermon.avatar = form_data['avatar']
            if form_data['note']:
                tmp_sermon.note = form_data['note']
            tmp_sermon.save()

        else:
            form = SermonForm(request.POST, request.FILES)
            # check whether it's valid:
            print("")
            if form.is_valid():
                print("successful *** VALID FORM **** ")
                for key in form.cleaned_data:
                    print("{}={}".format(key, form[key].value()))
                form.save()
            else:
                print("warning *** VALID FORM **** ")
                for key in form.cleaned_data:
                    print("{}={}".format(key, form[key].value()))
            form.clean()

    sermons = Predication.objects.order_by('date')

    return render(request, 'appv_admin/sermon.html', locals())

@login_required
def agenda(request):
    MEDIA_URL = conf_settings.MEDIA_URL 
    agendas = Agenda.objects.order_by('date')
    agenda_current = Agenda.objects.all()[:1].get()
    form = AgendaForm()

    if request.method == 'POST':
        form = AgendaForm(request.POST, request.FILES)
        if form.is_valid():
            # file is saved
            form.save()
        form.clean()

    form = AgendaForm()

    return render(request, 'appv_admin/agenda.html', locals())

@login_required
def gallery(request):
    MEDIA_URL = conf_settings.MEDIA_SERVER + conf_settings.MEDIA_URL 

    form = GalleryForm()
    if request.method == 'POST':
        form = GalleryForm(request.POST, request.FILES)
        files = request.FILES.getlist('filepath')
        if form.is_valid():
            form_data = form.cleaned_data
            for i, file in enumerate(files):
                item_gallery = Gallery()
                item_gallery.album = form_data['album']
                item_gallery.type = form_data['type']
                item_gallery.filepath = file
                destination = "gallery/" + str(form_data['type']) + '/' + str(form_data['album']) + '/'
                item_gallery.filepath.field.upload_to = destination
                item_gallery.name = "{}".format(file)
                pprint.pprint(item_gallery)
                item_gallery.save()
        else:
            pprint.pprint(form.errors)

    form = GalleryForm()
    items_gallery = Gallery.objects.all()

    return render(request, 'appv_admin/gallery.html', locals())
