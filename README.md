# 🐾 Arcadia - Application Web du Zoo

Bienvenue dans le dépôt officiel de l'application web **Arcadia**, développée pour le zoo du même nom situé en Bretagne. Ce projet a été réalisé dans le cadre de l'examen du titre professionnel **Développeur Web et Web Mobile**.

## 🌿 Présentation

Arcadia est un zoo écoresponsable. L'application permet aux visiteurs de consulter les habitats, les animaux, les services, les horaires et les avis du zoo. Elle dispose également d'espaces dédiés aux vétérinaires, employés et à l'administrateur pour la gestion quotidienne.

## ⚙️ Technologies utilisées

- **Front-end** : HTML5, CSS3 (Bootstrap), JavaScript
- **Back-end** : PHP (PDO)
- **Base de données relationnelle** : MySQL / MariaDB
- **Base de données NoSQL** : MongoDB
- **Déploiement** : Fly.io / Heroku / Vercel (au choix)
- **Gestion de projet** : Trello / Notion / Jira (Kanban)

---

## 🚀 Installation locale

### 1. Prérequis

- PHP ≥ 7.4
- Serveur Apache ou équivalent (XAMPP, WAMP, MAMP, Laragon)
- MySQL ou MariaDB
- MongoDB
- phpMyAdmin (optionnel mais recommandé)

### 2. Cloner le projet

```bash
git clone https://github.com/votre-utilisateur/arcadia-zoo.git
cd arcadia-zoo
```

### 3. Configuration de la base de données avec phpMyAdmin

#### Créer la base de données avec phpMyAdmin :

- Ouvre phpMyAdmin : http://localhost/phpmyadmin

- Clique sur "Importer"

- Sélectionne le fichier `arcadia.sql` situé dans le dossier `/config/` du projet
- Cliquer sur "Exécuter"
- La base arcadia et toutes ses tables seront automatiquement créées

#### Via la ligne de commande MySQL

```bash
mysql -u root -p < path/to/database/arcadia.sql
```

Remplace Remplace `path/to/database/arcadia.sql` par le chemin réel vers le fichier sur ton système.

### 4. Configuration des variables

Crée un fichier Database.php pour y accéder à la base de données que tu viens de créer

```bash
<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=arcadia;charset=utf8", "", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>

```

### 5. Démarrer l'application

- Place le projet dans le dossier de ton serveur local : `htdocs` XAMPP
- Accède à http://localhost/arcadia-zoo dans ton navigateur

## 👤 Accès aux comptes

- Dans la base de données aller dans la table users et crée un admin avec les données. Ensuite accéder avec le bouton de connexion à la page `admin.php`
- Par la suite crée un ou plusieurs utilisateurs avec des rôles differents en créeant des mail et mot de passe fictifs.
- Après avoir créer des utilisateurs et tester le dashboard admin, deconnecter vous et connecter vous avec l'employer et ensuite avec vétérinaire
- Tester toutes les fonctionnalités

## 📁 Structure du projet

Le projet suit une architecture MVC (Model - View - Controller) avec une séparation claire des responsabilités. Voici une vue d'ensemble de l’arborescence :

<pre> arcadia-zoo/
├── .vscode/                  # Configuration de l'éditeur
├── config/                   # Fichier de configuration (connexion BDD, etc.)
│   └── Database.php
├── controller/               # Contrôleurs de l'application
│   ├── Manager/              # Contrôleurs métiers
│   ├── AdminController.php
│   ├── AuthController.php
│   ├── ContactController.php
│   ├── logout.php
│   ├── traiter_avis.php
│   └── veterinaireController.php
├── includes/                 # Fichiers réutilisables (headers, footers, middlewares, etc.)
├── model/                    # Classes d'accès aux données (PDO)
├── node_modules/             # Dépendances npm (si frontend dynamique)
├── public/                   # Dossier public (accessible depuis navigateur)
│   ├── design/               # Styles CSS / assets design
│   ├── images/               # Images générales
│   ├── scripts/              # Scripts JS
│   └── uploads/              # Fichiers uploadés par l’utilisateur
│                             # Images d’animaux
│                             # Images des services                     
├── view/                     # Fichiers de vues HTML/PHP
├── .gitignore                # Fichiers ignorés par Git
├── idees.txt                 # Notes ou idées de développement
├── index.php                 # Point d’entrée principal de l'application
├── notes.txt                 # Notes supplémentaires du développeur
├── package.json              # Dépendances front-end (si utilisées)
├── package-lock.json
└── README.md                 # Guide d’installation et documentation
</pre>

## 📌 Fonctionnalités principales

- Consultation des habitats et animaux

- Vue des services

- Connexion sécurisée (admin, veto, employé)

- Gestion des commentaires et alimentation

- Statistiques de fréquentation (MongoDB)

- Tableau de bord administrateur

## 🌱 Écologie et éthique

Ce projet s'inscrit dans une démarche de respect de l’environnement, à l’image du zoo Arcadia. La palette de couleurs et l'interface ont été pensées dans un esprit écologique et naturel.
