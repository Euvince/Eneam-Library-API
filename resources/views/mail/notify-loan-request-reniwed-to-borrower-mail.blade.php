<x-mail::message>

Cher/Chère {{ $loan->user->lastname.' '.$loan->user->firstname }},

Nous avons le plaisir de vous informer que le renouvellement de votre emprunt pour le livre **{{ $loan->article->title }}** a été accepté.

**Détails de votre emprunt renouvelé :**

- **Livre :** {{ $loan->article->title }}
- **Date initiale de l'emprunt :** {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l d F Y') }}
- **Date limite de retour du livre :** {{ \Carbon\Carbon::parse($loan->book_must_returned_on)->translatedFormat('l d F') }}

Nous vous rappelons que vous disposez de ce délai supplémentaire pour profiter pleinement de votre lecture.
Passé ce délai, si le livre n'est pas retourné à l'Eneam, des frais de pénalité de **{{ $debtAmount }} FCFA** vous seront appliqués
pour chaque jour exédant ce délai et votre accès à la bibliothèque sera suspendu jusqu'au règlement de votre dette.

Si vous avez des questions ou besoin de plus d'informations, n'hésitez pas à nous contacter à **{{ $manager->email }}** ou par téléphone au **{{ $manager->phone_number }}**.

Cordialement,

L'ENEAM.

</x-mail::message>
