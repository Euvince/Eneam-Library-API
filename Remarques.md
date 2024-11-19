**Remarques après tests**

+ **Configuration**

 - Lorsqu'on ajoute un nouveau **cycle** et qu'on veut le modifier automatiquement les données sont mal indexés, ça sera peut-être pareil pour **rôle**, **filière**, **soutenance** même si on ajoute pas un rôle, peut-être pareil pour **Article**

 - Confirmation pour les **suppressions** et pour la **validation** des **dépôts** (Ils sont irréversibles)

 - Les placeholders qui ne réflètent pas le libellé pour certains champs

 - Le message **Erreur de validation des champs** qui n'informe pas de quelle erreur côté back il s'agit

 - Les champs **date de début** et **date de fin** qui ne marchent pas sur sur l'ajout et la modification d'une soutenance : Quand on clique ça s'affiche pas

 - Enlever le bouton de **suppression** des rôles.

 - Sur la configuration il manque la modification des délais de récupération de livres pour l'étudiant et l'enseignant en jours, il manque aussi le champ pour spécifier le délai d'expiration d'un abonnement en années seulement pour les étudiants

 - La modification de la signature du gestionnaire rencontre un problème


+ **Utilisateurs**

  - Les **noms** et **prénoms** sont inversés sur le listing des users

  - Le select des rôles lors de la modification d'un user est blanc en thème sombre


+ **Mémoires**

  - La modale pour *visualiser* un mémoire déposé, elle doit pouvoir consulter le mémoire.
  - Lui afficher le nombre de **mémoires attendus** et le nombre de **mémoires restants**


+ **Livres**

  - Le formulaire d'ajout et de modification des Livres, lorsqu'on met assez de mots clés, le formulaire s'élargit et une partie est masquée, soit on scrolle ou on limite à 3 mots-clés comme ça va pas casser le listing aussi
