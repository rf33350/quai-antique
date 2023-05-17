# Déploiement du site Quai Antique | Restaurant

Ce fichier a pour but de décrire la démarche à suivre pour le déploiement en local et en ligne du projet

## Tech Stack

**Front** HTML + CSS + JS + Bootstrap

**Back** PHP 8.1 + SYMFONY 6.1

**Base de données** MySQL + migrations Symfony

**Envoi de mails** [Mailjet](https://www.mailjet.com/fr/)

## Deploiement local

Pour déployer ce site en local, il faut tout d'abord récupérer la dernière version à jour:

```bash
  git clone https://github.com/rf33350/quai-antique.git
```

Il faut ensuite créer la base de donnée qui hébergera les données du site.

```bash
  /*Creation de la base de données quai_antique*/
CREATE DATABASE IF NOT EXISTS quai_antique CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

Puis faire le lien entre la base de données et le projet symfony dans le fichier .env

DATABASE_URL="mysql://XXXX:PPPP@YYYY:ZZZZ/quai_antique?serverVersion=mariadb-10.5.5"
Où XXXX est l'administrateur de ta base de données, PPPP le mot de passe,
YYYY l'adresse du serveur sur lequel le site sera hébergé,
et ZZZZ le port sur lequel la base de données est disponible.

On se place à la racine du répertoire quai_antique.

S'assurer que toutes les dépendances de symfony soit installées

```bash
  php composer.phar update 
```

Migrer les tables du projet vers la base de données.

```bash
  symfony console doctrine:migrations:migrate   
```

Lorsque la base de données a été migrée, il faut créer un administrateur afin de pouvoir modifier et ajouter des informations sur le site (plats, menus, réservations...)

Alternativement à la migration Symfony, vous pouvez exécuter les commandes SQL du fichier '230516_rf_quai-antique_database_tables_SQL.sql' qui se trouve dans le dossier /sql du projet.

```bash
  INSERT INTO user (email, roles, password, first_name, last_name, allergy) VALUES ('XXXX', '["ROLE_USER","ROLE_ADMIN"]', 'YYYY', 'adminFirstName', 'adminLastName', '-');
```
Où XXXX est l'email de l'administrateur du site, YYYY le mot de passe,
Attention, il faut que le mot de passe soit au préalable hashé.

Vous pouvez également exécuter les commandes du fichier '230516_rf_quai-antique_fixtures.sql' qui se trouve dans le dossier /sql du projet.

Une fois les modifications apportées au code, vous pouvez lancer le serveur de symfony en local pour vérifier le fonctionnement du site

```bash
  symfony server:start
```

## Deploiement en ligne

Dans le processus d'installation des dépendances symfony, ajouter l'installation d'Apache-pack

```bash
  php composer.phar require symfony/apache-pack
```

A noter que pour ce type de déploiement la base de données et les fichiers doivent être créée et importés selon le dispositif que l'hébergeur a mis en place.


## Support

Pour tout besoin d'aide me contacter par [ce mail](mailto:djaroul@hotmail.fr).