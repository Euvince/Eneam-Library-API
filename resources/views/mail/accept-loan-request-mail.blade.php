<x-mail::message>

Cher/Chère {{ $loan->user->lastname.' '.$loan->user->firstname }},

Nous avons le plaisir de vous informer que votre demande d'emprunt pour le livre **{{ $loan->article->title }}** a été acceptée.

Vous disposez de **{{ $delayValue }} heures** dès maintenant pour venir récupérer le livre demandé. Passé ce délai, nous nous voyons dans l'obligation d'annuler votre requête.

**Détails de l'emprunt :**

- **Livre :** {{ $loan->article->title }}
- **Date de la demande :** {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l d F Y') }}
- **Date limite de récupération :** {{ \Carbon\Carbon::parse($loan->accepted_at)->addHours($delayValue)->translatedFormat('l d F Y à H') }} heures
- **Date limite de retour du livre :** {{ \Carbon\Carbon::parse($loan->book_returned_on)->add($delayValue)->translatedFormat('l d F') }}

Nous vous attendons à notre adresse suivante : **ENEAM à Gbégamey**

**Horaires de retrait :**
- **Lundi au Vendredi** : 9h00 - 17h00
- **Samedi** : 9h00 - 12h00

En outre, nous tenons à vous notifier que le livre doit être retourné dans le délai accordé,
le cas échéant, vous contracterez une dette de {{ $debtAmount }} FCFA pour chaque jour exédant
le dit délai et votre accès à la bibliothèque sera restreinte jusqu'à remboursement de votre dette.

Si vous avez des questions ou des préoccupations, n'hésitez pas à nous contacter à **{{ $manager->email }}** ou par téléphone au **{{ $manager->phone_number }}**.

Cordialement,

L'ENEAM.

</x-mail::message>
