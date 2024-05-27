# FFS
Plateforme de retour d'expérience pour la Fédération Française de Spéléologie dans le cadre du projet final de l'option Dév de mon cursus

## Guide pour lancer le projet sur votre machine
Ce guide vous aidera à configurer et à lancer le projet sur votre machine locale. Les instructions sont fournies pour les systèmes d'exploitation Windows et Mac.

## Prérequis
• PHP
• MySQL

## Étapes

### Installer MySQL
Pour Windows et Mac, vous pouvez télécharger MySQL à partir de [ici](https://dev.mysql.com/downloads/installer/).

### Configurer le fichier .env

Dupliquez le fichier `.env.example`, renommer le `.env` et ouvrez dans l'éditeur de texte de votre choix. Trouvez et modifiez les lignes suivantes avec vos informations :

`DB_PORT` : Remplacez sa valeur par le port de votre serveur MySQL. Par défaut, il s'agit généralement du port 3306.

`DB_USERNAME` : Remplacez sa valeur par le nom d'utilisateur de votre base de données. Généralement, il s'agit de `root`.

`DB_PASSWORD` : Remplacez sa valeur par le mot de passe de votre base de données.

### Créer une base de données

Ouvrez le terminal et connectez-vous à MySQL en utilisant la commande suivante :


`mysql -u root -p`

Ensuite, créez une nouvelle base de données appelée `ffs` en utilisant la commande suivante :

`CREATE DATABASE ffs;`

### Installer les dépendances PHP

Avant de lancer le projet, assurez-vous d'avoir toutes les dépendances PHP installées. Vous pouvez utiliser Composer pour cela. Si vous n'avez pas Composer installé, vous pouvez le télécharger à partir de [https://getcomposer.org/](https://getcomposer.org/) et suivre les instructions d'installation pour votre système d'exploitation.

Une fois Composer installé, ouvrez un terminal dans le répertoire du projet et exécutez la commande suivante pour installer les dépendances :

`composer install`

### Exécuter les migrations et les seeders

Les migrations sont des scripts PHP qui permettent de gérer la structure de la base de données. Assurez-vous que toutes les tables nécessaires sont créées en exécutant les migrations. Dans le répertoire du projet, exécutez la commande suivante :


`php artisan migrate`

Ensuite exécutez :

`php artisan db:seed --class=ActivitySeeder`


### Lancer le projet

Pour accéder au style et aux ressources, exécutez la commande :

`php artisan storage:link`

Toujours dans le répertoire, exécutez :

`php artisan serve`


### Problèmes courants
Si vous rencontrez des problèmes lors de l'exécution du projet, assurez-vous que :

Votre serveur MySQL est en cours d'exécution. Les informations de la base de données dans le fichier `.env` sont correctes. La base de données `ffs` existe dans votre MySQL.