from django import forms
from pkg_resources import require

from .models import User, Predication

ALBUM_CHOICES = (
    ('Photo', 'Photo'),
    ('Video', 'Video'),
)

TYPE_CHOICES = (
    ('Prédication', 'Prédication'),
    ('Témoignage', 'Témoignage'),
    ('Partage', 'Partage'),
    ('Autre', 'Autre'),
)


class LoginForm(forms.ModelForm):
    class Meta:
        model = User
        fields = ('name', 'email', 'password')
        widgets = {
            'name': forms.TextInput(attrs={'class': 'form-control'}),
            'email': forms.EmailInput(attrs={'class': 'form-control'}),
            'password': forms.PasswordInput(attrs={'class': 'form-control'}),
        }


class SermonForm(forms.ModelForm):
    class Meta:
        model = Predication
        fields = ('id', 'title', 'predicator', 'description', 'date', 'type', 'audio', 'avatar', 'note')
        require = {
            'avatar': False,
            'audio': False,
            'description': False,
            'note': False
        }
        widgets = {
            'id': forms.TextInput(attrs={'class': 'form-control validate mb-2'}),
            'title': forms.TextInput(attrs={'class': 'form-control validate mb-2'}),
            'predicator': forms.TextInput(attrs={'class': 'form-control validate mb-5'}),
            'description': forms.Textarea(attrs={'class': 'form-control validate mb-5'}),
            'date': forms.DateInput(attrs={'class': 'form-control datepicker mb-2'}),
            'type': forms.Select(choices=TYPE_CHOICES, attrs={'class': 'form-control validate mb-2'}),
            'audio': forms.FileInput(attrs={'class': 'form-control validate mb-4'}),
            'avatar': forms.FileInput(attrs={'class': 'form-control validate mb-4'}),
            'note': forms.FileInput(attrs={'class': 'form-control validate mb-2', 'required': 'False'},),
        }

