<x-mail::message>

Cher/Chère {{ $loan->user->lastname.' '.$loan->user->firstname }},

Nous regrettons de vous informer que votre demande d'emprunt pour le livre **{{ $loan->article->title }}** a été rejetée.

**Détails de votre demande :**

- **Livre demandé :** {{ $loan->article->title }}
- **Date de la demande :** {{ $loan->loan_date }}

**Raison du rejet :**
{{ $reason }}

Nous comprenons que cela puisse être décevant, et nous nous excusons pour tout désagrément que cela pourrait causer. Si vous avez des questions ou besoin de plus amples informations, n'hésitez pas à nous contacter à [adresse email] ou par téléphone au [numéro de téléphone].

Nous vous invitons à consulter notre catalogue pour d'autres livres qui pourraient vous intéresser et à soumettre une nouvelle demande d'emprunt.

Cordialement,

L'ENEAM

</x-mail::message>
