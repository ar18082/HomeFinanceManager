
# 📌 Plan de développement d’une application type Firefly III

**Tech stack :** PHP 8.3 · Laravel 12.16.0 · MySQL  
**Objectif :** Recréer une application de gestion financière comme Firefly III

---

## ✅ Liste des tâches

- [ ] **Initialiser le projet Laravel**  
  🔹 Prompt pour Cursor :  
  ```
  Crée-moi un projet Laravel 12.16.0 en PHP 8.3, en utilisant Composer. Configure le projet pour utiliser MySQL comme base de données et démarre le serveur local. Donne-moi les commandes terminal complètes à exécuter.
  ```

- [ ] **Modéliser la base de données (tables principales)**  
  🔹 Prompt pour Cursor :  
  ```
  Propose-moi un schéma de base de données pour une application de gestion financière personnelle comme Firefly III. Les tables doivent inclure : users, accounts, transactions, categories, budgets, tags, currencies, et toutes relations nécessaires (one-to-many, many-to-many). Explique-moi les champs de chaque table.
  ```

- [ ] **Créer les migrations et modèles Eloquent**  
  🔹 Prompt pour Cursor :  
  ```
  Écris-moi les migrations et modèles Eloquent Laravel pour ces tables : users, accounts, transactions, categories, budgets, tags, currencies. Chaque modèle doit inclure les relations (hasMany, belongsTo, belongsToMany, etc.). Ne fais pas les contrôleurs pour le moment.
  ```

- [ ] **Authentification et sécurité**  
  🔹 Prompt pour Cursor :  
  ```
  Configure l’authentification avec Laravel Breeze en utilisant TailwindCSS. Ajoute l’enregistrement, la connexion et la gestion du mot de passe oublié. Donne-moi les commandes et les étapes pour l’installation.
  ```

- [ ] **Gestion des comptes (accounts)**  
  🔹 Prompt pour Cursor :  
  ```
  Crée un CRUD complet (contrôleur, routes, vues) pour gérer les comptes bancaires : création, modification, suppression, affichage des comptes. Chaque compte a : nom, type (courant, épargne, etc.), solde initial, devise associée.
  ```

- [ ] **Gestion des transactions**  
  🔹 Prompt pour Cursor :  
  ```
  Crée un CRUD complet pour les transactions : ajout, édition, suppression, affichage. Chaque transaction a : date, montant, description, catégorie, compte source, compte destination (pour les transferts), tags éventuels, pièce jointe optionnelle.
  ```

- [ ] **Budgets et catégories**  
  🔹 Prompt pour Cursor :  
  ```
  Crée un système pour gérer les budgets mensuels par catégorie. Permets d’ajouter des catégories, d’affecter un montant prévu par mois, et de suivre les dépenses par rapport au budget. Donne-moi le code Laravel (contrôleurs, routes, modèles, vues).
  ```

- [ ] **Système de tags**  
  🔹 Prompt pour Cursor :  
  ```
  Ajoute un système de tags pour les transactions : création, édition, suppression, affichage. Permets d’associer plusieurs tags à une transaction (relation many-to-many). Donne-moi le code complet pour la gestion des tags.
  ```

- [ ] **Gestion des devises (multi-devises)**  
  🔹 Prompt pour Cursor :  
  ```
  Implémente la gestion des devises (multi-devises). Chaque compte a une devise. Ajoute une table currencies avec code ISO, symbole, taux de change. Prévois une conversion automatique des montants pour un rapport global en devise principale.
  ```

- [ ] **Tableaux de bord et rapports**  
  🔹 Prompt pour Cursor :  
  ```
  Propose-moi un tableau de bord avec des graphiques pour visualiser les dépenses par catégorie, les soldes par compte et l’évolution des transactions dans le temps (courbes, camemberts). Donne-moi le code en utilisant Laravel et un package JS pour les graphiques.
  ```

- [ ] **Import/Export (CSV, JSON)**  
  🔹 Prompt pour Cursor :  
  ```
  Ajoute une fonctionnalité pour importer et exporter des transactions au format CSV et JSON. Propose-moi une implémentation avec Laravel (contrôleurs, routes, vues) et une interface simple pour choisir le fichier à importer/exporter.
  ```

- [ ] **Gestion des fichiers joints**  
  🔹 Prompt pour Cursor :  
  ```
  Permets d’ajouter une pièce jointe (PDF, image) à une transaction. Donne-moi le code Laravel pour gérer l’upload, le stockage (dans storage/app/public), et l’affichage/téléchargement des fichiers.
  ```

- [ ] **Gestion des utilisateurs et permissions**  
  🔹 Prompt pour Cursor :  
  ```
  Implémente un système de gestion des rôles (admin, utilisateur) et de permissions pour restreindre l’accès à certaines pages ou fonctionnalités. Propose une solution avec Laravel Gates ou Policies.
  ```

- [ ] **API REST pour intégration externe**  
  🔹 Prompt pour Cursor :  
  ```
  Ajoute une API REST pour permettre à des applications externes d’accéder aux données : comptes, transactions, budgets. Protège l’API avec une authentification via tokens (Sanctum). Donne-moi le code complet pour une route d’API sécurisée.
  ```

- [ ] **Documentation et README**  
  🔹 Prompt pour Cursor :  
  ```
  Propose-moi un modèle complet de README.md pour documenter l’installation, les fonctionnalités, les technologies utilisées, et les instructions pour contribuer au projet. Inclue aussi un schéma simplifié de la base de données.
  ```

- [ ] **Tests automatisés**  
  🔹 Prompt pour Cursor :  
  ```
  Écris des tests unitaires et fonctionnels pour valider le bon fonctionnement des principales fonctionnalités : comptes, transactions, budgets, authentification. Donne-moi un exemple de test complet.
  ```

- [ ] **Déploiement sur serveur**  
  🔹 Prompt pour Cursor :  
  ```
  Explique-moi les étapes pour déployer cette application Laravel sur un serveur Ubuntu 22.04 LTS avec Nginx, PHP 8.3 et MySQL. Donne-moi la configuration Nginx, les commandes nécessaires et la gestion des permissions des fichiers.
  ```
