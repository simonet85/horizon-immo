# 🔐 Guide d'Administration - HorizonImmo / ZB Investments

## 🎯 Guide complet pour les administrateurs

Ce guide détaille toutes les fonctionnalités d'administration de la plateforme HorizonImmo.

---

## 📋 Table des matières

1. [Accès au panel d'administration](#1-accès-au-panel-dadministration)
2. [Tableau de bord](#2-tableau-de-bord)
3. [Gestion des propriétés](#3-gestion-des-propriétés)
4. [Gestion des catégories](#4-gestion-des-catégories)
5. [Messages de contact](#5-messages-de-contact)
6. [Demandes d'accompagnement](#6-demandes-daccompagnement)
7. [Gestion du contenu d'accueil](#7-gestion-du-contenu-daccueil)
8. [Gestion des utilisateurs](#8-gestion-des-utilisateurs)
9. [Configuration système](#9-configuration-système)
10. [Maintenance et sauvegardes](#10-maintenance-et-sauvegardes)

---

## 1. Accès au panel d'administration

### 🔐 Connexion administrateur

**URL :** `https://horizonimmo.test/login`

**Identifiants par défaut (à modifier) :**
- **Email :** `admin@example.com`
- **Mot de passe :** `password`

**⚠️ IMPORTANT : Changez immédiatement ces identifiants après la première connexion !**

### 🔑 Sécurité du compte

**Bonnes pratiques :**
- ✅ Utilisez un mot de passe fort (min. 12 caractères)
- ✅ Activez l'authentification à deux facteurs si disponible
- ✅ Ne partagez jamais vos identifiants
- ✅ Déconnectez-vous après chaque session
- ✅ Ne vous connectez que depuis des réseaux sécurisés

### 🚪 Déconnexion

Cliquez sur votre nom d'utilisateur en haut à droite → **"Se déconnecter"**

---

## 2. Tableau de bord

**URL :** `https://horizonimmo.test/admin/dashboard`

### 📊 Statistiques en temps réel

Le tableau de bord affiche les indicateurs clés de performance (KPI) :

#### **Statistiques principales**

**Carte 1 : Propriétés Totales** 🏠
- Nombre total de biens dans la base
- Icône maison
- Fond bleu

**Carte 2 : Biens Disponibles** ✅
- Propriétés avec statut "available"
- Icône check
- Fond vert

**Carte 3 : Biens Vendus** 💰
- Propriétés avec statut "sold"
- Icône argent
- Fond indigo

**Carte 4 : Demandes de Contact** 📧
- Nombre total de messages reçus
- Icône enveloppe
- Fond orange

#### **Graphiques et analyses**

- 📈 Évolution des propriétés ajoutées (si disponible)
- 📊 Répartition par catégorie
- 🌍 Répartition par ville
- 💵 Distribution des prix

### ⚡ Actions rapides

Boutons d'accès rapide vers :
- ➕ **Ajouter une propriété**
- 📧 **Voir les messages**
- 👥 **Demandes d'accompagnement**
- ⚙️ **Paramètres**

---

## 3. Gestion des propriétés

**URL :** `https://horizonimmo.test/admin/properties`

### 📋 Liste des propriétés

**Tableau récapitulatif** avec colonnes :
- 📸 **Image** (miniature)
- 🏠 **Titre**
- 🏷️ **Catégorie**
- 📍 **Ville**
- 💰 **Prix** (en FCFA)
- 📊 **Statut** (Available / Sold / Reserved)
- 🌟 **En vedette** (Oui/Non)
- ⚙️ **Actions** (Voir / Modifier / Supprimer)

**Fonctionnalités du tableau :**
- 🔍 **Recherche** en temps réel
- 🔽 **Tri** par colonne (cliquer sur l'en-tête)
- 📄 **Pagination** (10, 25, 50 résultats par page)
- 🔖 **Filtres** par statut et catégorie

### ➕ Ajouter une propriété

**Bouton :** "Ajouter une propriété"

#### **Formulaire d'ajout**

**Section 1 : Informations principales**

1. **Titre** * (texte, 255 caractères max)
   - Exemple : "Villa moderne vue sur mer"

2. **Description** * (textarea, illimité)
   - Description complète du bien
   - Mise en forme simple supportée

3. **Prix** * (nombre)
   - En ZAR (Rand Sud-Africain)
   - Conversion automatique en FCFA (×30) sur le site

4. **Catégorie** * (liste déroulante)
   - Villa
   - Appartement
   - Maison familiale
   - Penthouse
   - Terrain
   - Investissement locatif

5. **Ville** * (texte)
   - Exemple : Le Cap, Johannesburg, Pretoria

6. **Adresse complète** (texte optionnel)

**Section 2 : Caractéristiques**

7. **Nombre de chambres** * (nombre, min: 1)

8. **Nombre de salles de bain** * (nombre, min: 1)

9. **Surface** * (nombre, en m²)

10. **Année de construction** (nombre, optionnel)

**Section 3 : Images**

11. **Images de la propriété** * (upload multiple)
    - Formats acceptés : JPG, PNG, WebP
    - Taille max par image : 5 MB
    - Nombre minimum : 1 image
    - Nombre recommandé : 5-10 images
    - **Ordre :** Glisser-déposer pour réorganiser

**Section 4 : Statut et mise en avant**

12. **Statut** * (radio buttons)
    - ⭕ Disponible (available)
    - ⭕ Vendu (sold)
    - ⭕ Réservé (reserved)

13. **En vedette** (checkbox)
    - ☑️ Cocher pour afficher sur la page d'accueil
    - Maximum 3 biens en vedette recommandé

**Section 5 : Caractéristiques supplémentaires** (optionnel)

14. **Caractéristiques** (textarea)
    - Une par ligne
    - Exemple :
      ```
      Piscine privée
      Garage 2 places
      Jardin paysager
      Système de sécurité
      ```

**Boutons :**
- 💾 **Enregistrer** → Crée la propriété
- 🔙 **Annuler** → Retour à la liste

### ✏️ Modifier une propriété

**Action :** Cliquer sur "Modifier" dans la liste

**Formulaire identique à l'ajout** avec les données pré-remplies.

**Modifications d'images :**
- ❌ Supprimer une image existante
- ➕ Ajouter de nouvelles images
- 🔄 Réorganiser l'ordre par glisser-déposer

**Boutons :**
- 💾 **Mettre à jour** → Sauvegarde les modifications
- 🔙 **Annuler** → Retour sans sauvegarder

### 👁️ Voir les détails

**Action :** Cliquer sur "Voir" dans la liste

**Page de détails administrateur** affichant :
- Toutes les informations de la propriété
- Galerie d'images complète
- Date de création et dernière modification
- Boutons :
  - ✏️ **Modifier**
  - 🗑️ **Supprimer**
  - 🔙 **Retour à la liste**

### 🗑️ Supprimer une propriété

**Action :** Cliquer sur "Supprimer" dans la liste

**⚠️ Confirmation requise :**
- Modal de confirmation s'affiche
- "Êtes-vous sûr de vouloir supprimer cette propriété ?"
- Cette action est **irréversible**
- Les images associées seront également supprimées

**Boutons :**
- 🗑️ **Confirmer la suppression**
- ❌ **Annuler**

### 📤 Import/Export (si disponible)

**Import CSV :**
- Format : CSV avec colonnes définies
- Permet d'importer plusieurs propriétés en une fois

**Export CSV :**
- Exporte toutes les propriétés en fichier CSV
- Utile pour sauvegardes ou analyses externes

---

## 4. Gestion des catégories

**URL :** `https://horizonimmo.test/admin/categories`

### 📋 Liste des catégories

**Tableau avec colonnes :**
- 🏷️ **Nom**
- 📝 **Description**
- 🔢 **Nombre de propriétés**
- ⚙️ **Actions** (Modifier / Supprimer)

### ➕ Ajouter une catégorie

**Formulaire :**
1. **Nom** * (texte, 100 caractères max)
   - Exemple : "Villa de luxe"

2. **Slug** (auto-généré depuis le nom)
   - Exemple : "villa-de-luxe"

3. **Description** (textarea, optionnel)

**Bouton :** "Créer la catégorie"

### ✏️ Modifier une catégorie

Formulaire identique à l'ajout avec données pré-remplies.

### 🗑️ Supprimer une catégorie

**⚠️ Attention :**
- Impossible de supprimer une catégorie ayant des propriétés associées
- Réassignez d'abord les propriétés à une autre catégorie

---

## 5. Messages de contact

**URL :** `https://horizonimmo.test/admin/messages`

### 📧 Liste des messages

**Tableau avec colonnes :**
- 👤 **Nom**
- 📧 **Email**
- 📞 **Téléphone**
- 🏷️ **Sujet**
- 📅 **Date**
- 📖 **Statut** (Nouveau / Lu / Traité)
- ⚙️ **Actions** (Voir / Marquer comme traité / Supprimer)

**Filtres :**
- 📊 Par statut (Nouveau / Lu / Traité)
- 📅 Par date
- 🔍 Recherche par nom ou email

### 👁️ Voir un message

**Détails affichés :**
- Informations du contact (nom, email, téléphone)
- Sujet du message
- Message complet
- Propriété concernée (si applicable)
- Date et heure de réception
- Statut actuel

**Actions possibles :**
- 📧 **Répondre par email** (ouvre le client email)
- ✅ **Marquer comme traité**
- 🗑️ **Supprimer**

### 📊 Statistiques des messages

- Nombre total de messages
- Messages non lus
- Taux de réponse
- Temps de réponse moyen

---

## 6. Demandes d'accompagnement

**URL :** `https://horizonimmo.test/admin/accompaniment-requests`

### 📋 Liste des demandes

**Tableau avec colonnes :**
- 👤 **Nom complet**
- 📧 **Email**
- 📞 **Téléphone**
- 🌍 **Pays**
- 🏙️ **Ville souhaitée**
- 💰 **Budget**
- 📊 **Statut**
- 📅 **Date**
- ⚙️ **Actions**

**Statuts possibles :**
- 🆕 **Nouveau** (non traité)
- 📞 **En cours** (contact établi)
- ✅ **Traité** (accompagnement en cours)
- ❌ **Refusé** (ne correspond pas aux critères)
- 🎉 **Finalisé** (achat conclu)

### 👁️ Voir une demande

**Informations affichées :**

**Section 1 : Informations personnelles**
- Nom et prénom
- Pays de résidence
- Âge
- Profession
- Email
- Téléphone

**Section 2 : Projet immobilier**
- Ville souhaitée
- Type de bien recherché
- Budget estimé (en FCFA)
- Informations complémentaires

**Section 3 : Situation financière**
- Apport personnel (%)
- Revenu mensuel net (FCFA)
- Dettes mensuelles (FCFA)
- Durée de prêt souhaitée
- Mensualité calculée
- Ratio d'endettement

**Section 4 : Métadonnées**
- Date de la demande
- Statut actuel
- Dernière modification
- Notes internes (si ajoutées)

**Actions :**
- ✏️ **Modifier le statut**
- 📝 **Ajouter une note**
- 📧 **Envoyer un email**
- 📞 **Planifier un appel**
- 🗑️ **Supprimer**

### 📊 Tableau de bord des demandes

**Statistiques :**
- Nouvelles demandes (7 derniers jours)
- Demandes en cours
- Taux de conversion
- Budget moyen demandé
- Villes les plus demandées
- Types de biens préférés

---

## 7. Gestion du contenu d'accueil

**URL :** `https://horizonimmo.test/admin/home-content`

**📍 Accès dans le sidebar :** Le lien apparaît sous **"Contenu Site"** dans le menu Administration.

**⚠️ Permission requise :** Vous devez avoir la permission `content.manage` pour voir ce menu. Si le lien n'apparaît pas :
1. Vérifiez vos permissions avec un super-administrateur
2. Le lien est conditionné par `@can('content.manage')` dans le code

### ✏️ Éditer le contenu

**Sections modifiables :**

#### **Hero Section**

1. **Titre principal** (texte)
   - Exemple : "Votre Rêve Immobilier en Afrique du Sud"

2. **Sous-titre** (texte)
   - Exemple : "Découvrez des propriétés d'exception..."

3. **Image de fond** (upload)
   - Format : JPG, PNG, WebP
   - Dimensions recommandées : 1920×1080px

4. **Bouton CTA** (texte + lien)
   - Texte du bouton
   - URL de destination

#### **Section Offre Exclusive**

5. **Vidéo YouTube** (URL)
   - URL complète de la vidéo
   - Exemple : https://youtu.be/X33fSaVSnKQ

6. **Vidéo promotionnelle locale** (upload)
   - Format : MP4, WebM
   - Taille max : 50 MB

7. **Avantages** (4 éléments)
   - Chaque avantage a :
     - Titre
     - Description
     - Icône (optionnel)

#### **Section Services**

8. **Services affichés** (3 éléments)
   - Titre du service
   - Description
   - Icône

#### **Biens en vedette**

9. **Nombre de biens à afficher** (nombre)
   - Recommandé : 3

10. **Sélection automatique** (checkbox)
    - Si coché : affiche les 3 derniers biens "en vedette"
    - Si décoché : sélection manuelle des biens

**Bouton :** "Enregistrer les modifications"

### 🎨 Personnalisation avancée

**Si vous avez accès aux fichiers :**
- Modifier `resources/views/livewire/home-page.blade.php`
- Ajuster les couleurs dans Tailwind CSS
- Modifier les animations

---

## 8. Gestion des utilisateurs

**URL :** `https://horizonimmo.test/admin/users`

### 👥 Liste des utilisateurs

**Tableau avec colonnes :**
- 👤 **Nom**
- 📧 **Email**
- 🎭 **Rôle** (Admin / User)
- ✅ **Email vérifié**
- 📅 **Date d'inscription**
- 🔌 **Dernière connexion**
- ⚙️ **Actions**

### ➕ Ajouter un utilisateur

**Formulaire :**
1. **Nom** *
2. **Email** *
3. **Mot de passe** * (min. 8 caractères)
4. **Confirmer le mot de passe** *
5. **Rôle** * (Admin / User)

**Bouton :** "Créer l'utilisateur"

### ✏️ Modifier un utilisateur

**Actions possibles :**
- Changer le nom
- Changer l'email
- Réinitialiser le mot de passe
- Modifier le rôle
- Activer/Désactiver le compte

### 🔒 Gestion des rôles

**Rôle : Admin**
- Accès complet au panel d'administration
- Gestion des propriétés
- Gestion des utilisateurs
- Modification du contenu

**Rôle : User**
- Accès au site public uniquement
- Sauvegarde de favoris
- Suivi des demandes personnelles
- Pas d'accès au panel admin

### 🗑️ Supprimer un utilisateur

**⚠️ Attention :**
- Suppression définitive
- Les demandes associées sont conservées
- Les favoris sont supprimés

---

## 9. Configuration système

**URL :** `https://horizonimmo.test/admin/settings`

### ⚙️ Paramètres généraux

#### **Informations du site**

1. **Nom du site**
   - Défaut : "ZB Investments"

2. **Description**
   - Pour le SEO

3. **Email de contact**
   - info@zbinvestments-ci.com

4. **Téléphone**
   - +27 (0) 11 123 4567

5. **Adresse**
   - Afrique du Sud

#### **Configuration email**

**Variables d'environnement (.env) :**

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.zbinvestments-ci.com
MAIL_PORT=587
MAIL_USERNAME=info@zbinvestments-ci.com
MAIL_PASSWORD=qH4-G3bJrZKhwkK
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@zbinvestments-ci.com"
MAIL_FROM_NAME="ZB Investments"
```

**Test de l'email :**
- Bouton "Envoyer un email de test"
- Vérifie la configuration SMTP

#### **Configuration de la devise**

6. **Devise d'affichage**
   - ZAR (Rand Sud-Africain)
   - FCFA (Franc CFA) - Conversion ×30

7. **Taux de conversion**
   - 1 ZAR = 30 FCFA (modifiable)

#### **Configuration des fichiers**

8. **Stockage des images**
   - Local (défaut)
   - S3 (si configuré)

9. **Taille max des uploads**
   - Images : 5 MB
   - Vidéos : 50 MB

### 🔧 Paramètres avancés

#### **Base de données**

**Via phpMyAdmin ou ligne de commande :**

```bash
# Backup de la base de données
php artisan backup:run

# Optimiser les tables
php artisan optimize

# Vider les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### **Maintenance**

**Activer le mode maintenance :**

```bash
php artisan down --message="Maintenance en cours"
```

**Désactiver :**

```bash
php artisan up
```

#### **Logs**

**Consulter les logs :**
- Fichier : `storage/logs/laravel.log`
- Via FTP ou SSH

**Nettoyer les logs :**

```bash
# Supprimer les vieux logs
rm storage/logs/laravel-*.log
```

---

## 10. Maintenance et sauvegardes

### 💾 Sauvegardes

#### **Sauvegarde de la base de données**

**Via phpMyAdmin :**
1. Se connecter à phpMyAdmin
2. Sélectionner la base `horizonimmo`
3. Onglet "Exporter"
4. Format : SQL
5. Télécharger le fichier

**Via ligne de commande :**

```bash
# Export de la base
mysqldump -u root -p horizonimmo > backup_$(date +%Y%m%d).sql

# Import d'une sauvegarde
mysql -u root -p horizonimmo < backup_20251012.sql
```

#### **Sauvegarde des fichiers**

**Dossiers à sauvegarder :**
- `public/images/` → Images des propriétés
- `public/videos/` → Vidéos
- `storage/app/` → Fichiers uploadés
- `.env` → Configuration (IMPORTANT)

**Via FTP :**
- Télécharger les dossiers ci-dessus
- Sauvegarder localement ou sur cloud

### 🔄 Restauration

**En cas de problème :**

1. **Restaurer la base de données** (voir ci-dessus)
2. **Restaurer les fichiers** via FTP
3. **Vérifier le fichier `.env`**
4. **Vider les caches** :

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 🧹 Nettoyage régulier

**Tâches de maintenance hebdomadaires :**

```bash
# Nettoyer les caches
php artisan optimize:clear

# Supprimer les sessions expirées
php artisan session:gc

# Supprimer les vieux logs (plus de 30 jours)
find storage/logs -type f -mtime +30 -delete

# Optimiser les images (via outils externes)
# Optimiser la base de données
php artisan optimize
```

### 📊 Monitoring

**Vérifications régulières :**
- ✅ Espace disque disponible
- ✅ Performance du site (temps de chargement)
- ✅ Logs d'erreurs
- ✅ Emails correctement envoyés
- ✅ Sauvegardes à jour
- ✅ Certificat SSL valide

---

## 🚨 Dépannage

### Problèmes courants

#### **1. Erreur 500 - Internal Server Error**

**Causes possibles :**
- Fichier `.env` mal configuré
- Permissions incorrectes
- Erreur PHP dans le code

**Solutions :**
```bash
# Vérifier les logs
tail -n 50 storage/logs/laravel.log

# Vérifier les permissions
chmod -R 775 storage bootstrap/cache

# Vider les caches
php artisan optimize:clear
```

#### **2. Images ne s'affichent pas**

**Solutions :**
```bash
# Créer le lien symbolique
php artisan storage:link

# Vérifier les permissions
chmod -R 775 storage/app/public
```

#### **3. Emails non envoyés**

**Vérifications :**
- Vérifier `.env` : MAIL_HOST, MAIL_USERNAME, MAIL_PASSWORD
- Tester la connexion SMTP
- Vérifier les logs : `storage/logs/laravel.log`

```bash
# Tester l'envoi d'email
php artisan tinker
>>> Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });
```

#### **4. Page blanche**

**Solutions :**
```bash
# Activer le debug temporairement
# Dans .env : APP_DEBUG=true

# Consulter les logs
tail -f storage/logs/laravel.log

# Remettre APP_DEBUG=false après diagnostic
```

#### **5. CRON ne s'exécute pas**

**Vérifications :**
- CRON bien configuré sur le serveur
- Commande correcte : `/usr/base/opt/php8.3/bin/php /home/laravel-app/artisan schedule:run`
- Permissions d'exécution

---

## 📚 Ressources supplémentaires

### 📖 Documentation

- **Laravel** : https://laravel.com/docs
- **Livewire** : https://livewire.laravel.com/docs
- **Tailwind CSS** : https://tailwindcss.com/docs

### 🔧 Commandes utiles

```bash
# Informations système
php artisan about

# Liste des routes
php artisan route:list

# Tinker (console interactive)
php artisan tinker

# Créer un admin
php artisan tinker
>>> $user = new App\Models\User;
>>> $user->name = "Admin";
>>> $user->email = "admin@zbinvestments.com";
>>> $user->password = Hash::make("MotDePasseSecurise");
>>> $user->save();
```

### 📧 Support technique

**Contact développeur :**
- Email : dev@zbinvestments.com
- Documentation : Fichier CLAUDE.md

---

## ✅ Checklist de l'administrateur

### Quotidien
- [ ] Vérifier les nouveaux messages
- [ ] Consulter les nouvelles demandes d'accompagnement
- [ ] Vérifier les logs d'erreurs

### Hebdomadaire
- [ ] Ajouter/mettre à jour des propriétés
- [ ] Répondre à tous les messages en attente
- [ ] Vérifier les statistiques
- [ ] Nettoyer les caches

### Mensuel
- [ ] Sauvegarde complète (BDD + fichiers)
- [ ] Vérifier l'espace disque
- [ ] Optimiser la base de données
- [ ] Mettre à jour les biens vendus
- [ ] Analyser les statistiques de conversion

### Trimestriel
- [ ] Audit de sécurité
- [ ] Mise à jour Laravel et dépendances
- [ ] Révision des contenus
- [ ] Optimisation SEO
- [ ] Test complet de toutes les fonctionnalités

---

## 🎯 Bonnes pratiques

### ✅ À faire

1. **Sauvegarder régulièrement** (BDD + fichiers)
2. **Tester après chaque modification**
3. **Documenter les changements**
4. **Utiliser des mots de passe forts**
5. **Répondre rapidement aux demandes**
6. **Maintenir les données à jour**
7. **Surveiller les performances**

### ❌ À éviter

1. Ne jamais modifier directement en production sans test
2. Ne pas partager les identifiants admin
3. Ne pas laisser APP_DEBUG=true en production
4. Ne pas négliger les sauvegardes
5. Ne pas ignorer les logs d'erreurs
6. Ne pas exposer le fichier `.env`

---

## 🔐 Sécurité

### 🛡️ Recommandations de sécurité

1. **Mots de passe**
   - Min. 12 caractères
   - Majuscules + minuscules + chiffres + symboles
   - Changement tous les 3 mois

2. **Accès**
   - Limiter le nombre d'admins
   - Utiliser des rôles appropriés
   - Surveiller les connexions suspectes

3. **Fichiers**
   - `.env` non accessible publiquement
   - Permissions correctes (755/775)
   - Pas de fichiers sensibles dans public/

4. **Base de données**
   - Mot de passe fort
   - Accès restreint
   - Sauvegardes chiffrées

5. **HTTPS**
   - Certificat SSL actif
   - Redirection HTTP → HTTPS
   - HSTS activé

---

## 🎉 Félicitations !

Vous êtes maintenant prêt à administrer efficacement la plateforme HorizonImmo !

**En cas de questions ou problèmes, consultez :**
- 📖 Ce guide
- 📧 Support technique
- 📚 Documentation Laravel

---

**🔐 ZB Investments - Panel d'Administration**

*Guide créé le : Octobre 2025*
*Version : 1.0*
