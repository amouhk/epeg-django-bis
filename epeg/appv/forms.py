from django import forms


class ContactForm(forms.Form):
    name = forms.CharField(label='Votre nom', max_length=25, widget=forms.TextInput(attrs={'class': 'form-control'}))
    email = forms.EmailField(label='Votre email', widget=forms.EmailInput(attrs={'class': 'form-control'}))
    subject = forms.CharField(label='Sujet', max_length=100, widget=forms.TextInput(attrs={'class': 'form-control'}))
    message = forms.CharField(label='Votre message', widget=forms.Textarea(attrs={'class': 'form-control'}))
