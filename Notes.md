-Achever les règles de validations pour l'unicité des Mémoires soutenus et des Livres;

-L'utilisateur ne peut avoir certains rôles à la fois

-Finir de tester l'authentification) :
    +Verify Email;
    +Forgot Pasword;
    +Password Reset;
    +Remember token;
    +Double Authentification complète;

**Optionnel**

*****************************************************************************************************************

-Prévisualisation de fichiers avec media library et spatie pdftoimage (Commande ghostscript introuvable);

-Récupération d'identifiant à partir du découpage du code QR du document avec Zbar-php et imagick (Commande ghostscript introuvable)

*****************************************************************************************************************

+Packages supplémetaires :
    .Simplesoftwareio/simple-qrcode si nécéssaire
    .Zbar-php si nécéssaire

*****************************************************************************************************************

-Les tests unitaires à la fin du projet;

+Gérer plus tard les created_at, updated_at, deleted_at, created_by, updated_by et deleted_by pour les tables associatives

+Gérer plus tard les Accesseurs et Mutateurs pour alléger les Observateurs;

+Gérer plus tard les transactions ainsi que les conflits d'accès simultanés aux données;


-Continuer les tâches multiples (Demandes de prêts : il faudra séparer les demandes avec les acceptées,          rejetées, ... toutes à part sinon les conditions poseront problèmes. Ex : avant d'accepter une demande il faut faire des vérifications et si j'essai d'accepter plusieurs il faudra les faire pour chacune et bloquer si une seule ne respecte pas les vérifications. Comme on l'a fait avec les mémoires validés et invalidés séparés.);
