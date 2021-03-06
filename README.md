<div align="center">
<img src="public/assets/logo_white.png" alt="Logo" width="200"/>
<h1>PopBlog</h1>
</div>

## Qu'est ce que PopBlog

Popblog est un blog écrit en PHP sous l'architecture MVC. Vous pourrez administrer les articles, les commentaires et les demandes des utilisateurs.
Un utilisateur pourra quand à lui, voir les articles et les commenter.
___
## Installation
**Prerequis** : [composer](https://getcomposer.org/download/)

Votre serveur web doit pouvoir lire les fichiers .htaccess : 
- [Enable htaccess file on Apache](https://httpd.apache.org/docs/2.4/fr/mod/core.html#allowoverride)
```
git clone https://github.com/EnzoGzz/popblog.git
composer install
```
**Fichier config.php**
```php
const DB_NAME = "popblog";
const DB_USERNAME = "your username database";
const DB_PASSWORD = "your password database";
const APP_ENV = "PROD";
```

**Installation de la base de données**:

Changer l'environnement de l'application en local
```php
const APP_ENV = "LOCAL";
```
Modifier le compte administrateur par defaut en modifiant le fichier install.php ligne 17
```php
$dbc->makeUser("your username popblog","your password popblog");
```
Allez sur la page :
```
http://your_server_ip/install.php
```
Changer l'environnement de l'application en production
```php
const APP_ENV = "PROD";
```

# Important
___
Après avoir installer la base de données, supprimer le fichier install.php
___
Auteur :
- G5 - Gonzalez Enzo
- G5 - Murat Romain
___
[Licence](LICENSE)