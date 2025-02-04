# ComptaEvent 📊

<p align="center">
  <img src="public/control/images/nft/mtwcomplet.png" alt="ComptaEvent Logo" width="200"/>
</p>

<p align="center">
  <a href="https://github.com/votre-username/ComptaEvent/blob/main/LICENSE">
    <img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License: MIT">
  </a>
  <a href="#">
    <img src="https://img.shields.io/badge/version-1.0.0-blue.svg" alt="Version">
  </a>
  <a href="#">
    <img src="https://img.shields.io/badge/PHP-7.4+-purple.svg" alt="PHP Version">
  </a>
  <a href="#">
    <img src="https://img.shields.io/badge/Laravel-8.x-red.svg" alt="Laravel Version">
  </a>
</p>

> Une solution moderne de gestion comptable pour vos événements et services, construite avec Laravel

## ✨ Caractéristiques principales

- 🏢 **Gestion multi-services** - Gérez plusieurs services avec leurs budgets dédiés
- 💰 **Suivi financier** - Suivez dépenses et recettes en temps réel
- 📊 **Tableaux de bord** - Visualisez vos données financières
- 📄 **Rapports PDF** - Générez des rapports détaillés
- 👥 **Gestion des utilisateurs** - Contrôle d'accès granulaire par service
- 📱 **Responsive** - Interface adaptative pour tous les appareils

## 🚀 Démarrage rapide

### Prérequis

- PHP >= 7.4
- Composer
- MySQL/MariaDB
- Node.js & NPM

### Installation en 5 minutes

```bash
# Cloner le projet
git clone https://github.com/votre-username/ComptaEvent.git

# Installer les dépendances
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate

# Démarrer le serveur
php artisan serve
