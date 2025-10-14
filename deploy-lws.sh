#!/bin/bash

# ====================================
# SCRIPT DE DÉPLOIEMENT HORIZONIMMO
# Laragon → GitHub → LWS
# ====================================

echo "======================================"
echo "🚀 DÉPLOIEMENT HORIZONIMMO"
echo "======================================"
echo "Date: $(date '+%Y-%m-%d %H:%M:%S')"
echo ""

# ====================================
# CONFIGURATION
# ====================================
PROJECT_PATH="/home/laravel-app"
PUBLIC_PATH="/htdocs"
LOG_FILE="/home/laravel-app/storage/logs/deployment.log"

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fonctions d'aide
log_info() {
    echo -e "${GREEN}✓${NC} $1"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] INFO: $1" >> $LOG_FILE
}

log_error() {
    echo -e "${RED}✗${NC} $1"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] ERROR: $1" >> $LOG_FILE
}

log_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] WARNING: $1" >> $LOG_FILE
}

# Vérifier que le script est exécuté depuis le bon dossier
if [ ! -f "$PROJECT_PATH/artisan" ]; then
    log_error "Le dossier du projet n'existe pas: $PROJECT_PATH"
    exit 1
fi

cd $PROJECT_PATH

# ====================================
# 1. MODE MAINTENANCE
# ====================================
echo ""
echo "📦 Activation du mode maintenance..."
php artisan down --render="errors::503" --retry=60
log_info "Mode maintenance activé"

# ====================================
# 2. BACKUP BASE DE DONNÉES
# ====================================
echo ""
echo "💾 Backup de la base de données..."
BACKUP_DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/backups"
BACKUP_FILE="$BACKUP_DIR/db_backup_$BACKUP_DATE.sql"

# Créer le dossier de backup s'il n'existe pas
mkdir -p $BACKUP_DIR

# Lire les informations de connexion depuis .env
DB_HOST=$(grep DB_HOST $PROJECT_PATH/.env | cut -d '=' -f2)
DB_PORT=$(grep DB_PORT $PROJECT_PATH/.env | cut -d '=' -f2)
DB_DATABASE=$(grep DB_DATABASE $PROJECT_PATH/.env | cut -d '=' -f2)
DB_USERNAME=$(grep DB_USERNAME $PROJECT_PATH/.env | cut -d '=' -f2)
DB_PASSWORD=$(grep DB_PASSWORD $PROJECT_PATH/.env | cut -d '=' -f2)

# Backup MySQL
mysqldump -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE > $BACKUP_FILE 2>/dev/null

if [ $? -eq 0 ]; then
    log_info "Backup créé: $BACKUP_FILE"
    # Compresser le backup
    gzip $BACKUP_FILE
    log_info "Backup compressé: $BACKUP_FILE.gz"

    # Supprimer les backups de plus de 7 jours
    find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +7 -delete
    log_info "Anciens backups nettoyés (>7 jours)"
else
    log_warning "Échec du backup de la base de données (le déploiement continue)"
fi

# ====================================
# 3. GIT PULL
# ====================================
echo ""
echo "🔄 Récupération des modifications depuis GitHub..."

# Sauvegarder les modifications locales éventuelles
git stash > /dev/null 2>&1

# Pull depuis GitHub
git pull origin main

if [ $? -ne 0 ]; then
    log_error "Erreur lors du git pull. Déploiement annulé."
    php artisan up
    exit 1
fi

log_info "Code mis à jour depuis GitHub"

# ====================================
# 4. DÉPENDANCES COMPOSER
# ====================================
echo ""
echo "📚 Installation des dépendances Composer..."
composer install --optimize-autoloader --no-dev --no-interaction --quiet

if [ $? -eq 0 ]; then
    log_info "Dépendances Composer installées"
else
    log_error "Erreur lors de l'installation Composer"
    php artisan up
    exit 1
fi

# ====================================
# 5. DÉPENDANCES NPM
# ====================================
echo ""
echo "📦 Installation des dépendances npm..."
npm install --production --silent

if [ $? -eq 0 ]; then
    log_info "Dépendances npm installées"
else
    log_warning "Erreur lors de l'installation npm (le déploiement continue)"
fi

# ====================================
# 6. BUILD DES ASSETS
# ====================================
echo ""
echo "🎨 Compilation des assets..."
npm run build

if [ $? -eq 0 ]; then
    log_info "Assets compilés avec succès"
else
    log_error "Erreur lors de la compilation des assets"
    php artisan up
    exit 1
fi

# ====================================
# 7. COPIE DES ASSETS VERS HTDOCS
# ====================================
echo ""
echo "📂 Copie des assets dans htdocs..."

# Supprimer l'ancien dossier build
rm -rf $PUBLIC_PATH/build

# Copier le nouveau dossier build
cp -r $PROJECT_PATH/public/build $PUBLIC_PATH/

if [ $? -eq 0 ]; then
    log_info "Assets copiés dans $PUBLIC_PATH/build"
else
    log_error "Erreur lors de la copie des assets"
fi

# Copier également les autres fichiers publics si modifiés
cp -r $PROJECT_PATH/public/favicon.ico $PUBLIC_PATH/ 2>/dev/null
cp -r $PROJECT_PATH/public/robots.txt $PUBLIC_PATH/ 2>/dev/null

# ====================================
# 8. MIGRATIONS
# ====================================
echo ""
echo "🗄️  Exécution des migrations..."
php artisan migrate --force

if [ $? -eq 0 ]; then
    log_info "Migrations exécutées"
else
    log_error "Erreur lors des migrations"
    php artisan up
    exit 1
fi

# ====================================
# 9. NETTOYAGE DES CACHES
# ====================================
echo ""
echo "🧹 Nettoyage des caches..."

# Vider tous les caches
php artisan optimize:clear > /dev/null 2>&1

# Nettoyer les caches individuellement
php artisan config:clear > /dev/null 2>&1
php artisan cache:clear > /dev/null 2>&1
php artisan route:clear > /dev/null 2>&1
php artisan view:clear > /dev/null 2>&1

log_info "Caches nettoyés"

# ====================================
# 10. OPTIMISATION LARAVEL
# ====================================
echo ""
echo "⚡ Optimisation de Laravel..."

# Reconstruire les caches
php artisan config:cache > /dev/null 2>&1
php artisan route:cache > /dev/null 2>&1
php artisan view:cache > /dev/null 2>&1

log_info "Laravel optimisé"

# ====================================
# 11. LIEN SYMBOLIQUE STORAGE
# ====================================
echo ""
echo "🔗 Mise à jour du lien symbolique storage..."
php artisan storage:link > /dev/null 2>&1
log_info "Lien symbolique storage créé/mis à jour"

# ====================================
# 12. PERMISSIONS
# ====================================
echo ""
echo "🔐 Vérification des permissions..."

# Storage
chmod -R 775 $PROJECT_PATH/storage
chown -R www-data:www-data $PROJECT_PATH/storage 2>/dev/null

# Bootstrap cache
chmod -R 775 $PROJECT_PATH/bootstrap/cache
chown -R www-data:www-data $PROJECT_PATH/bootstrap/cache 2>/dev/null

log_info "Permissions configurées"

# ====================================
# 13. VÉRIFICATION POST-DÉPLOIEMENT
# ====================================
echo ""
echo "🔍 Vérification post-déploiement..."

# Vérifier que les fichiers critiques existent
if [ ! -f "$PROJECT_PATH/.env" ]; then
    log_error "Fichier .env manquant!"
fi

if [ ! -f "$PUBLIC_PATH/index.php" ]; then
    log_error "Fichier index.php manquant dans htdocs!"
fi

if [ ! -d "$PUBLIC_PATH/build" ]; then
    log_warning "Dossier build manquant dans htdocs!"
fi

# Vérifier la connexion à la base de données
php artisan tinker --execute="DB::connection()->getPdo(); echo 'DB OK';" > /dev/null 2>&1
if [ $? -eq 0 ]; then
    log_info "Connexion base de données OK"
else
    log_error "Connexion base de données échouée!"
fi

# ====================================
# 14. DÉSACTIVATION MODE MAINTENANCE
# ====================================
echo ""
echo "✅ Désactivation du mode maintenance..."
php artisan up
log_info "Mode maintenance désactivé"

# ====================================
# 15. RÉSUMÉ
# ====================================
echo ""
echo "======================================"
echo "✅ DÉPLOIEMENT TERMINÉ AVEC SUCCÈS"
echo "======================================"
echo "Date de fin: $(date '+%Y-%m-%d %H:%M:%S')"
echo "Backup: $BACKUP_FILE.gz"
echo "Logs: $LOG_FILE"
echo ""
log_info "=== DÉPLOIEMENT TERMINÉ ==="

# Afficher les 10 dernières lignes du log Laravel
echo "📝 Dernières lignes du log Laravel:"
tail -n 10 $PROJECT_PATH/storage/logs/laravel.log 2>/dev/null || echo "Aucun log disponible"

exit 0
