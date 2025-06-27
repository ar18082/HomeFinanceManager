<p align="center">
  <img src="public/img/logo.png" width="120" alt="HomeManager Logo">
</p>

# HomeManager

## 🇫�� Prérequis

Avant d'installer HomeManager, assurez-vous d'avoir :

- PHP >= 8.1 avec les extensions courantes (pdo, mbstring, openssl, tokenizer, xml, ctype, json, bcmath, fileinfo, etc.)
- [Composer](https://getcomposer.org/) (gestionnaire de dépendances PHP)
- [Node.js & npm](https://nodejs.org/) (pour la compilation des assets)
- MySQL ou MariaDB (ou autre base compatible Laravel)
- Un serveur web (Apache, Nginx, ou Laravel Valet/Artisan)

---

## 🇫🇷 Guide d'installation et d'utilisation

### Présentation

**HomeManager** est une application Laravel pour la gestion des finances personnelles, des comptes, des budgets, des transactions, des crédits, des objectifs d'épargne, et le suivi détaillé des compteurs d'énergie (électricité, gaz, eau) avec gestion des fournisseurs, tarifs et relevés.

---

### Installation

1. **Cloner le dépôt**
   ```bash
  git clone https://github.com/ar18082/HomeFinanceManager.git
   cd HomeFinanceManager-new
   ```
2. **Installer les dépendances**
   ```bash
   composer install
   npm install
   ```
3. **Configurer l'environnement**
   - Copier `.env.example` en `.env`
   - Adapter les variables (DB, mail, etc.)
   - Générer la clé d'application :
     ```bash
     php artisan key:generate
     ```
4. **Créer la base de données**
   - Créer une base de données MySQL/MariaDB
   - Adapter la config dans `.env`
5. **Lancer les migrations et seeders**
   ```bash
   php artisan migrate
   php artisan db:seed --class=DatabaseSeeder
   ```
6. **Compiler les assets**
   ```bash
   npm run build
   ```
7. **Démarrer le serveur**
   ```bash
   php artisan serve
   ```
   Ou utiliser Laragon/XAMPP/Valet selon votre environnement.

---

### Fonctionnalités principales

- Gestion des comptes, catégories, transactions, budgets, crédits, objectifs d'épargne
- Suivi des compteurs d'énergie (électricité, gaz, eau)
- Gestion des relevés, calculs de consommation et de coûts
- Gestion des fournisseurs d'énergie, contrats, tarifs évolutifs
- Notifications, rapports, statistiques

---

### Accès

- Accéder à l'application via [http://localhost:8000](http://localhost:8000) ou l'URL de votre serveur local.
- Créez un compte utilisateur pour commencer.

---

### Personnalisation

- Le logo se trouve dans `public/img/logo.png`
- Les vues sont dans `resources/views/`
- Les seeders de tarifs sont dans `database/seeders/`

---

## 🇬🇧 Prerequisites

Before installing HomeManager, make sure you have:

- PHP >= 8.1 with common extensions (pdo, mbstring, openssl, tokenizer, xml, ctype, json, bcmath, fileinfo, etc.)
- [Composer](https://getcomposer.org/) (PHP dependency manager)
- [Node.js & npm](https://nodejs.org/) (for asset compilation)
- MySQL or MariaDB (or any Laravel-compatible database)
- A web server (Apache, Nginx, or Laravel Valet/Artisan)

---

## 🇬🇧 Installation & Usage Guide

### Overview

**HomeManager** is a Laravel application for personal finance management: accounts, budgets, transactions, credits, savings goals, and detailed energy meter tracking (electricity, gas, water) with provider, tariff, and reading management.

---

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/ar18082/HomeFinanceManager.git
   cd HomeFinanceManager-new
   ```
2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```
3. **Configure environment**
   - Copy `.env.example` to `.env`
   - Set your environment variables (DB, mail, etc.)
   - Generate app key:
     ```bash
     php artisan key:generate
     ```
4. **Create the database**
   - Create a MySQL/MariaDB database
   - Update `.env` with your DB credentials
5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed --class=DatabaseSeeder
   ```
6. **Build frontend assets**
   ```bash
   npm run build
   ```
7. **Start the server**
   ```bash
   php artisan serve
   ```
   Or use Laragon/XAMPP/Valet as you prefer.

---

### Main Features

- Manage accounts, categories, transactions, budgets, credits, savings goals
- Track energy meters (electricity, gas, water)
- Manage readings, consumption and cost calculations
- Manage energy providers, contracts, historical tariffs
- Notifications, reports, statistics

---

### Access

- Access the app at [http://localhost:8000](http://localhost:8000) or your local server URL.
- Register a user account to get started.

---

### Customization

- The logo is in `public/img/logo.png`
- Views are in `resources/views/`
- Tariff seeders are in `database/seeders/`

---

**N'hésitez pas à demander si vous souhaitez ajouter des badges, captures d'écran ou autres sections !**
**Let me know if you want badges, screenshots, or more sections!**
