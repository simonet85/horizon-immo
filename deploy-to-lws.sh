#!/bin/bash

# ============================================
# SCRIPT DE DÉPLOIEMENT HORIZONIMMO SUR LWS
# ============================================
# Version : 1.0
# Date : 18 Octobre 2025
# Usage : ./deploy-to-lws.sh

set -e  # Arrêt en cas d'erreur

# Couleurs pour l'affichage
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
PROJECT_NAME="HorizonImmo"
VERSION_NEW="1.6.0"
VERSION_OLD="1.5.0"

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  DÉPLOIEMENT $PROJECT_NAME sur LWS${NC}"
echo -e "${BLUE}  Version: $VERSION_OLD → $VERSION_NEW${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# ============================================
# ÉTAPE 1 : VÉRIFICATIONS PRÉALABLES
# ============================================
echo -e "${YELLOW}[1/9] Vérifications préalables...${NC}"

# Vérifier qu'on est dans le bon dossier
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Erreur: Ce script doit être exécuté depuis la racine du projet Laravel${NC}"
    exit 1
fi

# Vérifier Git
if ! command -v git &> /dev/null; then
    echo -e "${RED}❌ Git n'est pas installé${NC}"
    exit 1
fi

# Vérifier que tout est commité
if [[ -n $(git status -s) ]]; then
    echo -e "${RED}❌ Il y a des modifications non commitées${NC}"
    git status -s
    exit 1
fi

echo -e "${GREEN}✅ Vérifications OK${NC}"
echo ""

# ============================================
# ÉTAPE 2 : BACKUP LOCAL
# ============================================
echo -e "${YELLOW}[2/9] Création backup local...${NC}"

BACKUP_DIR="../backups/horizonimmo_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"

# Copier .env
cp .env "$BACKUP_DIR/.env.local"

# Créer archive du projet
tar -czf "$BACKUP_DIR/project_backup.tar.gz" \
    --exclude='node_modules' \
    --exclude='.git' \
    --exclude='storage/logs/*.log' \
    --exclude='vendor' \
    .

echo -e "${GREEN}✅ Backup créé: $BACKUP_DIR${NC}"
echo ""

# ============================================
# ÉTAPE 3 : INSTALLATION DÉPENDANCES
# ============================================
echo -e "${YELLOW}[3/9] Installation dépendances production...${NC}"

# Composer
composer install --optimize-autoloader --no-dev --prefer-dist

# NPM
npm ci --production=false

echo -e "${GREEN}✅ Dépendances installées${NC}"
echo ""

# ============================================
# ÉTAPE 4 : BUILD ASSETS
# ============================================
echo -e "${YELLOW}[4/9] Compilation assets frontend...${NC}"

npm run build

if [ ! -d "public/build" ]; then
    echo -e "${RED}❌ Le build a échoué${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Assets compilés${NC}"
echo ""

# ============================================
# ÉTAPE 5 : PRÉPARATION PACKAGE DÉPLOIEMENT
# ============================================
echo -e "${YELLOW}[5/9] Préparation package déploiement...${NC}"

DEPLOY_DIR="deploy_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$DEPLOY_DIR"

# Copier les fichiers nécessaires
echo "Copie des fichiers..."

# Application
cp -r app "$DEPLOY_DIR/"
cp -r config "$DEPLOY_DIR/"
cp -r database "$DEPLOY_DIR/"
cp -r resources "$DEPLOY_DIR/"
cp -r routes "$DEPLOY_DIR/"
cp -r vendor "$DEPLOY_DIR/"

# Public (sauf storage qui est un lien)
mkdir -p "$DEPLOY_DIR/public"
cp -r public/build "$DEPLOY_DIR/public/"
cp public/.htaccess "$DEPLOY_DIR/public/"
cp public/index.php "$DEPLOY_DIR/public/"
cp public/favicon.ico "$DEPLOY_DIR/public/" 2>/dev/null || true
cp public/robots.txt "$DEPLOY_DIR/public/" 2>/dev/null || true

# Storage structure (vide, les données sont sur le serveur)
mkdir -p "$DEPLOY_DIR/storage/app/public"
mkdir -p "$DEPLOY_DIR/storage/framework/cache"
mkdir -p "$DEPLOY_DIR/storage/framework/sessions"
mkdir -p "$DEPLOY_DIR/storage/framework/views"
mkdir -p "$DEPLOY_DIR/storage/logs"
mkdir -p "$DEPLOY_DIR/bootstrap/cache"

# Root files
cp composer.json "$DEPLOY_DIR/"
cp composer.lock "$DEPLOY_DIR/"
cp package.json "$DEPLOY_DIR/"
cp package-lock.json "$DEPLOY_DIR/"
cp artisan "$DEPLOY_DIR/"

# .env template (à configurer manuellement sur le serveur)
cp .env.example "$DEPLOY_DIR/.env.production.template"

# Documentation
cp DEPLOIEMENT_MISE_A_JOUR_LWS.md "$DEPLOY_DIR/"

echo -e "${GREEN}✅ Package préparé: $DEPLOY_DIR${NC}"
echo ""

# ============================================
# ÉTAPE 6 : CRÉATION ARCHIVE
# ============================================
echo -e "${YELLOW}[6/9] Création archive de déploiement...${NC}"

ARCHIVE_NAME="horizonimmo_v${VERSION_NEW}_$(date +%Y%m%d_%H%M%S).tar.gz"
tar -czf "$ARCHIVE_NAME" -C "$DEPLOY_DIR" .

ARCHIVE_SIZE=$(du -h "$ARCHIVE_NAME" | cut -f1)
echo -e "${GREEN}✅ Archive créée: $ARCHIVE_NAME ($ARCHIVE_SIZE)${NC}"
echo ""

# ============================================
# ÉTAPE 7 : CRÉATION ZIP (Alternative)
# ============================================
echo -e "${YELLOW}[7/9] Création archive ZIP...${NC}"

ZIP_NAME="horizonimmo_v${VERSION_NEW}_$(date +%Y%m%d_%H%M%S).zip"

if command -v zip &> /dev/null; then
    (cd "$DEPLOY_DIR" && zip -r "../$ZIP_NAME" . -q)
    ZIP_SIZE=$(du -h "$ZIP_NAME" | cut -f1)
    echo -e "${GREEN}✅ ZIP créé: $ZIP_NAME ($ZIP_SIZE)${NC}"
else
    echo -e "${YELLOW}⚠️  zip non disponible, archive ZIP non créée${NC}"
fi
echo ""

# ============================================
# ÉTAPE 8 : INSTRUCTIONS UPLOAD
# ============================================
echo -e "${YELLOW}[8/9] Génération instructions upload...${NC}"

cat > "INSTRUCTIONS_UPLOAD.txt" << EOF
================================================================================
INSTRUCTIONS D'UPLOAD SUR LWS - $PROJECT_NAME v$VERSION_NEW
================================================================================
Date: $(date +"%d/%m/%Y %H:%M")

FICHIERS GÉNÉRÉS:
- Archive TAR.GZ: $ARCHIVE_NAME
- Archive ZIP: $ZIP_NAME (si disponible)
- Backup local: $BACKUP_DIR

--------------------------------------------------------------------------------
MÉTHODE 1 : UPLOAD MANUEL VIA FTP (RECOMMANDÉ)
--------------------------------------------------------------------------------

1. CONNEXION FTP
   - Serveur: ftp.horizonimmo.zbinvestments-ci.com
   - Utilisateur: [VOTRE LOGIN LWS]
   - Mot de passe: [VOTRE MOT DE PASSE]
   - Port: 21 (FTP) ou 22 (SFTP)

2. UPLOAD FICHIERS
   a) Extraire l'archive localement
   b) Uploader le contenu (sauf public/) vers: /home/laravel-app/
   c) Uploader le contenu de public/ vers: /htdocs/

3. APRÈS UPLOAD
   - Configurer .env (voir DEPLOIEMENT_MISE_A_JOUR_LWS.md)
   - Vérifier permissions storage/ et bootstrap/cache/ (775)
   - Vider les caches Laravel

--------------------------------------------------------------------------------
MÉTHODE 2 : UPLOAD VIA SSH (SI DISPONIBLE)
--------------------------------------------------------------------------------

1. UPLOAD ARCHIVE
   scp $ARCHIVE_NAME user@serveur:/home/laravel-app/

2. EXTRACTION SUR SERVEUR
   ssh user@serveur
   cd /home/laravel-app
   tar -xzf $ARCHIVE_NAME
   rm $ARCHIVE_NAME

3. POST-INSTALLATION
   composer install --optimize-autoloader --no-dev
   php artisan migrate --force
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan media-library:regenerate

--------------------------------------------------------------------------------
COMMANDES POST-DÉPLOIEMENT (SSH)
--------------------------------------------------------------------------------

cd /home/laravel-app

# Permissions
chmod -R 775 storage bootstrap/cache

# Migrations
php artisan migrate --force

# Conversions images
php artisan media-library:regenerate --force

# Optimisation
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Lien symbolique storage
php artisan storage:link

# Tester queue
php artisan queue:work --once

--------------------------------------------------------------------------------
VÉRIFICATIONS APRÈS DÉPLOIEMENT
--------------------------------------------------------------------------------

✅ Page d'accueil accessible
✅ Images s'affichent (liste + détails)
✅ Upload images fonctionne
✅ Emails envoyés correctement
✅ Aucune erreur dans logs
✅ Performance OK (< 3s)

--------------------------------------------------------------------------------
EN CAS DE PROBLÈME
--------------------------------------------------------------------------------

Consulter: DEPLOIEMENT_MISE_A_JOUR_LWS.md
Section: "ÉTAPE 8 : RÉSOLUTION PROBLÈMES COURANTS"

Rollback:
1. Restaurer backup BDD: $BACKUP_DIR
2. Restaurer fichiers via FTP
3. Vider caches

Support:
- Email: webmaster@zbinvestments-ci.com
- Téléphone: +225 07 07 69 69 14

================================================================================
EOF

echo -e "${GREEN}✅ Instructions créées: INSTRUCTIONS_UPLOAD.txt${NC}"
echo ""

# ============================================
# ÉTAPE 9 : RÉSUMÉ
# ============================================
echo -e "${YELLOW}[9/9] Résumé du déploiement${NC}"
echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${GREEN}✅ DÉPLOIEMENT PRÉPARÉ AVEC SUCCÈS${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""
echo -e "📦 ${GREEN}Archives créées:${NC}"
echo -e "   - $ARCHIVE_NAME"
[ -f "$ZIP_NAME" ] && echo -e "   - $ZIP_NAME"
echo ""
echo -e "💾 ${GREEN}Backup local:${NC}"
echo -e "   - $BACKUP_DIR"
echo ""
echo -e "📄 ${GREEN}Instructions:${NC}"
echo -e "   - INSTRUCTIONS_UPLOAD.txt"
echo -e "   - DEPLOIEMENT_MISE_A_JOUR_LWS.md"
echo ""
echo -e "📋 ${YELLOW}PROCHAINES ÉTAPES:${NC}"
echo -e "   1. Lire: ${BLUE}INSTRUCTIONS_UPLOAD.txt${NC}"
echo -e "   2. Créer backup production (BDD + fichiers)"
echo -e "   3. Uploader l'archive sur LWS"
echo -e "   4. Configurer .env production"
echo -e "   5. Exécuter commandes post-déploiement"
echo -e "   6. Tester le site"
echo ""
echo -e "${BLUE}========================================${NC}"
echo ""

# Nettoyage optionnel
read -p "Supprimer le dossier temporaire $DEPLOY_DIR ? (y/N) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    rm -rf "$DEPLOY_DIR"
    echo -e "${GREEN}✅ Dossier temporaire supprimé${NC}"
fi

echo ""
echo -e "${GREEN}Déploiement préparé avec succès ! 🚀${NC}"
echo ""
