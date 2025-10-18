# CONTRAT D'ADMINISTRATION DE SITE WEB

## INFORMATIONS GÉNÉRALES

**Nom du site** : HorizonImmo
**Société** : ZB Investments
**URL** : https://horizonimmo.zbinvestments-ci.com
**Type** : Plateforme immobilière Laravel
**Date du contrat** : 18 Octobre 2025
**Durée** : 12 mois (renouvelable)

---

## PARTIE 1 : SERVICES DE WEBMASTER

### 1. ADMINISTRATION TECHNIQUE

#### 1.1 Maintenance Serveur & Hébergement
- [ ] **Surveillance serveur LWS**
  - Monitoring uptime (99.9% garanti)
  - Vérification quotidienne des performances
  - Surveillance espace disque (alerte à 80%)
  - Monitoring bande passante

- [ ] **Gestion base de données**
  - Backup quotidien automatique (MySQL)
  - Optimisation hebdomadaire des tables
  - Monitoring taille de la BDD
  - Archivage mensuel des anciennes données

- [ ] **Certificat SSL**
  - Renouvellement automatique Let's Encrypt
  - Vérification mensuelle validité SSL
  - Redirection HTTPS forcée

- [ ] **Gestion DNS**
  - Configuration et maintenance DNS
  - Sous-domaines (mail, admin, etc.)
  - Vérification propagation DNS

**Fréquence** : Quotidienne (monitoring), Hebdomadaire (optimisation), Mensuelle (vérifications)
**Temps estimé** : 4-6 heures/mois

---

#### 1.2 Mises à Jour & Sécurité

- [ ] **Laravel & Dépendances**
  - Mise à jour Laravel (versions mineures mensuelles)
  - Mise à jour Composer packages (sécurité hebdomadaire)
  - Mise à jour NPM packages (mensuelles)
  - Tests après chaque mise à jour

- [ ] **Sécurité**
  - Scan vulnérabilités hebdomadaire
  - Mise à jour patches sécurité (sous 24h)
  - Surveillance logs erreurs
  - Protection contre injections SQL/XSS
  - Firewall et règles .htaccess

- [ ] **Backups**
  - Backup complet quotidien (fichiers + BDD)
  - Backup hebdomadaire hors site
  - Test restauration mensuel
  - Conservation : 30 jours (quotidien), 3 mois (hebdomadaire)

**Fréquence** : Quotidienne (surveillance), Hebdomadaire (scans), Mensuelle (mises à jour)
**Temps estimé** : 6-8 heures/mois

---

#### 1.3 Performance & Optimisation

- [ ] **Optimisation Laravel**
  - Cache routes/config/views (après déploiement)
  - Optimisation Composer autoloader
  - Queue workers monitoring
  - Session/cache Redis (si disponible)

- [ ] **Optimisation Images**
  - Compression automatique (WebP)
  - Génération conversions Spatie Media
  - Nettoyage images orphelines
  - CDN configuration (optionnel)

- [ ] **Base de données**
  - Indexation optimale
  - Requêtes N+1 (surveillance)
  - Cache queries fréquentes
  - Purge logs anciens

- [ ] **Frontend**
  - Minification CSS/JS (Vite)
  - Lazy loading images
  - Browser caching headers
  - Compression Gzip/Brotli

**Fréquence** : Hebdomadaire (monitoring), Mensuelle (optimisations)
**Temps estimé** : 3-5 heures/mois

---

### 2. GESTION DE CONTENU

#### 2.1 Propriétés Immobilières

- [ ] **Ajout de propriétés**
  - Création nouvelles propriétés (sur demande)
  - Upload et optimisation images (5 images/propriété)
  - Rédaction descriptions (si fourni)
  - Catégorisation et tags

- [ ] **Mise à jour propriétés**
  - Modification prix/statut
  - Ajout/suppression images
  - Mise à jour caractéristiques
  - Gestion propriétés vendues/réservées

- [ ] **Gestion images**
  - Optimisation automatique WebP
  - 3 conversions : thumb (300x200), preview (800x600), optimized (1920x1080)
  - Watermarking (optionnel)
  - Nettoyage images inutilisées

**Fréquence** : À la demande (propriétés), Hebdomadaire (nettoyage)
**Temps estimé** : Variable selon volume (2-10 heures/mois)

---

#### 2.2 Catégories & Localisation

- [ ] **Gestion catégories**
  - Création/modification catégories
  - Upload icônes catégories
  - Organisation hiérarchique

- [ ] **Gestion villes**
  - Ajout nouvelles villes
  - Activation/désactivation villes
  - Mise à jour liste déroulante

**Fréquence** : À la demande
**Temps estimé** : 1-2 heures/mois

---

### 3. COMMUNICATION & SUPPORT

#### 3.1 Gestion Messages

- [ ] **Messages contact**
  - Surveillance quotidienne inbox
  - Réponse sous 24h (jours ouvrés)
  - Archivage messages traités
  - Statistiques mensuelles

- [ ] **Messages propriétés**
  - Notification propriétaire
  - Suivi leads immobiliers
  - Rapport mensuel conversions

- [ ] **Demandes accompagnement**
  - Traitement demandes achat/vente
  - Transmission équipe commerciale
  - Suivi statut demandes

**Fréquence** : Quotidienne
**Temps estimé** : 2-4 heures/mois

---

#### 3.2 Emails & Notifications

- [ ] **Configuration emails**
  - Gestion templates emails
  - Tests envoi emails
  - Surveillance spam score
  - Configuration SMTP/DKIM/SPF

- [ ] **Notifications système**
  - Emails admin (nouveaux messages)
  - Emails utilisateurs (confirmations)
  - Notifications internes (erreurs)

**Fréquence** : Hebdomadaire (tests), À la demande (modifications)
**Temps estimé** : 2-3 heures/mois

---

### 4. DÉVELOPPEMENT & AMÉLIORATIONS

#### 4.1 Corrections de Bugs

- [ ] **Résolution bugs**
  - Bugs critiques : sous 4 heures
  - Bugs majeurs : sous 24 heures
  - Bugs mineurs : sous 1 semaine
  - Documentation corrections

- [ ] **Tests après corrections**
  - Tests unitaires (si applicable)
  - Tests fonctionnels
  - Tests navigateurs
  - Validation client

**Fréquence** : À la demande
**Temps estimé** : 3-8 heures/mois (selon bugs)

---

#### 4.2 Nouvelles Fonctionnalités

- [ ] **Petites fonctionnalités** (jusqu'à 4h)
  - Nouveaux champs formulaires
  - Filtres de recherche
  - Modifications UI mineures
  - Ajout traductions

- [ ] **Fonctionnalités moyennes** (4-16h)
  - Nouveaux modules
  - Intégrations tierces simples
  - Rapports/statistiques
  - Améliorations UX

- [ ] **Grandes fonctionnalités** (16h+)
  - Refonte sections
  - API externes
  - Systèmes complexes
  - Migrations majeures

**Fréquence** : Selon roadmap
**Temps estimé** : À définir par projet

---

### 5. RAPPORTS & DOCUMENTATION

#### 5.1 Rapports Mensuels

- [ ] **Rapport d'activité**
  - Tâches effectuées
  - Temps passé par catégorie
  - Bugs résolus
  - Mises à jour effectuées

- [ ] **Rapport performance**
  - Temps chargement pages
  - Uptime serveur
  - Trafic mensuel
  - Erreurs 404/500

- [ ] **Rapport contenu**
  - Nouvelles propriétés
  - Messages reçus
  - Leads générés
  - Statistiques conversions

**Fréquence** : Mensuelle (1er du mois)
**Temps estimé** : 2-3 heures/mois

---

#### 5.2 Documentation

- [ ] **Documentation technique**
  - Mise à jour README
  - Documentation déploiement
  - Guides administrateur
  - Procédures maintenance

- [ ] **Documentation utilisateur**
  - Guides ajout propriétés
  - FAQ administration
  - Tutoriels vidéo (optionnel)

**Fréquence** : Après chaque modification majeure
**Temps estimé** : 2-4 heures/mois

---

## PARTIE 2 : PLANNING & DISPONIBILITÉ

### Horaires de Travail

- **Lundi - Vendredi** : 9h00 - 18h00 (heure locale)
- **Support d'urgence** : 24/7 pour bugs critiques
- **Réponse emails** : Sous 24h (jours ouvrés)
- **Maintenance programmée** : Dimanche 2h00-6h00

### Temps Alloué Mensuel

| Catégorie | Heures/mois | Priorité |
|-----------|-------------|----------|
| Maintenance serveur | 4-6h | Haute |
| Sécurité & mises à jour | 6-8h | Haute |
| Performance | 3-5h | Moyenne |
| Gestion contenu | 2-10h | Variable |
| Support messages | 2-4h | Haute |
| Développement | Variable | Selon roadmap |
| Rapports | 2-3h | Moyenne |
| **TOTAL MENSUEL** | **20-40h** | - |

---

## PARTIE 3 : OUTILS & ACCÈS

### Accès Requis

- [x] **Hébergement LWS**
  - Panel LWS : ✅ Accès fourni
  - FTP/SFTP : ✅ Configuré
  - phpMyAdmin : ✅ Accès BDD
  - SSH : ⏳ À configurer

- [x] **Domaine & DNS**
  - Panel domaine : ✅ Accès fourni
  - DNS management : ✅ Configuré

- [x] **Application**
  - Admin Laravel : ✅ Super-admin créé
  - GitHub : ✅ Repository access
  - Logs : ✅ Accès storage/logs

- [ ] **Emails**
  - Compte admin@ : ⏳ À configurer
  - Accès webmail : ⏳ À fournir

### Outils Utilisés

**Monitoring & Analytics**
- Uptime monitoring : UptimeRobot / Pingdom
- Analytics : Google Analytics 4
- Error tracking : Laravel Log Viewer
- Performance : Laravel Telescope (dev)

**Développement**
- IDE : VS Code / PhpStorm
- Version control : Git / GitHub
- Local environment : Laravel Sail / Laragon
- Testing : PHPUnit / Laravel Dusk

**Communication**
- Email : Gmail / Outlook
- Project management : Trello / Notion (optionnel)
- Documentation : Markdown / Confluence

---

## PARTIE 4 : PROCÉDURES D'URGENCE

### Niveaux d'Urgence

#### 🔴 CRITIQUE (Résolution sous 2-4h)
- Site complètement inaccessible
- Erreur 500 sur toutes les pages
- Faille de sécurité active
- Perte de données
- Attaque en cours

**Action** : Contact immédiat par téléphone + email

---

#### 🟠 URGENT (Résolution sous 24h)
- Fonctionnalité majeure cassée
- Erreurs intermittentes
- Performance très dégradée
- Formulaires non fonctionnels
- Emails non envoyés

**Action** : Email avec tag [URGENT]

---

#### 🟡 IMPORTANT (Résolution sous 1 semaine)
- Bug affichage
- Lien cassé
- Image manquante
- Texte incorrect
- Performance moyenne dégradée

**Action** : Email standard ou ticket

---

#### 🟢 NORMAL (Résolution selon planning)
- Amélioration UI
- Nouvelle fonctionnalité
- Optimisation
- Documentation
- Formation

**Action** : Planning mensuel

---

### Procédure de Contact

1. **Email principal** : webmaster@zbinvestments-ci.com
2. **Email backup** : support@zbinvestments-ci.com
3. **Téléphone urgence** : +225 07 07 69 69 14
4. **WhatsApp** : +225 05 45 01 01 99

**Temps de réponse garanti** :
- Critique : 2 heures
- Urgent : 4 heures
- Important : 24 heures
- Normal : 48 heures

---

## PARTIE 5 : TARIFICATION & FACTURATION

### Formule Forfaitaire Mensuelle

**Forfait Standard** : 20 heures/mois
- Prix : À définir
- Inclus : Maintenance, support, mises à jour
- Rapports mensuels
- Support email illimité
- 2 demandes développement/mois (max 4h chacune)

**Forfait Premium** : 40 heures/mois
- Prix : À définir
- Tout le forfait Standard +
- Support prioritaire
- Développement illimité (dans limite heures)
- Consultation stratégique mensuelle
- Formation équipe

### Heures Supplémentaires

- **Heures normales** : Tarif horaire à définir
- **Heures urgentes** : Tarif horaire × 1.5
- **Week-end/nuit** : Tarif horaire × 2
- **Jours fériés** : Tarif horaire × 2.5

### Projets Spéciaux

Devis séparé pour :
- Refonte complète
- Migration serveur
- Intégrations complexes
- Développements > 40h
- Formation approfondie

### Facturation

- **Fréquence** : Mensuelle (1er du mois)
- **Paiement** : Sous 15 jours
- **Méthode** : Virement bancaire / Mobile Money
- **Devise** : FCFA / EUR (selon accord)

---

## PARTIE 6 : CONDITIONS GÉNÉRALES

### Propriété Intellectuelle

- Code développé : Propriété du client (ZB Investments)
- Code open-source : Licences respectives
- Documentation : Propriété du client
- Outils tiers : Licences maintenues

### Confidentialité

- Données clients : Stricte confidentialité
- Accès système : Usage professionnel uniquement
- Partage tiers : Interdit sans accord écrit
- RGPD : Conformité assurée

### Responsabilités

**Webmaster s'engage à :**
- Maintenance professionnelle
- Respect délais convenus
- Confidentialité totale
- Veille technologique
- Documentation claire

**Client s'engage à :**
- Paiement dans les délais
- Fourniture accès nécessaires
- Validation modifications importantes
- Communication claire besoins
- Respect procédures

### Résiliation

- **Préavis** : 30 jours minimum
- **Transfert** : Documentation complète fournie
- **Accès** : Maintenus jusqu'à fin préavis
- **Facturation** : Au prorata temporis
- **Données** : Archivage/transfert assuré

---

## PARTIE 7 : CHECKLIST MENSUELLE

### Semaine 1 (1-7 du mois)

- [ ] Rapport mensuel précédent envoyé
- [ ] Backup complet vérifié
- [ ] Scan sécurité effectué
- [ ] Certificat SSL vérifié
- [ ] Performance monitoring review
- [ ] Mises à jour sécurité appliquées
- [ ] Messages en attente traités

### Semaine 2 (8-14)

- [ ] Optimisation base de données
- [ ] Nettoyage images orphelines
- [ ] Test restauration backup
- [ ] Mise à jour dépendances Composer
- [ ] Revue logs erreurs
- [ ] Documentation mise à jour
- [ ] Développements programmés

### Semaine 3 (15-21)

- [ ] Performance audit
- [ ] SEO check
- [ ] Tests fonctionnels
- [ ] Mise à jour NPM packages
- [ ] Cache optimization
- [ ] Email deliverability test
- [ ] Support tickets review

### Semaine 4 (22-fin)

- [ ] Préparation rapport mensuel
- [ ] Planning mois suivant
- [ ] Statistiques compilées
- [ ] Vérification uptime
- [ ] Backup hors site
- [ ] Veille technologique
- [ ] Meeting client (optionnel)

---

## PARTIE 8 : ROADMAP & ÉVOLUTIONS

### Q1 2026 (Janvier - Mars)

**Priorité Haute**
- [ ] Migration vers Laravel 11
- [ ] Optimisation mobile (PWA)
- [ ] Système de favoris utilisateurs
- [ ] Chat en direct (Tawk.to / LiveChat)
- [ ] Amélioration SEO

**Priorité Moyenne**
- [ ] Blog immobilier
- [ ] Calculateur prêt immobilier
- [ ] Comparateur propriétés
- [ ] Newsletter système
- [ ] Espace client avancé

### Q2 2026 (Avril - Juin)

**Priorité Haute**
- [ ] API mobile (iOS/Android)
- [ ] Système de rendez-vous
- [ ] Visite virtuelle 360°
- [ ] Multilingue (FR/EN)
- [ ] Paiement en ligne

**Priorité Moyenne**
- [ ] CRM intégré
- [ ] Statistiques avancées
- [ ] Export PDF propriétés
- [ ] Géolocalisation carte
- [ ] Alertes email automatiques

### Q3-Q4 2026 (Long terme)

- [ ] Application mobile native
- [ ] IA recommandations propriétés
- [ ] Chatbot intelligent
- [ ] Blockchain certification
- [ ] Marketplace agences

---

## SIGNATURES

**Pour ZB Investments**

Nom : _______________________________
Fonction : ___________________________
Date : _______________________________
Signature : __________________________


**Pour le Webmaster**

Nom : _______________________________
Fonction : Administrateur Web
Date : 18 Octobre 2025
Signature : __________________________

---

**Annexes** :
- A : Accès et identifiants (document séparé sécurisé)
- B : Procédures détaillées (documentation technique)
- C : Grille tarifaire complète
- D : SLA (Service Level Agreement) détaillé

---

*Document généré le 18 octobre 2025*
*Version 1.0 - HorizonImmo / ZB Investments*
*Confidentiel - Ne pas diffuser*
