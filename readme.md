# Smart Tribune - Backend - Coding Test 
Le projet est un API pour valider un Q&A et le stocker dans une base de données. 

## Les langages utilisés dans ce projet : 
- PHP 8 
- Framework Symfony 6
- Maridb 
  
## Les outils utilisés dans ce projet :
- Visual Studio Code pour éditer le code.
- Gitlab pour sauvegarder le code et le partager.
- PostMan pour tester les requettes HTTP.
- PHP Unit pour les tests unitaires.
  
## Spécifications fonctionnelles du projet :
### Afficher toutes les questions avec ses réponses en format JSON :
   J'ai créé une route et à l'aide de la fonction questionsShow j'ai récupéré toutes les questions et leurs réponses de la base de données, les sérialisé et les converti au format JSON.  
   Voici la requette GET que j'ai testé sur PostMan :  
  https://127.0.0.1:8000/question/show
### Ajouter une question :
  - J'ai créé une nouvelle route avec la fonction questionAdd qui me permet d'ajouter une question en format JSON et de la récupérer et de la convertir à objet.
  - Tous les champs sont obligatoires sauf pour create_at et updated_at, je les ai ajoutés automatiquement.
  - J'ai utilisé le validateur de Symfony pour m'assurer que toutes les propriétés sont saisies, le champ Statut doit être [draft ou published] et le champ Promu doit être [true ou false].
  - Voici la requette POST que j'ai testé sur PostMan :  
  https://127.0.0.1:8000/question/add
  - Exemple d'ajout d'une question :
    ```
    {
        "title": "Ma Question",
        "promoted": false,
        "status": "published"
    }
    ```
### Ajouter une réponse :
J'ai utilisé la même logique pour ajouter une réponse sauf que j'avais besoin de l'id de la question à laquelle j'ajoute la réponse, donc j'ai récuperé l'id de l'URL.  
Voici la requette POST que j'ai testé sur PostMan :  
  https://127.0.0.1:8000/question/addanswer/{id}.

### Modifier une question :
Pour la modification, j'ai mit une condition qui vérifie si le titre ou le statut a changé sinon la réponse sera un message demandant de changer le titre ou le statut.  
J'ai créé un Event Listener (class QuestionUpdate) qui est un doctrine orm entity listener, il écoute la modification de l'entité Question,il crée un nouvel objet HistoricQuestion, le remplit avec ces changements et les envoie à la base de données.  
Voici la requette PUT que j'ai testé sur PostMan :  
https://127.0.0.1:8000/question/update/{id}.

### Créer un CSV Exporter service :
J'ai créé un service (classe ExporterCsv) et dans la classe j'ai créé la fonction export() qui prend l'instance d'objet comme propriété, récupère toutes les données de cette entité et la convertit au format csv, la réponse sera le fichier export.cvs contient ces données au format CSV.  
Aprés j'ai appliqué cet exporter sur l'entité HistoricQuestion dans la route app_question_showcsv.  
Voici la requette GET que j'ai testé sur PostMan :  
  https://127.0.0.1:8000/question/question/showcsv
