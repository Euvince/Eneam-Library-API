<x-mail::message>

Cher/Chère {{ $loan->user->lastname.' '.$loan->user->firstname }},

Nous regrettons de vous informer que votre demande d'emprunt pour le livre **{{ $loan->article->title }}** a été rejetée.

**Détails de votre demande :**

- **Livre demandé :** {{ $loan->article->title }}
- **Date de la demande :** {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l d F Y') }}

**Raison du rejet :**
{{ $reason }}

Nous comprenons que cela puisse être décevant, et nous nous excusons pour tout désagrément que cela pourrait causer.
Si vous avez des questions ou des préoccupations, n'hésitez pas à nous contacter à **{{ $manager->email }}** ou par téléphone au **{{ $manager->phone_number }}**.

Nous vous invitons à consulter notre bibliothèque pour d'autres livres qui pourraient vous intéresser et à soumettre une nouvelle demande d'emprunt.

Cordialement,

L'ENEAM

</x-mail::message>
