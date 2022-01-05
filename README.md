# popblog
___
## projet web

Popblog est un blog écrit en PHP sous l'architecture MVC. Vous pourrez administrer les articles, les commentaires et les demandes des utilisateurs.
Un utilisateur pourra quand à lui, voir les articles et les commenter.
___
## Installation
**Prerequis** : [composer](https://getcomposer.org/download/)
```
git clone https://github.com/EnzoGzz/popblog.git
composer install
```
**Fichier config.php**
```php
const DB_NAME = "popblog";
const DB_USERNAME = "your_username";
const DB_PASSWORD = "your_password";
const APP_ENV = "PROD";
```

**Installation de la base de données**:

Changer l'environnement de l'application en local
```php
const APP_ENV = "LOCAL";
```
Allez sur la page :
```
http://your_server_ip/install.php
```
Changer l'environnement de l'application en production
```php
const APP_ENV = "PROD";
```

#Important
___
Après avoir installer la base de données, supprimer le fichier install.php
___

- G5 - Gonzalez Enzo
- G5 - Murat Romain