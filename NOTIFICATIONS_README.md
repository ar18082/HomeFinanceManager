# Système de Notifications - Home Finance Manager

## Vue d'ensemble

Le système de notifications a été intégré pour vous rappeler automatiquement des débits et paiements effectués dans votre gestionnaire financier. Il couvre trois types principaux d'opérations automatiques :

1. **Transactions récurrentes** - Notifications lors de l'exécution de transactions récurrentes
2. **Paiements de crédit** - Notifications lors des paiements mensuels de crédit
3. **Objectifs d'épargne** - Notifications lors des contributions et atteinte d'objectifs

## Fonctionnalités

### 🔔 Notifications en temps réel
- Notifications dans l'interface utilisateur avec indicateur visuel
- Notifications par email (si configuré)
- Stockage en base de données pour historique

### 📱 Interface utilisateur
- Dropdown de notifications dans la navigation
- Page dédiée pour voir toutes les notifications
- Possibilité de marquer comme lu/supprimer
- Indicateur de notifications non lues

### ⚡ Automatisation
- Génération automatique des transactions récurrentes (quotidienne)
- Génération automatique des paiements de crédit (mensuelle)
- Notifications automatiques lors des contributions d'épargne

## Installation et configuration

### 1. Migration de la base de données
```bash
php artisan migrate
```

### 2. Configuration des tâches planifiées
Ajoutez cette ligne à votre crontab pour exécuter les tâches automatiques :
```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Configuration email (optionnel)
Pour recevoir les notifications par email, configurez votre fichier `.env` :
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=notifications@yourapp.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Utilisation

### Commandes artisan disponibles

#### Générer les transactions récurrentes
```bash
php artisan app:generate-recurring-transactions
```
Cette commande :
- Vérifie les transactions récurrentes dues
- Génère les transactions correspondantes
- Envoie les notifications aux utilisateurs

#### Générer les paiements de crédit
```bash
php artisan app:generate-credit-payments
```
Cette commande :
- Vérifie les crédits actifs
- Génère les paiements mensuels
- Met à jour les soldes restants
- Envoie les notifications

### Interface utilisateur

#### Accéder aux notifications
1. Cliquez sur l'icône de cloche dans la navigation
2. Ou allez sur `/notifications` pour voir toutes les notifications

#### Actions disponibles
- **Marquer comme lu** : Cliquez sur le bouton ✓ ou "Marquer comme lu"
- **Supprimer** : Cliquez sur "Supprimer" pour supprimer une notification
- **Tout marquer comme lu** : Bouton en haut de la page des notifications

## Types de notifications

### 1. Transaction récurrente exécutée
- **Déclencheur** : Génération automatique d'une transaction récurrente
- **Contenu** : Description, montant, compte, catégorie
- **Fréquence** : Selon la fréquence définie dans la transaction récurrente

### 2. Paiement de crédit effectué
- **Déclencheur** : Génération automatique du paiement mensuel
- **Contenu** : Nom du crédit, montant payé, solde restant
- **Fréquence** : Mensuelle (le 1er du mois)

### 3. Contribution à l'objectif d'épargne
- **Déclencheur** : Ajout d'une contribution via `addProgress()`
- **Contenu** : Nom de l'objectif, montant, progression
- **Fréquence** : À chaque contribution

### 4. Objectif d'épargne atteint
- **Déclencheur** : Atteinte du montant cible
- **Contenu** : Félicitations, montant final
- **Fréquence** : Une seule fois par objectif

## Personnalisation

### Modifier les notifications
Les notifications sont définies dans :
- `app/Notifications/RecurringTransactionNotification.php`
- `app/Notifications/CreditPaymentNotification.php`
- `app/Notifications/SavingsGoalNotification.php`

### Modifier les templates email
Les templates email peuvent être personnalisés en publiant les vues :
```bash
php artisan vendor:publish --tag=laravel-notifications
```

### Modifier l'interface
Les vues se trouvent dans :
- `resources/views/notifications/index.blade.php`
- `resources/views/components/notification-dropdown.blade.php`

## Dépannage

### Les notifications ne s'affichent pas
1. Vérifiez que la migration a été exécutée
2. Vérifiez que le trait `Notifiable` est présent dans le modèle User
3. Vérifiez les logs Laravel pour les erreurs

### Les tâches planifiées ne s'exécutent pas
1. Vérifiez que le crontab est configuré
2. Testez manuellement les commandes artisan
3. Vérifiez les permissions sur les fichiers

### Les emails ne sont pas envoyés
1. Vérifiez la configuration SMTP dans `.env`
2. Testez l'envoi d'email avec `php artisan tinker`
3. Vérifiez les logs d'erreur

## Sécurité

- Les notifications sont liées à l'utilisateur authentifié
- Seuls les utilisateurs peuvent voir leurs propres notifications
- Les routes sont protégées par le middleware d'authentification
- Les actions AJAX incluent les tokens CSRF

## Support

Pour toute question ou problème :
1. Vérifiez les logs Laravel (`storage/logs/laravel.log`)
2. Testez les commandes manuellement
3. Vérifiez la configuration de votre environnement 