<!DOCTYPE html>
<html>
<head>
    {{-- <meta charset="utf-8"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fiche de Dépôt de Mémoire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px; /* Réduire la marge globale */
        }
        .container {
            width: 100%;
            border: 1px solid #000;
            padding: 10px; /* Réduire le padding interne */
            page-break-after: always; /* Force un saut de page après chaque container */
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px; /* Réduire la marge entre les sections */
        }
        .header h2, .header h3 {
            margin: 5px 0; /* Réduire les marges des titres */
        }
        .content {
            margin: 10px 0; /* Réduire la marge interne de la section content */
        }
        .content p {
            margin: 5px 0; /* Réduire les marges des paragraphes */
            font-size: 12px; /* Taille de la police du contenu */
        }
        .content strong {
            display: inline-block;
            width: 200px; /* Taille des étiquettes */
        }
        /* Pour éviter un saut de page après le dernier container */
        .container:last-child {
            page-break-after: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ $config->school_name }}</h2>
            <h3>FICHE DE DÉPÔT DE MÉMOIRE : {{ \Carbon\Carbon::parse($memory->soutenance->start_date)->year."-".$memory->sector->acronym."-".$memory->id }}</h3>
        </div>
        <div class="content">
            <p><strong>{{ $config->school_city }}, le : </strong> {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }} </p>
            {{-- <p><strong>Numéro d'identification : </strong> {{ $memory->id }} </p> --}}
            <p><strong>NOM ET PRÉNOMS DE L’ÉTUDIANT : </strong> {{ $memory->first_author_firstname." ".$memory->first_author_lastname }} </p>
            <p><strong>FILIÈRE & CLASSE : </strong> {{ $memory->sector->sector->name."/".$memory->sector->name }} </p>
            <p><strong>PROMOTION : </strong> {{ $memory->soutenance->schoolYear->school_year }} </p>
            <p><strong>THÈME : </strong> {{ $memory->theme }} </p>
        </div>
        <div class="footer">
            <p>Signature de l'Étudiant</p>
            {{-- <img src="data:image/png;base64,'.base64_encode(file_get_contents({{ $qrCodeImg }})).'" alt="" style="width: 100px; height: 100px;"> --}}
            <img src="{{ $qrCodeImg }}" alt="" style="width: 85px; height: 85px;">
            <br><br>
            <p>Signature Chef Service Documentation et Archives</p>
            <img src="{{ $signatureImg }}" alt="" style="width: 85px; height: 85px;">
            <br><br>
            <p>{{ $config->archivist_full_name }}</p>
        </div>
    </div>
    <div class="container">
        <div class="header">
            <h2>{{ $config->school_name }}</h2>
            <h3>FICHE DE DÉPÔT DE MÉMOIRE : {{ \Carbon\Carbon::parse($memory->soutenance->start_date)->year."-".$memory->sector->acronym."-".$memory->id }}</h3>
        </div>
        <div class="content">
            <p><strong>{{ $config->school_city }}, le : </strong> {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }} </p>
            {{-- <p><strong>Numéro d'identification : </strong> {{ $memory->id }} </p> --}}
            <p><strong>NOM ET PRÉNOMS DE L’ÉTUDIANT : </strong> {{ $memory->second_author_firstname." ".$memory->second_author_lastname }} </p>
            <p><strong>FILIÈRE & CLASSE : </strong> {{ $memory->sector->sector->name."/".$memory->sector->name }} </p>
            <p><strong>PROMOTION : </strong> {{ $memory->soutenance->schoolYear->school_year }} </p>
            <p><strong>THÈME : </strong> {{ $memory->theme }} </p>
        </div>
        <div class="footer">
            <p>Signature de l'Étudiant</p>
            {{-- <img src="data:image/png;base64,'.base64_encode(file_get_contents({{ $qrCodeImg }})).'" alt="" style="width: 100px; height: 100px;"> --}}
            <img src="{{ $qrCodeImg }}" alt="" style="width: 85px; height: 85px;">
            <br><br>
            <p>Signature Chef Service Documentation et Archives</p>
            <img src="{{ $signatureImg }}" alt="" style="width: 85px; height: 85px;">
            <br><br>
            <p>{{ $config->archivist_full_name }}</p>
        </div>
    </div>
</body>
</html>
