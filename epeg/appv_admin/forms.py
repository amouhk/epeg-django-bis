from django import forms
from pkg_resources import require

from .models import Predication, Agenda, Gallery

ALBUM_CHOICES = (
    ('Photo', 'Photo'),
    ('Video', 'Video'),
)

EMPTY_CHOICES = (
    ('Autre', 'Autre'),
)

TYPE_CHOICES = (
    ('Prédication', 'Prédication'),
    ('Témoignage', 'Témoignage'),
    ('Partage', 'Partage'),
    ('Autre', 'Autre'),
)


class LoginForm(forms.Form):
    username = forms.CharField(label="Votre nom d'utilisateur ", widget=forms.TextInput(attrs={'class': 'form-control'}))
    password = forms.CharField(label='Votre mot de passe', widget= forms.PasswordInput (attrs={'class': 'form-control'}))


class NewUserForm(forms.Form):
    first_name = forms.CharField(label='Votre nom', max_length=25, widget=forms.TextInput(attrs={'class': 'form-control'}))
    last_name = forms.CharField(label='Votre prenom', max_length=25, widget=forms.TextInput(attrs={'class': 'form-control'}))
    username = forms.CharField(label="Votre nom d'utilisateur", widget=forms.TextInput(attrs={'class': 'form-control'}))
    email = forms.EmailField(label='Votre email', widget=forms.EmailInput(attrs={'class': 'form-control'}))
    password = forms.CharField(label='Votre mot de passe', widget=forms.PasswordInput(attrs={'class': 'form-control', 'aria-describedby': 'id_password_help'}))
 

class SermonForm(forms.ModelForm):
    date = forms.DateField(input_formats=['%d-%m-%y'])

    class Meta:
        model = Predication
        fields = '__all__'
        widgets = {
            'title': forms.TextInput(attrs={'class': 'form-control validate mb-2'}),
            'predicator': forms.TextInput(attrs={'class': 'form-control validate mb-5'}),
            'description': forms.Textarea(attrs={'class': 'form-control validate mb-5'}),
            'date': forms.DateInput(attrs={'class': 'form-control datepicker mb-2'}),
            'type': forms.Select(choices=TYPE_CHOICES, attrs={'class': 'form-control validate mb-2'}),
            'audio': forms.FileInput(attrs={'class': 'form-control mb-4'}),
            'avatar': forms.FileInput(attrs={'class': 'form-control mb-4'}),
            'note': forms.FileInput(attrs={'class': 'form-control mb-2'}),
        }


class AgendaForm(forms.ModelForm):
    class Meta:
        model = Agenda
        fields = '__all__'
        widgets = {
            'date': forms.DateInput(attrs={'class': 'form-control datepicker mb-2'}),
            'name': forms.TextInput(attrs={'class': 'form-control mb-2'}),
            'filepath': forms.FileInput(attrs={'class': 'form-control mb-4'}),
        }


class GalleryForm(forms.ModelForm):
    class Meta:
        model = Gallery
        fields = '__all__'
        widgets = {
            'type': forms.Select(choices=ALBUM_CHOICES,
                                 attrs={'class': 'mdb-select md-form colorful-select dropdown-primary validate',
                                        'searchable': 'Search here..'}),
            'album': forms.Select(choices=EMPTY_CHOICES,
                                  attrs={'class': 'mdb-select md-form colorful-select dropdown-primary validate',
                                         'searchable': 'Search here..',
                                         'editable': 'true'}),
            'filepath': forms.ClearableFileInput(attrs={'multiple': True, 'class': 'file_upload'})
        }
