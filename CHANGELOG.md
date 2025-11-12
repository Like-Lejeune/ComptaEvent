# Changelog

Toutes les modifications notables de ce projet seront documentées dans ce fichier.

## [Refactorisation Complète] - 2025-11-12

### Ajouté
- **Modèles Eloquent** : Création des modèles manquants (Depense, Recette, PieceJointe)
- **Relations Eloquent** : Ajout de toutes les relations entre les modèles
  - User → Profile, Services, Depenses, Recettes
  - Service → Users, Depenses, Recettes
  - Depense → Service, User, PiecesJointes
  - Recette → Service, User
  - Profile → Users
- **Seeder AdminUser** : Création d'un seeder pour l'utilisateur administrateur par défaut
- **Documentation** : Ajout du fichier SETUP.md avec instructions complètes d'installation
- **Configuration JWT** : Publication et configuration complète de JWT Auth

### Amélioré
- **Sécurité des uploads** :
  - Validation stricte des extensions de fichiers (whitelist)
  - Validation de la taille maximale (5MB)
  - Génération de noms de fichiers sécurisés et uniques
  - Création automatique des dossiers d'upload
- **Validation des données** :
  - Validation renforcée dans depenseController
  - Validation des types de données et des valeurs minimales
  - Validation de l'existence des relations (exists:services,id_service)
- **Modèles** :
  - Ajout du cast 'hashed' pour les mots de passe
  - Configuration correcte des clés primaires (id_service, id_depense, etc.)
  - Ajout des fillable et casts appropriés
- **Seeders** : Mise à jour du DatabaseSeeder pour inclure ProfileSeeder et AdminUserSeeder
- **Dépendances** : Mise à jour de tous les packages Composer vers des versions compatibles PHP 8.4

### Corrigé
- **Compatibilité PHP 8.4** : Résolution des conflits de dépendances
- **Clés d'application** : Génération des clés APP_KEY et JWT_SECRET
- **Permissions de dossiers** : Création et configuration des permissions pour storage et uploads
- **Cache** : Nettoyage et recréation des caches de configuration

### Sécurisé
- Protection contre l'upload de fichiers dangereux
- Validation stricte des entrées utilisateur
- Utilisation de noms de fichiers non prédictibles

### Technique
- Passage de DB::table() vers l'utilisation recommandée des modèles Eloquent (préparation)
- Configuration complète de l'environnement Laravel
- Mise en place de la structure pour l'authentification JWT

## Notes de migration

### Compte administrateur par défaut
- Email : admin@comptaevent.com
- Mot de passe : Admin@2025
- ⚠️ À changer après la première connexion !

### Profils créés
1. **Administrateur** : Accès complet
2. **Gestionnaire** : Gestion des dépenses/recettes
3. **Utilisateur** : Consultation uniquement

### Extensions de fichiers autorisées
- Documents : pdf, doc, docx, xls, xlsx
- Images : jpg, jpeg, png

### Taille maximale des fichiers
- 5MB par fichier
