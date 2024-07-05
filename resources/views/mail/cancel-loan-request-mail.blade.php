<x-mail::message>

Cher/Chère {{ $loan->user->lastname.' '.$loan->user->firstname }},

Nous vous informons que votre demande d'emprunt pour le livre **{{ $loan->article->title }}** a été annulée. Vous n'avez pas récupéré le livre dans le délai imparti de {{ $delayValue }}.

**Détails de la demande annulée :**

- **Livre :** {{ $loan->article->title }}
- **Date de la demande :** {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l d F Y à H') }}
- **Date limite de récupération :** {{ \Carbon\Carbon::parse($loan->accepted_at)->addHours($delayValue)->translatedFormat('l d F Y à H') }} heures

Nous comprenons que des imprévus peuvent survenir et nous vous invitons à soumettre une nouvelle demande d'emprunt si vous souhaitez toujours lire ce livre.

Si vous avez des questions ou des préoccupations, n'hésitez pas à nous contacter à **{{ $manager->email }}** ou par téléphone au **{{ $manager->phone_number }}**.

Cordialement,

L'<strong>ENEAM</strong>.

</x-mail::message>
