**Remarques après tests sur le Dashboard**

+ **Configuration**

 - Lorsqu'on ajoute un nouveau **cycle** et qu'on veut le modifier automatiquement les données sont mal indexés, ça sera peut-être pareil pour **rôle**, **filière**, **soutenance** même si on ajoute pas un rôle, peut-être pareil pour **Article**

 - Afficher la **Filière** d'une spécialité vu que lors de la modification ce n'est pas pré-sélectionné

 - Confirmation pour les **suppressions** et pour la **validation** des **dépôts** (Ils sont irréversibles)

 - Les placeholders qui ne réflètent pas le libellé pour certains champs

 - Les modales dont les textes ne cadrent pas à certains endroits

 - Le message **Erreur de validation des champs** qui n'informe pas de quelle erreur côté back il s'agit

 - Les champs **date de début** et **date de fin** qui ne marchent pas sur sur l'ajout et la modification d'une soutenance : Quand on clique ça s'affiche pas

 - Enlever le bouton de **suppression** des rôles.

 - Sur la configuration il manque la modification des délais de récupération de livres pour l'étudiant et l'enseignant en jours, il manque aussi le champ pour spécifier le délai d'expiration d'un abonnement en années seulement pour les étudiants

 - La modification de la signature du gestionnaire rencontre un problème


+ **Utilisateurs**

  - Le select des rôles lors de la modification d'un user est blanc en thème sombre


+ **Mémoires**

  - La modale pour *visualiser* un mémoire sur les 2 listings de **Mémoires**, elle doit pouvoir consulter le mémoire pour éffectuer les actions en fonction.

  - Lui afficher le nombre de **mémoires attendus** et le nombre de **mémoires restants** pour la soutenance de l'année scolaire en cours (Si filtrer sera trop complexe, j'écris une API) : Sur la page des dépôts sera mieux

  - Impression unique pose un problème, on dirait c'est Axios, voir dans la console.C'est une route en patch. **Bizarre,des jours après je viens de tester et la requête passe, n'affiche plus le message : *Une erreur est survenue* mais ça télécharge la fiche en pdf au lieu de word**. J'ai lu plusieurs fois le back et c'est bien un fichier word je lance, faut voir si tu n'as rien spécifié qui pourrait créer ce souci


+ **Livres**

  - Le formulaire d'ajout et de modification des Livres, lorsqu'on met assez de mots clés ou même quand on choisit les options **disponible en physiques et en ebook**, le formulaire s'élargit et une partie est masquée, soit on scrolle ou on limite à 3 mots-clés comme ça on évite de casser le listing des livres aussi

  - Sur la modification quand je ne remplis pas des champs comme les mots-clés, les images, ou que je mets une valeur négative pour le stock par exemple les erreurs ne s'affichent pas.

  - Suppression multiples

  - La modale pour *visualiser* un livre

  - Filtrer les demandes d'emprunt par titre de Demande ou titre de Livre(le nom du livre est inclu dans celui de la demande)


+ **Statistiques**
    - Bon pour le moment il faut suelement ajuster dans la carte de mémoires : le vrai nombre de mémoires validé et en attente de validation et pour livres : le vrai de nombre de ebooks et de livres physiques


**N'oublie pas les messages dans les modales et les placeholders qui ne cadrent parfois pas.**

**Y'a des fois aussi ou c'est le message du back-end qu'il faut affiher plutôt que : *Une erreur est survenue* .**

**Quand y'a modale et qu'on fini d'éffectuer l'action, tu peux lui rabattre la modale ? (les suppressions et rejet de dépôt pour le moment)**



**Remarques après tests sur la partie users**

+ **Mémoires**
   - Dépôt de mémoire qui ne soumet pas, NextJS affiche une erreur (peut-être aussi une règle de validation non affichée sur le front bloque)

   - Les informations du second étudiant sont facultatifs

   - Page de garde en couverture

   - Téléchargement du mémoire, bouton **indisponible** pourquoi ???

   - Consultation du mémoire pour la lecture (Page de **détails** nécéssaire ??? parceque le thème du mémoire semble rediriger)

   - Recherche non fonctionnelle


+ **Livres**




+ **Authentification**
    - Register : Le laisser sur la même page avec un message de succès simplement
    - Login
