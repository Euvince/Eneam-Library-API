<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
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
            <h2>ÉCOLE NATIONALE D’ÉCONOMIE APPLIQUÉE ET DE MANAGEMENT</h2>
            <h3>FICHE DE DÉPÔT DE MÉMOIRE</h3>
        </div>
        <div class="content">
            <p><strong>Cotonou, le :</strong> {{ $config->school_name }} </p>
            <p><strong>NOM ET PRÉNOMS DE L’ÉTUDIANT :</strong> {{ $memory->first_author_name }} </p>
            <p><strong>FILIÈRE & CLASSE :</strong> .......................................................................................................................................................................................</p>
            <p><strong>PROMOTION :</strong> .......................................................................................................................................................................................</p>
            <p><strong>THÈME :</strong> .......................................................................................................................................................................................</p>
        </div>
        <div class="footer">
            <p>Signature de l'Étudiant</p>
            <br><br>
            <p>Signature Chef Service Documentation et Archives</p>
            <br><br>
            <p>Ghislaine AKOMIA</p>
        </div>
    </div>
    <div class="container">
        <div class="header">
            <h2>ÉCOLE NATIONALE D’ÉCONOMIE APPLIQUÉE ET DE MANAGEMENT</h3>
            <h3>FICHE DE DÉPÔT DE MÉMOIRE</h3>
        </div>
        <div class="content">
            <p><strong>Cotonou, le :</strong> .......................................................................................................................................................................................</p>
            <p><strong>NOM ET PRÉNOMS DE L’ÉTUDIANT :</strong> .......................................................................................................................................................................................</p>
            <p><strong>FILIÈRE & CLASSE :</strong> .......................................................................................................................................................................................</p>
            <p><strong>PROMOTION :</strong> .......................................................................................................................................................................................</p>
            <p><strong>THÈME :</strong> .......................................................................................................................................................................................</p>
        </div>
        <div class="footer">
            <p>Signature de l'Étudiant</p>
            <br><br>
            <p>Signature Chef Service Documentation et Archives</p>
            <br><br>
            <p>Ghislaine AKOMIA</p>
        </div>
    </div>
</body>
</html>
