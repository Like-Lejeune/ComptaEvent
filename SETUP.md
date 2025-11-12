# Guide d'installation ComptaEvent

Ce guide vous aidera à installer et configurer l'application ComptaEvent.

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et npm
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx)

## Installation

### 1. Cloner le projet

```bash
git clone <repository-url>
cd ComptaEvent
```

### 2. Installer les dépendances

```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances Node.js
npm install
```

### 3. Configuration de l'environnement

```bash
# Copier le fichier .env (si nécessaire)
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Générer la clé JWT
php artisan jwt:secret --force
```

### 4. Configuration de la base de données

Éditez le fichier `.env` et configurez vos paramètres de base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=comptaevent
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

### 5. Créer la base de données

```sql
CREATE DATABASE comptaevent CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Exécuter les migrations

```bash
php artisan migrate
```

### 7. Exécuter les seeders

```bash
php artisan db:seed
```

Cela créera :
- Les profils par défaut (Administrateur, Gestionnaire, Utilisateur)
- Un compte administrateur avec les identifiants suivants :
  - Email : `admin@comptaevent.com`
  - Mot de passe : `Admin@2025`

### 8. Publier les configurations

```bash
# Publier les configurations JWT
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

# Publier les assets DomPDF (si nécessaire)
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### 9. Créer les dossiers nécessaires

```bash
mkdir -p public/images/work_doc
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 public/images
```

### 10. Compiler les assets

```bash
npm run build
# ou pour le développement
npm run dev
```

### 11. Démarrer le serveur

```bash
php artisan serve
```

L'application sera accessible à l'adresse : `http://localhost:8000`

## Compte par défaut

Après l'exécution des seeders, vous pouvez vous connecter avec :
- **Email** : admin@comptaevent.com
- **Mot de passe** : Admin@2025

⚠️ **Important** : Changez ce mot de passe après votre première connexion !

## Structure des profils

### Administrateur
- Accès complet à toutes les fonctionnalités
- Gestion des utilisateurs
- Gestion des services
- Gestion des dépenses et recettes
- Consultation des rapports
- Accès aux logs

### Gestionnaire
- Gestion des dépenses et recettes
- Consultation des rapports
- Pas d'accès à l'administration

### Utilisateur
- Consultation des rapports uniquement
- Accès en lecture seule

## Fonctionnalités principales

1. **Gestion des services** : Création et gestion de services avec budgets
2. **Gestion des dépenses** : Enregistrement des dépenses avec pièces justificatives
3. **Gestion des recettes** : Enregistrement des revenus par service
4. **Rapports PDF** : Génération d'états financiers (global et par service)
5. **Gestion des utilisateurs** : CRUD complet avec profils et permissions
6. **Traçabilité** : Système de logs pour toutes les actions

## Sécurité

### Validation des fichiers
Les fichiers uploadés sont validés :
- Extensions autorisées : pdf, jpg, jpeg, png, doc, docx, xls, xlsx
- Taille maximale : 5MB
- Noms de fichiers sécurisés (uniques et non prédictibles)

### Authentification
- Authentification via Laravel Sanctum
- Support JWT pour les API
- Système de profils avec permissions JSON

## Développement

### Environnement de développement

```bash
# Démarrer le serveur de développement
php artisan serve

# Compiler les assets en mode watch
npm run dev

# Nettoyer les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Tests

```bash
# Exécuter les tests
php artisan test
```

## Dépannage

### Erreur de permissions
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Erreur de clé d'application
```bash
php artisan key:generate
```

### Problèmes de migrations
```bash
php artisan migrate:fresh --seed
```

## Support

Pour toute question ou problème, consultez la documentation Laravel : https://laravel.com/docs/10.x

## Licence

MIT License - Voir le fichier LICENSE pour plus de détails.
