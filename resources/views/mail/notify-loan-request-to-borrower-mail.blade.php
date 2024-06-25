<x-mail::message>

Cher/Chère {{ $loan->user->lastname }},

Nous vous remercions d'avoir soumis votre demande d'emprunt de livre sur notre site. Cette demande est en cours de traitement par notre équipe.

**Récapitulatif de votre demande :**

- **Livre demandé :** {{ $loan->article->title }}
- **Date de la demande :** {{ $loan->loan_date }}
- **Statut actuel :** En cours de traitement

Nous reviendrons vers vous dès que votre demande aura été traitée. Si vous avez des questions en attendant, n'hésitez pas à nous contacter à **eneam@gmail.com** ou par téléphone au {{ $phoneNumber }}.

Cordialement,

L'ENEAM.


{{-- <x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}
