<x-mail::message>
# Bonjour <strong>{{ $name }}</strong>

Nous avons le plaisir de vous informer que votre mémoire de fin de formation a été validé avec succès.

**Détails de votre soumission :**

- **Thème du mémoire :** {{ $sm->theme }}
- **Date et heure de soumission :** {{ \Carbon\Carbon::parse($sm->created_at)->translatedFormat('l d F Y à H') }} heures

Félicitations pour votre travail et votre engagement tout au long de votre formation.

Vous pouvez désormais passer retirer votre diplôme de fin de formation au secrétariat de l'établissement.

**Horaires de retrait :**
- **Lundi au Vendredi** : 9h00 - 17h00
- **Samedi** : 9h00 - 12h00

N'oubliez pas d'apporter une pièce d'identité pour le retrait de votre diplôme ainsi que la fiche de dépôt en pièces jointes.

Encore toutes nos félicitations et nous vous souhaitons une brillante carrière professionnelle.

Cordialement,<br>
L'<strong>ENEAM</strong>.
</x-mail::message>
