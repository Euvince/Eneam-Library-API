<x-mail::message>
Bonjour <strong>{{ $name }}</strong>,

Nous vous informons que votre dépôt de mémoire de fin de formation a été rejeté après étude.

**Détails de votre soumission :**

- **Thème du mémoire :** {{ $sm->theme }}
- **Date et heure de soumission :** {{ \Carbon\Carbon::parse($sm->created_at)->translatedFormat('l d F Y à H') }} heures

Motif du rejet : <strong>{{ $reason }}</strong>

Vous pouvez soumettre une version révisée de votre mémoire en respectant les délais fixés par l'établissement. Pour toute question ou clarification, n'hésitez pas à contacter le service académique à **{{ $manager->email }}**.

Nous restons à votre disposition pour toute assistance complémentaire.

Cordialement,<br>
L'<strong>ENEAM</strong>.
</x-mail::message>
