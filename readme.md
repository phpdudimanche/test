## TOM (Testing Operator Management) : référentiel de test ##

### Positionnement métier ###

L'outil permet d'effectuer des actions impossibles dans Testlink ou ALM. Je m'en suis servi avec succès il y a des années pour exécuter des procédures métiers. Exemples : mettre à jour à la volée un ensemble de pas de test (aussi bien création, modification, suppression, réordonnancement), exécuter rapidement un test (sans faire de release/campagne/ajouter à la campagne). 

Pour plus d'informations, la liste détaillée des fonctions se trouve dans le menu et module configuration. 

### Positionnement technique ###

L'objectif était de démontrer qu'on pouvait coder en procédural, directement en mysql (vient d'être porté en mysqli, en utf8, avec une nouvelle gestion des champs autoincréments et dates imposés par mysql5), avec une installation automatique, une configuration en ligne, des libellés multilingues, un versionning manuel de configuration, des notions de modularité comme les modules, les noms de table et de champs modifiables.

### Limitations ###

L'outil est monoprojet et ne gère pas les accès sécurisés.

### Evolution ###

J'ai commencé à céer une API, qu'il me reste à généraliser, pour les accès à la base (switchable avec mysqli, PDO). En Curl, créer un API pour les interactions entre l'outil de test et l'outil d'incident. Il reste des fonctions métiers à ajouter du type :  
 
  - notion d'effort et d'approche sur une condition de test
  - création d'un cas de test avec les champs : objectif de test, attendu...
  - meilleure ergonomie de la gestion des statuts pour les steps, 
  - pouvoir valider un cas de test sans steps

### Tests ###

Etant donné les évolutions possibles du code (repassage à l'objet ?), mieux vaut penser à des tests IHM, type codeception.





