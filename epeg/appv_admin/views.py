import pprint

from django.shortcuts import render
from .forms import LoginForm, SermonForm
from django.contrib.auth.hashers import make_password
from .models import Predication


# Create your views here.

def login(request):
    # Mail sending request
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = LoginForm(request.POST)
        # check whether it's valid:
        if form.is_valid():
            name = str(form["name"].value())
            email = str(form['email'].value())
            pwd = str(form['password'].value())
            pwd_hashed = make_password(password=pwd, salt=None)
            print("{} {} {} {}".format(name, email, pwd, pwd_hashed))
    else:
        form = LoginForm()

    return render(request, 'appv_admin/login.html', locals())


def home(request):
    return render(request, 'appv_admin/home.html', locals())


def sermon(request):
    sermons = Predication.objects.order_by('date')
    print("sermon viewer")
    if request.method == 'POST':
        form = SermonForm(request.POST)
        # check whether it's valid:
        print("")
        if form.is_valid():
            print(" Form ID : {}".format(form['id']))
        else:
            for key in form.cleaned_data:
                print("{}={}".format(key, form[key].value()))

            print("{}={}".format("audio", request.FILES['audio']))
            print("{}={}".format("avatar", request.FILES['avatar']))
            print("{}={}".format("note", request.FILES['note']))
    else:
        form = SermonForm()
    return render(request, 'appv_admin/sermon.html', locals())


def agenda(request):
    return render(request, 'appv_admin/agenda.html', locals())
