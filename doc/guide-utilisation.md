# 📚 Guide d'Utilisation - HorizonImmo

## 🏠 Bienvenue sur HorizonImmo

HorizonImmo est une plateforme immobilière moderne qui connecte acheteurs, vendeurs et professionnels de l'immobilier. Ce guide vous accompagne dans la découverte et l'utilisation de toutes les fonctionnalités de la plateforme.

---

## 🚀 Premiers Pas

### 📝 Création de Compte

1. **Accès à l'inscription**

    - Cliquez sur "S'inscrire" en haut à droite
    - Ou accédez directement à `/register`

2. **Informations requises**

    - Nom complet
    - Adresse email valide
    - Mot de passe sécurisé (min. 8 caractères)

3. **Vérification email**
    - Consultez votre boîte mail
    - Cliquez sur le lien de vérification
    - Votre compte est activé !

### 🔐 Connexion

1. **Page de connexion** : `/login`
2. **Informations** : Email + Mot de passe
3. **Option** : "Se souvenir de moi" pour rester connecté
4. **Mot de passe oublié** : Lien de récupération disponible

---

## 👥 Types d'Utilisateurs

### 🏘️ Client Particulier

#### **Fonctionnalités disponibles :**

-   Recherche et consultation des propriétés
-   Sauvegarde de favoris
-   Demande d'informations aux agents
-   Gestion du profil personnel

#### **Dashboard Client** (`/client/dashboard`)

-   Vue d'ensemble de l'activité
-   Mes propriétés favorites
-   Mes demandes en cours
-   Historique des interactions

### 🏢 Administrateur/Agent

#### **Fonctionnalités étendues :**

-   Gestion complète des propriétés
-   Administration des utilisateurs
-   Traitement des messages
-   Analytics et rapports

#### **Interface Admin** (`/admin`)

-   Tableau de bord avec KPI
-   Gestion des contenus
-   Modération des avis
-   Configuration système

---

## 🏠 Gestion des Propriétés

### 🔍 Recherche Avancée

#### **Critères de recherche :**

-   **Localisation** : Ville, code postal, quartier
-   **Type** : Appartement, maison, terrain, local commercial
-   **Prix** : Fourchette min/max
-   **Surface** : Superficie habitable
-   **Pièces** : Nombre de chambres/salles de bain
-   **Caractéristiques** : Balcon, parking, jardin, etc.

#### **Filtres avancés :**

-   Transaction : Vente ou location
-   État : Neuf, bon état, à rénover
-   Étage : Rez-de-chaussée, étage élevé
-   Orientation : Nord, Sud, Est, Ouest
-   Commodités : Transport, écoles, commerces

#### **Tri des résultats :**

-   Prix croissant/décroissant
-   Surface croissante/décroissante
-   Date d'ajout (plus récent)
-   Pertinence

### 📱 Fonctionnalités Mobiles

#### **Recherche géolocalisée :**

-   Activation de la géolocalisation
-   Recherche "Autour de moi"
-   Rayon configurable (1-50 km)

#### **Carte interactive :**

-   Visualisation des biens sur carte
-   Clustering automatique
-   Informations au survol
-   Navigation Street View

### ❤️ Gestion des Favoris

#### **Ajouter aux favoris :**

1. Cliquez sur l'icône ❤️ sur une propriété
2. Le bien est sauvegardé automatiquement
3. Accès via "Mes Favoris" dans le menu

#### **Organisation :**

-   Création de listes personnalisées
-   Tags et catégories
-   Notes privées
-   Partage par email

---

## 👤 Gestion du Profil

### 🖼️ Avatar Utilisateur

#### **Upload d'avatar :**

1. Accédez à votre profil (`/profile`)
2. Section "Photo de profil"
3. Cliquez sur "Télécharger un nouvel avatar"
4. Sélectionnez une image (JPG, PNG, GIF - max 2MB)
5. L'aperçu s'affiche automatiquement
6. Cliquez sur "Mettre à jour l'avatar"

#### **Formats supportés :**

-   JPEG (.jpg, .jpeg)
-   PNG (.png)
-   GIF (.gif)
-   Taille maximale : 2MB
-   Dimensions recommandées : 400x400px

#### **Suppression d'avatar :**

-   Bouton "Supprimer l'avatar"
-   Confirmation automatique
-   Retour aux initiales par défaut

### 📧 Informations Personnelles

#### **Modification du profil :**

-   **Nom** : Nom complet affiché publiquement
-   **Email** : Adresse de contact (vérification requise si changée)
-   **Téléphone** : Numéro pour contact direct (optionnel)

#### **Sécurité du compte :**

-   **Changement de mot de passe** : Actuel + nouveau + confirmation
-   **Vérification email** : Obligatoire pour nouveaux emails
-   **Sessions actives** : Gestion des connexions multiples

---

## 💬 Système de Messagerie

### 📨 Contact Propriétaires/Agents

#### **Formulaire de contact :**

1. Sur la page d'une propriété
2. Section "Contacter l'agent"
3. Remplissez le formulaire :
    - Nom et prénom
    - Email et téléphone
    - Message personnalisé
4. Soumission instantanée

#### **Informations transmises :**

-   Coordonnées du demandeur
-   Référence de la propriété
-   Message et demandes spécifiques
-   Horodatage de la demande

### 📬 Suivi des Messages

#### **Tableau de bord messages :**

-   Historique des échanges
-   Statut des demandes
-   Réponses des agents
-   Notifications de nouveaux messages

#### **Types de notifications :**

-   Email immédiat
-   Notification push (PWA)
-   Résumé quotidien/hebdomadaire

---

## 🏢 Interface Administrateur

### 📊 Tableau de Bord Admin

#### **Métriques principales :**

-   Nombre total de propriétés
-   Nouvelles inscriptions du jour/semaine
-   Messages non lus
-   Demandes d'accompagnement en attente

#### **Graphiques et tendances :**

-   Évolution du nombre de biens
-   Répartition par type de propriété
-   Statistiques de consultation
-   Taux de conversion

### 🏠 Gestion des Propriétés

#### **Ajout d'une propriété :**

1. Navigation : `/admin/properties/create`
2. **Informations générales :**

    - Titre accrocheur
    - Description détaillée
    - Prix et devise
    - Catégorie (appartement, maison, etc.)

3. **Localisation :**

    - Ville
    - Adresse complète
    - Code postal

4. **Caractéristiques :**

    - Type de transaction (vente/location)
    - Nombre de chambres
    - Nombre de salles de bain
    - Surface habitable (m²)
    - État du bien

5. **Images :**

    - Upload multiple (max 10 images)
    - Format : JPG, PNG (max 2MB chacune)
    - Réorganisation par glisser-déposer
    - Image principale automatique

6. **Options avancées :**
    - Bien en vedette (boost visibilité)
    - Statut (disponible, réservé, vendu)
    - Date de disponibilité

#### **Modification d'une propriété :**

-   Accès via liste des propriétés
-   Modification de tous les champs
-   Historique des modifications
-   Publication instantanée

#### **Gestion des images :**

-   Ajout/suppression d'images
-   Réorganisation de l'ordre
-   Compression automatique
-   Génération de miniatures

### 👥 Gestion des Utilisateurs

#### **Liste des utilisateurs :**

-   Vue d'ensemble tous utilisateurs
-   Filtres par rôle (client, admin)
-   Recherche par nom/email
-   Tri par date d'inscription

#### **Création d'utilisateur :**

1. Accès : `/admin/users/create`
2. Informations obligatoires :
    - Nom complet
    - Adresse email unique
    - Mot de passe temporaire
    - Rôle (client ou admin)

#### **Modification des rôles :**

-   **Client** : Accès interface publique uniquement
-   **Admin** : Accès interface d'administration
-   Changement instantané
-   Notification automatique à l'utilisateur

### 📧 Gestion des Messages

#### **Inbox centralisé :**

-   Tous les messages clients
-   Tri par date/statut/propriété
-   Marquage lu/non lu
-   Réponse directe intégrée

#### **Traitement des messages :**

1. **Lecture** : Marquage automatique
2. **Réponse** : Éditeur de texte enrichi
3. **Transfert** : Vers un autre agent
4. **Archivage** : Messages traités

#### **Templates de réponse :**

-   Réponses pré-définies
-   Personnalisation avec variables
-   Gain de temps significatif

### 🎯 Demandes d'Accompagnement

#### **Traitement des demandes :**

-   Liste complète des demandes
-   Détails du profil client
-   Critères de recherche
-   Budget et préférences

#### **Statuts de suivi :**

-   **En attente** : Nouvelle demande
-   **En traitement** : Prise en charge
-   **Proposition envoyée** : Biens proposés
-   **Finalisé** : Accompagnement terminé

#### **Actions disponibles :**

-   Changement de statut
-   Assignation à un agent
-   Ajout de notes internes
-   Proposition de biens correspondants

---

## 🔧 Fonctionnalités Avancées

### 🔍 Recherche Sauvegardée

#### **Création d'alertes :**

1. Effectuez une recherche avec critères
2. Cliquez sur "Sauvegarder cette recherche"
3. Nommez votre alerte
4. Configurez la fréquence de notification

#### **Types d'alertes :**

-   **Immédiate** : Notification instantanée
-   **Quotidienne** : Résumé quotidien
-   **Hebdomadaire** : Digest hebdomadaire
-   **Mensuelle** : Rapport mensuel

### 📱 Application Mobile (PWA)

#### **Installation :**

1. Visitez le site sur mobile
2. Menu navigateur : "Ajouter à l'écran d'accueil"
3. L'icône apparaît sur votre bureau
4. Lancement comme une app native

#### **Fonctionnalités offline :**

-   Navigation des propriétés visitées
-   Consultation des favoris
-   Formulaires en mode brouillon
-   Synchronisation à la reconnexion

### 🔔 Système de Notifications

#### **Types de notifications :**

-   **Push Web** : Notifications navigateur
-   **Email** : Messages détaillés
-   **SMS** : Alertes urgentes (option premium)

#### **Configuration personnalisée :**

-   Choix des événements notifiés
-   Fréquence des notifications
-   Canaux préférés
-   Heures de réception

---

## 🛡️ Sécurité et Confidentialité

### 🔒 Protection des Données

#### **Chiffrement :**

-   HTTPS obligatoire sur tout le site
-   Mots de passe hashés (bcrypt)
-   Données sensibles chiffrées
-   Certificats SSL/TLS

#### **Politique de confidentialité :**

-   Transparence sur l'utilisation des données
-   Droit de rectification
-   Droit à l'oubli
-   Exportation des données

### 🔐 Bonnes Pratiques Sécurité

#### **Mots de passe :**

-   Minimum 8 caractères
-   Combinaison lettres/chiffres/symboles
-   Éviter les mots de dictionnaire
-   Changement régulier recommandé

#### **Navigation sécurisée :**

-   Déconnexion systématique (ordinateurs partagés)
-   Vérification des URL (https://horizonimmo.fr)
-   Méfiance liens suspects par email
-   Signalement activités suspectes

---

## 🆘 Support et Assistance

### 📞 Canaux de Support

#### **Support Email :**

-   **Adresse** : support@horizonimmo.fr
-   **Délai** : Réponse sous 24h
-   **Langues** : Français, Anglais

#### **Support Téléphonique :**

-   **Numéro** : +33 1 23 45 67 89
-   **Horaires** : 9h-18h du lundi au vendredi
-   **Urgences** : Service d'astreinte weekend

#### **Chat en Ligne :**

-   **Disponibilité** : 9h-17h en semaine
-   **Réponse** : Immédiate
-   **Support** : Technique et commercial

### 🐛 Signalement de Bugs

#### **Informations à fournir :**

-   Description détaillée du problème
-   Étapes pour reproduire
-   Navigateur et version
-   Captures d'écran si possible
-   Heure d'occurrence

#### **Canaux de signalement :**

-   **Email** : bugs@horizonimmo.fr
-   **Formulaire** : Page contact du site
-   **Chat** : Support en ligne

### 💡 Demandes d'Amélioration

#### **Suggestions d'évolution :**

-   Nouvelles fonctionnalités
-   Améliorations UX/UI
-   Intégrations souhaitées
-   Optimisations de performance

#### **Process de traitement :**

1. **Réception** : Accusé de réception automatique
2. **Analyse** : Évaluation faisabilité/impact
3. **Priorisation** : Intégration roadmap produit
4. **Feedback** : Information sur le suivi

---

## 📊 Analytics et Rapports

### 📈 Statistiques Personnelles

#### **Pour les clients :**

-   Nombre de propriétés consultées
-   Temps passé sur les fiches
-   Évolution des recherches
-   Favoris les plus populaires

#### **Pour les administrateurs :**

-   Performance des propriétés
-   Taux de conversion
-   Sources de trafic
-   Engagement utilisateurs

### 📋 Rapports Automatisés

#### **Fréquences disponibles :**

-   **Quotidien** : Activité du jour
-   **Hebdomadaire** : Résumé de la semaine
-   **Mensuel** : Bilan mensuel détaillé
-   **Trimestriel** : Analyse de tendances

#### **Formats d'export :**

-   PDF pour présentation
-   Excel pour analyse
-   CSV pour traitement données
-   API pour intégrations tierces

---

## 🔄 Mises à Jour et Évolutions

### 📱 Notifications de Version

#### **Nouveautés :**

-   Nouvelles fonctionnalités
-   Améliorations de performance
-   Corrections de bugs
-   Améliorations de sécurité

#### **Canaux d'information :**

-   Notification in-app
-   Email informatif
-   Blog des nouveautés
-   Réseaux sociaux

### 🔮 Roadmap Publique

#### **Prochaines fonctionnalités :**

-   Visite virtuelle 360°
-   IA d'estimation de prix
-   Application mobile native
-   Intégrations bancaires

#### **Participation communauté :**

-   Vote pour les priorités
-   Beta testing des nouveautés
-   Feedback sur les évolutions
-   Suggestions d'améliorations

---

## 📚 Ressources Supplémentaires

### 🎓 Formation et Tutoriels

#### **Vidéos explicatives :**

-   Prise en main de la plateforme
-   Optimisation des recherches
-   Gestion du profil
-   Utilisation interface admin

#### **Guides PDF :**

-   Guide de démarrage rapide
-   Manuel administrateur complet
-   Bonnes pratiques SEO
-   Optimisation des annonces

### 🔗 Liens Utiles

#### **Documentation technique :**

-   [API Documentation](./api.md)
-   [Architecture technique](./architecture-technique.md)
-   [Base de données](./database.md)

#### **Guides spécialisés :**

-   [Guide administrateur](./guide-admin.md)
-   [Installation et configuration](./installation.md)
-   [FAQ](./faq.md)

---

## 📞 Contacts et Informations

### 🏢 Informations Société

**HorizonImmo SAS**  
123 Avenue des Champs-Élysées  
75008 Paris, France

**SIRET** : 123 456 789 00012  
**TVA** : FR12 123456789

### 📱 Contacts

-   **Support** : support@horizonimmo.fr
-   **Commercial** : commercial@horizonimmo.fr
-   **Technique** : technique@horizonimmo.fr
-   **Général** : contact@horizonimmo.fr

### 🌐 Réseaux Sociaux

-   **LinkedIn** : [HorizonImmo](https://linkedin.com/company/horizonimmo)
-   **Twitter** : [@HorizonImmo](https://twitter.com/horizonimmo)
-   **Facebook** : [HorizonImmoFrance](https://facebook.com/horizonimmofrance)
-   **Instagram** : [@horizonimmo.fr](https://instagram.com/horizonimmo.fr)

---

_Guide maintenu par l'équipe HorizonImmo_  
_Dernière mise à jour : Septembre 2025_  
_Version : 1.0_

---

## 📋 Index des Fonctionnalités

### A-E

-   **Avatar utilisateur** → [Gestion du Profil](#-gestion-du-profil)
-   **Alertes de recherche** → [Recherche Sauvegardée](#-recherche-sauvegardée)
-   **API** → [Documentation API](./api.md)
-   **Dashboard admin** → [Interface Administrateur](#-interface-administrateur)
-   **Estimation de prix** → [Roadmap](#-roadmap-publique)

### F-M

-   **Favoris** → [Gestion des Favoris](#%EF%B8%8F-gestion-des-favoris)
-   **Géolocalisation** → [Fonctionnalités Mobiles](#-fonctionnalités-mobiles)
-   **Messages** → [Système de Messagerie](#-système-de-messagerie)
-   **Mobile (PWA)** → [Application Mobile](#-application-mobile-pwa)

### N-R

-   **Notifications** → [Système de Notifications](#-système-de-notifications)
-   **Propriétés** → [Gestion des Propriétés](#-gestion-des-propriétés)
-   **Profil utilisateur** → [Gestion du Profil](#-gestion-du-profil)
-   **Recherche avancée** → [Recherche Avancée](#-recherche-avancée)

### S-Z

-   **Sécurité** → [Sécurité et Confidentialité](#%EF%B8%8F-sécurité-et-confidentialité)
-   **Support** → [Support et Assistance](#-support-et-assistance)
-   **Utilisateurs** → [Types d'Utilisateurs](#-types-dutilisateurs)
-   **Visite virtuelle** → [Roadmap](#-roadmap-publique)
