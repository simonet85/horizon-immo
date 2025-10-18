#!/bin/bash

##############################################
# Script de mise à jour automatique sur LWS
# Projet : HorizonImmo / ZB Investments
# Usage : ./deploy-update.sh
##############################################

echo "🚀 Démarrage de la mise à jour du projet sur LWS..."
echo ""

# Couleurs pour les messages
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Variables
APP_DIR="/home/zbinv2677815/laravel-app"

# Vérifier qu'on est dans le bon dossier
if [ ! -d "$APP_DIR" ]; then
    echo -e "${RED}❌ Erreur : Le dossier $APP_DIR n'existe pas${NC}"
    exit 1
fi

cd $APP_DIR

echo -e "${BLUE}📂 Dossier actuel : $(pwd)${NC}"
echo ""

# Étape 1 : Sauvegarder les fichiers critiques
echo -e "${YELLOW}💾 Sauvegarde du fichier .env...${NC}"
cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
echo -e "${GREEN}✅ Sauvegarde créée${NC}"
echo ""

# Étape 2 : Récupérer les dernières modifications depuis Git
echo -e "${YELLOW}🔄 Récupération des dernières modifications depuis Git...${NC}"
git fetch origin
BEHIND=$(git rev-list HEAD..origin/main --count)

if [ "$BEHIND" -gt 0 ]; then
    echo -e "${BLUE}📥 $BEHIND nouveau(x) commit(s) à récupérer${NC}"
    git pull origin main
    echo -e "${GREEN}✅ Code mis à jour${NC}"
else
    echo -e "${GREEN}✅ Le code est déjà à jour${NC}"
fi
echo ""

# Étape 3 : Mettre à jour les dépendances Composer (si nécessaire)
echo -e "${YELLOW}📦 Vérification des dépendances Composer...${NC}"
if [ -f "composer.lock" ]; then
    composer install --no-dev --optimize-autoloader --no-interaction
    echo -e "${GREEN}✅ Dépendances installées${NC}"
else
    echo -e "${BLUE}ℹ️  Aucune mise à jour de dépendances nécessaire${NC}"
fi
echo ""

# Étape 4 : Vider tous les caches
echo -e "${YELLOW}🧹 Vidage des caches Laravel...${NC}"
php artisan config:clear
echo -e "${GREEN}  ✓ Cache de configuration vidé${NC}"

php artisan cache:clear
echo -e "${GREEN}  ✓ Cache de l'application vidé${NC}"

php artisan view:clear
echo -e "${GREEN}  ✓ Cache des vues vidé${NC}"

php artisan route:clear
echo -e "${GREEN}  ✓ Cache des routes vidé${NC}"

php artisan event:clear 2>/dev/null
echo -e "${GREEN}  ✓ Cache des événements vidé${NC}"

echo -e "${GREEN}✅ Tous les caches vidés${NC}"
echo ""

# Étape 5 : Reconstruire les caches (optimisation)
echo -e "${YELLOW}⚡ Reconstruction des caches pour optimiser les performances...${NC}"
php artisan config:cache
echo -e "${GREEN}  ✓ Configuration mise en cache${NC}"

php artisan route:cache
echo -e "${GREEN}  ✓ Routes mises en cache${NC}"

php artisan view:cache
echo -e "${GREEN}  ✓ Vues mises en cache${NC}"

echo -e "${GREEN}✅ Caches reconstruits${NC}"
echo ""

# Étape 6 : Vérifier les permissions
echo -e "${YELLOW}🔐 Vérification des permissions...${NC}"
chmod -R 775 storage
chmod -R 775 bootstrap/cache
echo -e "${GREEN}✅ Permissions configurées${NC}"
echo ""

# Étape 7 : Afficher les informations de version
echo -e "${BLUE}ℹ️  Informations de version :${NC}"
echo -e "  PHP : $(php -v | head -n 1)"
echo -e "  Laravel : $(php artisan --version)"
echo -e "  Git : $(git log -1 --pretty=format:'%h - %s (%cr)')"
echo ""

# Fin
echo -e "${GREEN}🎉 Mise à jour terminée avec succès !${NC}"
echo ""
echo -e "${BLUE}📋 Prochaines étapes recommandées :${NC}"
echo "  1. Tester le site : https://votre-domaine.com"
echo "  2. Vérifier les logs : tail -f storage/logs/laravel.log"
echo "  3. Tester l'envoi d'emails"
echo ""
echo -e "${YELLOW}⚠️  En cas de problème :${NC}"
echo "  - Consulter les logs : storage/logs/laravel.log"
echo "  - Restaurer le .env : cp .env.backup.* .env"
echo "  - Revider les caches : php artisan optimize:clear"
echo ""
