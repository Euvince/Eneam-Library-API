<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>


# Bienvenue sur [Nom de l'application] !

Bonjour [Nom de l'utilisateur],

Votre compte a été créé avec succès sur [Nom de l'application]. Vous pouvez maintenant vous connecter en utilisant les identifiants ci-dessous :

- **Nom d'utilisateur** : [username]
- **Mot de passe** : [password]

### Instructions de connexion

1. Rendez-vous sur notre site : [Lien vers l'application].
2. Entrez votre nom d'utilisateur et votre mot de passe.
3. Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe après votre première connexion.

Si vous rencontrez des difficultés pour accéder à votre compte, n'hésitez pas à contacter notre équipe d'assistance à l'adresse [email de support].

Merci et bienvenue !

Cordialement,
L'équipe [Nom de l'application]
