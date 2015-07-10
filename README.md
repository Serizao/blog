# blog
Un projet de blog en php

Ceci README est un récapitulatif des actions à effectuer pour la mise en route du blog ainsi qu'une explication de son fonctionnement.

Avant de rentrer dans le vif du sujet, voici une représentation de l'arborescence :

```
                                 +--->newSite   
                                 |              
                                 +--->oldSite   
                                 |              
              +--> css           +--->posts     
              |                  |              
              +--> download      +--->libs      
              |                  |              
              +--> cache         +--->css       
root directory|                  |              
              +--> index.html    +--->includes  
              |                  |              
              +--> admin+------------>main.php  
                                 |              
                                 +--->imgmgr.php
                                 |              
                                 +--->config.php
                                 |              
                                 +--->edit.php  
                                 |              
                                 +--->index.php 
                                 |              
                                 +--->templates 
```
Les parties intéressantes se trouvent dans le dossier admin, dans lequel nous trouverons le sous-dossier templates qui contient, vous l'aurez compris, les templates utilisées lors de la génération de contenu html.
Les fichiers principaux sont main.php, edit.php, imgmgr.php et index.php :

*  index.php est la page d´authentification. 
Actuellement, les identifiants pour accéder à l'administration sont 'admin' et 'monpass'.
Vous pourrez modifier cela en éditant le fichier et en modifiant la ligne 12 :
```php
if ($_POST['username']=='admin' && $_POST['password']=='monpass'){
```
*  main.php est la page d'administration qui a pour but de faire une recherche dans le dossier "posts" et d'afficher les fichiers.md qui y sont contenus et de vous proposer d'en éditer le contenu ou de les supprimer. C´est également ici que
vous pourrez créer un article. Une fois les modifications terminées, un fichier en markdown est créé. Vous devrez appliquer afin de générer le contenu en html. En cas d'erreur, l´ancien contenu est archivé dans le dossier oldSite, le dossier newSite lui stocke les données temporaires et sera, la plupart du temps vide.
*  edit.php est la page d'édition de contenu.
*  imgmgr.php est la page de gestion des images. À la racine se trouve un dossier download/img. 
C'est ici que se passe la gestion des images, vous pourrez donc y créer des dossiers à partir de l'interface afin        d'organiser vos images. Vous pourrez également les uploader. (ces features sont encore en cours)
*  config.php contient certaines valeurs qu'on viendra chercher à l'occasion, comme le titre, le descriptif du blog lors de la génération de pages. Il vous faudra donc modifier les champs "siteTitle" et "siteMotto" afin de les personnaliser.

Je me suis aidé de parsedown pour la conversion de contenus markdown vers html ainsi que de prism pour la coloration syntaxique pour les portions de code. Un grand merci, donc.
