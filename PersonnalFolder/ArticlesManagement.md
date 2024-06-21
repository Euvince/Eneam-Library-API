*Les étapes de cette gestion d'articles : 
    +Pour ajouter un Livre :
        -Le type est facultatif,
        -Le titre est requis,
        -Le résumé est requis,
        -L'auteur est requis,
        -L'éditeur est requis,
        -L'année d'édition est requise,
        -La cote est requise,
        -Le nombre de pages est requis,
        -L'ISBN est requis,
        -Le stock disponible est requis,
        -Les mots clés sont requis,
        -L'année scolaire est requise,
        -Le fichier de couverture n'est pas Obligatoire
            +Si il est renseigné je procède à leur validation
        -Le(s) fichiers d'ebooks,
        -Il faut préciser s'il possède ou pas une version électronique(pas Obligatoire),
        -Il faut préciser s'il possède ou pas une version physique(pas Obligatoire),
        -Il faut préciser s'il possède ou pas des versions audios(pas Obligatoire)
            +Si oui alors je reprends la validation (extensions possibles, plusieurs fichiers sélectionnables...)
                *Ainsi plusieurs audios associés à un Livre (Généralement on associe les audios aux chapitres mais bon...il faudrait revoir la modélisation pour en tenir compte, chose qui n'est pas vraiment notre but.)
                *Et du prmêmier axtérix possibilité alors de choisir si elle veut créer un Livre ou enrégistrer un audio : Le formualaire sera alors moins consistant pour enrégistrer un Audio qu'un Livre
                *Au pire y associer en créant un chapitre
