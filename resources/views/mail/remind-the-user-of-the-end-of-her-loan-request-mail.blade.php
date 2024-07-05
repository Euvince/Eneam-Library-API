<x-mail::message>

Cher/Chère {{ $loan->user->lastname.' '.$loan->user->firstname }},

Nous vous rappelons que la date limite pour retourner le livre **{{ $loan->article->title }}** approche. Vous devez le retourner avant le {{ \Carbon\Carbon::parse($loan->book_must_returned_on)->translatedFormat('l d F Y') }}.

**Détails de votre emprunt :**

- **Livre :** {{ $loan->article->title }}
- **Date initiale de l'emprunt :** {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l d F Y') }}
- **Date limite de retour du livre :** {{ \Carbon\Carbon::parse($loan->book_must_returned_on)->translatedFormat('l d F Y') }}

Nous tenons à vous rappeler que passé ce délai, si le livre n'est pas retourné, des frais de pénalité de **{{ $debtAmount }} FCFA** vous seront appliqués et votre accès à la bibliothèque sera suspendu jusqu'au règlement de votre dette.
Si vous avez des questions ou besoin de plus d'informations, n'hésitez pas à nous contacter à **{{ $manager->email }}** ou par téléphone au **{{ $manager->phone_number }}**.

@if ($loan->renewals <= 0)
Si vous avez besoin de plus de temps pour finir votre lecture, vous pouvez renouveler votre emprunt en cliquant sur le bouton ci-dessous :

<div style="text-align: center;">
    <x-mail::button :url="''">Renouveler mon emprunt</x-mail::button>
</div>
@endif

Cordialement,

L'<strong>ENEAM</strong>.

</x-mail::message>
