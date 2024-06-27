***Relation One to Many***

**Côté Utilisateur**
+Soumettre une demande d'emprunt
    Une fois sur le Listing ou sur le show d'un Livre et que toutes les conditions pour prêter un Livre sont réunis (Livre qui doit être physique) cliquer sur demander un prêt
    Si l'utilisateur peut prêter un Livre alors :
        -Remplir l'attribut title avec un titre dynamique,
        -Remplir l'attribut slug en sluggifiant le titre généré,
        -Mettre de statut de cette demande à **En cours**,
        -Remplir l'attribut loan_date avec la **date actuelle**,
        -Remplir l'attribut duration avec **14jours** pour un étudiant quelconque et **30jours** pour un enseignant,
        -Envoyer un email ou une notification au manager pour lui notifier la nouvelle demande de prêt (avec des boutons pour accepter ou rejeter la demande : OPTIONNEL),


+Ne peut prêter plus de deux documents à la fois suivant les conditions suivantes
    -Le Livre doit être disponible physiquement (C'est à dire available = true && is_physical = true)
    -Si deux livres sont avec lui ou
    -Si deux demandes sont déjà en cours ou
    -Si deux demandes sont déjà validées ou
    -Si une demande est en cours et qu'un livre est avec lui ou
    -Si une demande est validée et qu'un livre est avec lui ou
    -Si une demande est en cours et qu'une autre demande est validée ou
    -Si le stock disponible du Livre est de 0 ou
    ???-Prise en compte des cas de **renouvellements**???

+Renouveller une demande d'emprunt
    ??? Doit-on faire une nouvelle demande ???
    -Vérifier si la demande a été acceptée, le Livre a été recupéré et s'il n'a pas déjà renouveller une fois la demande,
    -Incrémenter renewals de 1 pour la demande,
    -Remplir l'attribut reniew_at avec la date actuelle
    -Modifier l'attribut book_must_returned_on en y ajoutant 14jours pour un étudiant quelconque et 30jours pour un enseignant



**Côté Gestionnaire**
+Lister les demandes de prêts sur le dashboard avec différents boutons pour différentes actions
    -Un bouton pour ACCEPTER une demande de prêt
        Si la demande n'est pas encore acceptée
            .Remplir l'attribut processing_date avec la date actuelle,
            .Remplir l'attribut book_must_returned_on avec la date actuelle,
            .Une notification ou un email sera envoyé au propriétaire de la demande pour lui notifier l'acceptation,
            .Décrémenter le stock disponible pour cet article de 1 automatiquement,
            .Changer le statut de la demande de prêt à l'état Acceptée,
            .Compter 48h à partir de la l'acceptation et si l'attribut book_recovered_at est toujours nulle :
                ~Envoyer une notification ou un email à l'utilisateur pour lui notifier que sa demande de prêt est annulée,
                ~Incrémenter de nouveau le stock disponible pour cet article de 1,
                ~Supprimer la demande de prêt de la base de données,
            .Dès que l'attribut book_recovered_at n'est plus nulle :
                ~Si la date à laquelle le prêteur doit retourner le Livre est passée :
                    ¬Incrémenter sa dette de 500FCFA pour un étudiant quelconque et de 1000FCFA pour un enseignant
            .Lui notifier après **acceptation** qu'il dispose de 48h de max pour venir chercher le Livre (Ne doit plus pouvoir redemander ce document)
            .Envoyer une notification ou un email à l'utilisateur 24h après pour lui rappeller
            .Avertir aussi tous les prêteurs deux jours avant la date d'expiration de leur emprunt s'ils n'ont jamais encore renouvellé


    -Un bouton pour REJETER une demande de prêt tout en précisant la raison du rejet
        Si la demande n'est pas encore rejetée ainsi que d'autres conditions éventuelles alors :
            .Remplir l'attribut processing_date avec la date actuelle,
            .Changer le statut de la demande de prêt à l'état Rejetée,
            .Une notification ou un email sera envoyé au propriétaire de la demande pour lui notifier le rejet et sa raison,
            .Supprimer la demande de prêt de la base de données,

    -Un bouton pour confirmer que le prêteur est venu récupérer le document
        Si la demande est acceptée, le prêteur n'est pas encore venu récupérer alors :
            .Remplir l'attribut book_recovered_at avec la date actuelle

    -Un bouton pour confirmer que le prêteur a retourné le document
        Si le Livre a été récupéré et n'est pas encore de retour alors :
            .Remplir l'attribut book_returned_at avec la date actuelle



***Relation Many to Many***

...


**Affichage des boutons d'actions**
    +Bouton Accepter
        -Si Accepter :
            .Accepter disparait
            .Rejeter disparaît
            .Récupéré apparaît

    +Bouton Rejeter
        +Si Rejeter
            -La demande est supprimée

    +Bouton Récupéré
        -Si Récupéré :
            .Accepter n'est pas là
            .Rejeter n'est pas là
            .Récupéré disparait
            .Rendu apparaît

    +Bouton Rendu
        -Si Rendu :
            .Accepter n'est pas là
            .Rejeter n'est pas là
            .Récupéré n'est pas là
            .Rendu disparait
            .Retirer apparaît

    +Bouton Retirer
        +Si Retirer
            -La demande disparait du Listing
