<x-mail::message>

Cher/Chère {{ $name }},

Nous vous envoyons en pièce jointe la fiche de dépôt de votre mémoire intitulé **{{ $sm->theme }}** soumis avec succès sur notre application.

Veuillez conserver ce document pour vos archives personnelles.

**Détails de votre soumission :**

- **Thème du mémoire :** {{ $sm->theme }}
- **Date et heure de soumission :** {{ \Carbon\Carbon::parse($sm->created_at)->translatedFormat('l d F Y à H') }} heures

Si vous avez des questions ou besoin de plus d'informations, n'hésitez pas à nous contacter à **{{ $manager->email }} ou par téléphone au {{ $manager->phone_number }}.

Cordialement,

L'<strong>ENEAM</strong>.

</x-mail::message>
