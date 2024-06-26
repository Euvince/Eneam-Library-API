<x-mail::message>

Bonjour {{ $manager->lastname.' '. $manager->firstname}},

Une nouvelle demande d'emprunt de livre a été soumise sur notre site. Voici les détails :

**Détails de la demande :**

- **Emprunteur :** {{ $loan->user->firstname.' '.$loan->user->lastname }}
- **Livre demandé :** {{ $loan->article->title }}
- **Date de la demande :** {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l d F Y') }}

Merci de prendre en charge cette demande dès que possible. Vous pouvez consulter les détails complets et marquer la demande comme traitée via votre interface de gestion.

@if (is_null($loan->processing_date))
<div style="text-align: center;">
    <table style="margin: 0 auto;">
        <tr>
            <td style="padding: 0 10px;">
              <x-mail::button :url="''">Accepter</x-mail::button>
            </td>
            <td style="padding: 0 10px;">
              <x-mail::button :url="''">Rejeter</x-mail::button>
            </td>
          </tr>
    </table>
</div>
@endif

Cordialement.

</x-mail::message>
