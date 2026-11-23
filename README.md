# suivi d'un espace : grand titre (un seul, en haut).
## : titre de partie.
- en début de ligne : élément de liste.
Du texte entre deux accents graves ` : un mot de code, par exemple `config.php`.

Ce que tu écris maintenant (partie 1 seulement) :

Le grand titre, avec le nom du projet.
En dessous, 2 ou 3 phrases de présentation : c'est quoi Elno, à quoi sert le site, et que c'est toi qui le développes.
Un titre ## pour la partie suivante, « Technologies », sans rien dessous pour l'instant.

# ELNO 

## Présentation

Elno est un site de demande de réservation de concerts du duo 'Elno', pour les professionnels et particuliers, développé par SOUAL Clara. Il y a un côté client pour la présentation du site, du projet et la demande de réservation, et un côté administrateur est à venir pour la gestion des demandes.

## Technologies

- PHP : langage côté serveur (pages, formulaires, communication avec la BDD)
- MySQL/MariaDB : base de données relationnelle
- PDO : outil PHP pour la connexion à la BDD (requêtes préparées)
- Composer : gestionnaire de paquets
- PHPMailer : bibliothèque pour l'envoi de mails en SMTP
- HTML/CSS : squelette et style
- Prévu : Symfony + EasyAdmin, Vue.js et Railway

## Installation

1. Prérequis

- XAMPP (Apache et MySQL) et Composer installés

2. Récupération du projet

- Faire un `git clone`
```
cd /Applications/XAMPP/xamppfiles/htdocs
git clone https://github.com/clarasoual/elno.git elno-site
```

3. Installation des dépendances 

- Utiliser `composer install` pour créer le dossier `vendor`

```
cd elno-site
composer install
```

4. Créer la BDD `elno`

- Créer la base `elno` dans phpMyAdmin 

- Importer `database/schema.sql`

5. Créer le fichier de configuration

- copier `config/config.example.php` en `config/config.php`

- `config/config.example.php` :

```
<?php 
return [
    'host' => 'localhost' ,
    'dbname' => 'elno' ,
    'user' => 'root' ,
    'password' => '' ,
    'mail' => [
        'host' => 'sandbox.smtp.example',
        'port' => 2525,
        'username' => '12example34',
        'password' => '',
        'from_email' => 'contact@example.fr',
        'from_name' => 'NameExample',
        'admin_email' => 'email@exemple.fr',
    ],
] ;
```

- remplir ses propres valeurs

6. Ouvrir le site

- http://localhost/elno-site/public/

## Organisation des dossiers

- `admin` : fichiers des pages administrateurs
- `config` : fichier des identifiants (BDD, SMTP)
- `database` : schéma de la BDD
- `public` : fichiers des pages publiques
- `src` : fonctions PHP réutilisables (database.php et mailer.php)
- `templates` : composants php (header, footer)
- `vendor` : bibliothèques installées par Composer (PHPMailer, recréé par `composer install`)
