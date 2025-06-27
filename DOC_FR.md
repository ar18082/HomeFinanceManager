# HomeManager – Documentation (FR)

## Présentation

**HomeManager** est une application Laravel pour la gestion des finances personnelles et du suivi énergétique du foyer. Elle permet de gérer comptes, budgets, transactions, crédits, objectifs d’épargne, ainsi que les compteurs d’énergie (électricité, gaz, eau), les relevés, les fournisseurs et les tarifs.

---

## Installation

1. **Cloner le dépôt**
   ```bash
   git clone <url-du-repo>
   cd HomeFinanceManager-new
   ```
2. **Installer les dépendances**
   ```bash
   composer install
   npm install
   ```
3. **Configurer l’environnement**
   - Copier `.env.example` en `.env`
   - Adapter les variables (DB, mail, etc.)
   - Générer la clé d’application :
     ```bash
     php artisan key:generate
     ```
4. **Créer la base de données**
   - Créer une base MySQL/MariaDB
   - Adapter la config dans `.env`
5. **Lancer les migrations et seeders**
   ```bash
   php artisan migrate
   php artisan db:seed --class=MegaEnergySeeder
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

## Fonctionnalités principales

- Comptes, catégories, transactions, budgets, crédits, objectifs d’épargne
- Suivi des compteurs d’énergie (électricité, gaz, eau)
- Gestion des relevés, calculs de consommation et de coûts
- Gestion des fournisseurs d’énergie, contrats, tarifs évolutifs
- Notifications, rapports, statistiques

---

## Utilisation

1. **Créer un compte utilisateur**
2. **Ajouter vos comptes bancaires et catégories**
3. **Saisir vos transactions et budgets**
4. **Ajouter vos compteurs d’énergie** (électricité, gaz, eau)
5. **Saisir vos premiers relevés**
6. **Configurer vos fournisseurs et tarifs**
7. **Consulter les rapports et statistiques**

---

## Exemples d’utilisation

### Suivi d’un compteur d’électricité
1. Menu « Énergie » → « Compteurs » → « Ajouter compteur »
2. Remplir les informations (nom, type, numéro, unité, etc.)
3. Enregistrer
4. Menu « Énergie » → « Ajouter relevé » pour saisir une nouvelle lecture
5. Les coûts et consommations sont calculés automatiquement selon les tarifs actifs

### Ajout d’un fournisseur d’énergie
1. Menu « Énergie » → « Fournisseurs » → « Ajouter »
2. Saisir le nom, code, site web, email, etc.
3. Ajouter les tarifs associés (électricité, gaz, etc.)

### Analyse d’un rapport de consommation
1. Menu « Rapports » → « Vue d’ensemble » ou « Mensuel »
2. Sélectionner la période souhaitée
3. Visualiser l’évolution de la consommation et des coûts

---

## Cas d’usage

- **Gestion multi-compteurs** : Suivi séparé de plusieurs compteurs (ex : maison, garage, appartement)
- **Historique des tarifs** : Changement automatique des tarifs selon la date de validité
- **Alertes et notifications** : Rappel pour saisir un relevé ou payer une facture
- **Budgétisation énergétique** : Comparaison des dépenses d’énergie avec le budget global

---

## Bonnes pratiques

- Saisir régulièrement les relevés pour un suivi précis
- Mettre à jour les tarifs lors de chaque changement de contrat
- Utiliser les catégories pour organiser vos transactions
- Exporter les rapports pour analyse ou archivage

---

## Conseils

- Personnalisez les unités selon vos besoins (kWh, m³, etc.)
- Ajoutez des notes sur chaque compteur ou relevé pour garder un historique contextuel
- Utilisez les objectifs d’épargne pour planifier des projets liés à l’énergie (ex : achat d’un nouvel appareil)
- Consultez les statistiques pour détecter des anomalies de consommation

---

## Personnalisation

- Logo : `public/img/logo.png`
- Vues : `resources/views/`
- Seeders de tarifs : `database/seeders/`
- Ajoutez vos propres fournisseurs, tarifs, ou adaptez les vues selon vos besoins

---

## FAQ & Astuces

**Q : Comment ajouter un nouveau fournisseur d’énergie ?**
> Menu Énergie → Fournisseurs → Ajouter

**Q : Comment modifier un tarif ?**
> Menu Énergie → Fournisseurs → Détails → Modifier le tarif

**Q : Où trouver les rapports ?**
> Menu Rapports (dans la navigation principale)

**Q : Puis-je personnaliser les catégories ou unités ?**
> Oui, tout est modifiable depuis l’interface.

---

## Liens utiles
- [Documentation Laravel](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/)
- [Support Laravel](https://laracasts.com/)

---

**Pour toute question ou contribution, ouvrez une issue ou contactez le mainteneur du projet.** 