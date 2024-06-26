<x-mail::message>

Cher/Chère {{ $loan->user->lastname.' '.$loan->user->firstname }},

Nous vous rappelons que votre demande d'emprunt pour le livre **{{ $loan->article->title }}** a été acceptée, mais que vous n'avez pas encore récupéré le livre.

**Détails de votre demande :**

- **Livre :** {{ $loan->article->title }}
- **Date de la demande :** {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l d F Y à H') }}
- **Date limite de récupération :** {{ \Carbon\Carbon::parse($loan->accepted_at)->addHours($delayValue)->translatedFormat('l d F Y à H') }} heures

Nous vous attendons à notre adresse suivante : **ENEAM à Gbégamey**

**Horaires de retrait :**
- **Lundi au Vendredi** : 9h00 - 17h00
- **Samedi** : 9h00 - 12h00

Si vous avez des questions ou des préoccupations, n'hésitez pas à nous contacter à **{{ $manager->email }}** ou par téléphone au **{{ $manager->phone_number }}**.

Cordialement,

L'ENEAM

</x-mail::message>
