<x-mail::message>

Cher/Chère {{ $name }},

Nous accusons réception de votre mémoire intitulé **{{ $sm->theme }}**, soumis avec succès sur notre application.

Votre mémoire est actuellement en cours d'examen. Vous serez informé de la décision finale dès que possible.

**Détails de votre soumission :**

- **Thème du mémoire :** {{ $sm->theme }}
- **Date et heure de soumission :** {{ \Carbon\Carbon::parse($sm->created_at)->translatedFormat('l d F Y à H') }} heures

Si vous avez des questions ou besoin de plus d'informations, n'hésitez pas à nous contacter à **{{ $manager->email }}** ou par téléphone au **{{ $manager->phone_number }}**.

Cordialement,

L'<strong>ENEAM</strong>.

</x-mail::message>
