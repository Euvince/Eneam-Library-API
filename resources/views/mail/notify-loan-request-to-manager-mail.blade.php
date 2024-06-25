<x-mail::message>

#Bonjour {{ $manager->firstname.' '. $manager->lastname}},

Une nouvelle demande d'emprunt de livre a été soumise sur notre site. Voici les détails :

**Détails de la demande :**

- **Emprunteur :** {{ $loan->user->firstname.' '.$loan->user->lastname }}
- **Livre demandé :** {{ $loan->article->title }}
- **Date de la demande :** {{ $loan->loan_date }}

Merci de prendre en charge cette demande dès que possible. Vous pouvez consulter les détails complets et marquer la demande comme traitée via votre interface de gestion.

{{-- En cas de questions, n'hésitez pas à me contacter. --}}

Cordialement.


{{-- <x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}
