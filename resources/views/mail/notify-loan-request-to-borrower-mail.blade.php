<x-mail::message>

Cher/Chère {{ $loan->user->lastname.' '.$loan->user->lastname }},

Nous vous remercions d'avoir soumis votre demande d'emprunt de livre sur notre site. Cette demande est en cours de traitement par notre équipe.

**Récapitulatif de votre demande :**

- **Livre demandé :** {{ $loan->article->title }}
- **Date de la demande :** {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l d F Y') }}
- **Statut actuel :** En cours de traitement

Nous reviendrons vers vous dès que votre demande aura été traitée. Si vous avez des questions en attendant, n'hésitez pas à nous contacter à **eneam@gmail.com** ou par téléphone au **{{ $manager->phone_number }}**.

Cordialement,

L'ENEAM.

</x-mail::message>
