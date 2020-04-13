from django import forms


class ContactForm(forms.Form):
        name = forms.CharField(label='Votre nom', max_length=25, initial='Votre Nom')
        email = forms.EmailField(label='Votre email', initial='Votre Email')
        subject = forms.CharField(label='Sujet', max_length=100, initial='Sujet')
        message = forms.CharField(label='Votre message', initial='Message', widget=forms.Textarea())
