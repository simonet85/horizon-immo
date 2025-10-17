# 🚀 Méthodes de Déploiement sur LWS

## 📋 Comparaison des Méthodes

| Méthode | Rapidité | Difficulté | Recommandé pour |
|---------|----------|------------|-----------------|
| **SSH + Git** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | Développeurs expérimentés |
| **FTP** | ⭐⭐⭐ | ⭐ | Petites mises à jour |
| **File Manager** | ⭐⭐ | ⭐ | Débutants, fichiers individuels |

---

## 1. 🔐 Déploiement SSH + Git (Recommandé)

### ✅ Avantages
- ✨ Le plus rapide et le plus professionnel
- 🔄 Déploiement en une seule commande
- 📦 Gestion automatique des dépendances
- 🧹 Nettoyage automatique des caches
- 📝 Historique complet des déploiements
- 🔒 Plus sécurisé

### ❌ Inconvénients
- Nécessite un accès SSH (formule Pro LWS)
- Requiert des connaissances Git/SSH

### 🚀 Procédure Rapide

```bash
# 1. Connexion SSH
ssh zbinv2677815@ssh.horizonimmo.com

# 2. Déploiement
cd /home/zbinv2677815/laravel-app
./deploy.sh

# 3. Terminé !
```

### 📖 Guide Complet
👉 [GUIDE_SSH_GIT_LWS.md](GUIDE_SSH_GIT_LWS.md)

---

## 2. 📁 Déploiement FTP (FileZilla)

### ✅ Avantages
- 🎯 Contrôle précis sur les fichiers uploadés
- 🔓 Pas besoin d'accès SSH
- 👁️ Interface visuelle simple
- 📊 Comparaison facile des fichiers

### ❌ Inconvénients
- ⏱️ Plus lent pour beaucoup de fichiers
- 🧹 Nettoyage manuel des caches nécessaire
- 📝 Pas d'historique automatique

### 🚀 Procédure Rapide

```
1. Connexion FileZilla :
   - Hôte: ftp.horizonimmo.com
   - User: zbinv2677815
   - Port: 21

2. Upload fichiers modifiés :
   - Models → /home/laravel-app/app/Models/
   - Controllers → /home/laravel-app/app/Http/Controllers/
   - Views → /home/laravel-app/resources/views/

3. Vider caches :
   - Upload clear-cache-lws.php → /htdocs/
   - Visiter: https://horizonimmo.com/clear-cache-lws.php
   - Supprimer clear-cache-lws.php
```

### 📖 Guides Complets
- 👉 [GUIDE_MISE_A_JOUR_LWS.md](GUIDE_MISE_A_JOUR_LWS.md) - Guide détaillé
- 👉 [UPDATE_CHECKLIST.md](UPDATE_CHECKLIST.md) - Checklist rapide
- 👉 [FILES_TO_UPLOAD.txt](FILES_TO_UPLOAD.txt) - Liste des fichiers

---

## 3. 🌐 Déploiement File Manager LWS

### ✅ Avantages
- 🚫 Aucun logiciel tiers nécessaire
- 🌍 Accessible depuis n'importe où
- 🎯 Parfait pour 1-2 fichiers

### ❌ Inconvénients
- 🐌 Le plus lent
- 📦 Pas adapté pour beaucoup de fichiers
- 💻 Interface web parfois lente

### 🚀 Procédure Rapide

```
1. Connexion panel LWS → File Manager

2. Naviguer vers le dossier cible

3. Upload fichiers :
   - Clic droit → Upload
   - Sélectionner fichier
   - Confirmer

4. Vider caches manuellement :
   - Supprimer fichiers dans bootstrap/cache/
```

### 📖 Guide
👉 Voir section File Manager dans [CLAUDE.md](CLAUDE.md)

---

## 4. 🤖 Déploiement Automatisé (GitHub Actions)

### ✅ Avantages
- 🚀 Déploiement automatique à chaque push
- 🎯 Zéro manipulation manuelle
- 📝 Logs de déploiement
- ✅ Tests automatiques avant déploiement

### ❌ Inconvénients
- ⚙️ Configuration initiale plus complexe
- 🔐 Nécessite SSH activé

### 🚀 Configuration

**Fichier `.github/workflows/deploy.yml` :**

```yaml
name: Deploy to LWS

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
    - name: Deploy
      uses: appleboy/ssh-action@master
      with:
        host: ${{ secrets.SSH_HOST }}
        username: ${{ secrets.SSH_USERNAME }}
        password: ${{ secrets.SSH_PASSWORD }}
        script: |
          cd /home/zbinv2677815/laravel-app
          ./deploy.sh
```

### 📖 Guide
👉 Voir section GitHub Actions dans [GUIDE_SSH_GIT_LWS.md](GUIDE_SSH_GIT_LWS.md)

---

## 📊 Quelle Méthode Choisir ?

### Scénario 1 : Mise à jour complète du projet
**✅ Recommandation : SSH + Git**
```bash
ssh zbinv2677815@ssh.horizonimmo.com
cd /home/zbinv2677815/laravel-app
./deploy.sh
```

### Scénario 2 : Modification de 1-5 fichiers
**✅ Recommandation : FTP**
- Upload via FileZilla
- Vider caches via clear-cache-lws.php

### Scénario 3 : Modification d'un seul fichier urgent
**✅ Recommandation : File Manager**
- Édition directe dans le File Manager
- Ou upload rapide

### Scénario 4 : Déploiements fréquents
**✅ Recommandation : GitHub Actions**
- Configuration initiale
- Puis déploiement automatique

---

## 🔄 Workflows Recommandés

### Workflow Développement → Production

```
1. Développement Local
   ↓
2. Test Local (php artisan test)
   ↓
3. Commit & Push vers GitHub
   ↓
4. Déploiement sur LWS :

   Option A (SSH) :
   ssh → git pull → deploy.sh

   Option B (FTP) :
   FileZilla → Upload → Clear cache

   Option C (Auto) :
   Push → GitHub Actions → Auto-deploy
   ↓
5. Vérification en production
```

---

## 📝 Checklist Générale de Déploiement

Quelle que soit la méthode :

### Avant Déploiement
- [ ] Tests locaux passent
- [ ] Fichiers .env mis à jour (si nécessaire)
- [ ] Backup de la base de données (si migrations)
- [ ] Mode maintenance activé (grosses mises à jour)

### Pendant Déploiement
- [ ] Upload/Pull des fichiers
- [ ] Migrations exécutées (si nouvelles)
- [ ] Caches vidés
- [ ] Permissions vérifiées

### Après Déploiement
- [ ] Site accessible
- [ ] Fonctionnalités testées
- [ ] Logs vérifiés (pas d'erreurs)
- [ ] Mode maintenance désactivé

---

## 🛠️ Scripts Utiles

### Script 1 : Vider les Caches (SSH)

```bash
#!/bin/bash
cd /home/zbinv2677815/laravel-app
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo "✅ Caches vidés"
```

### Script 2 : Backup Rapide (SSH)

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
cd /home/zbinv2677815
cp -r laravel-app laravel-app-backup-$DATE
echo "✅ Backup créé: laravel-app-backup-$DATE"
```

### Script 3 : Deploy Complet (deploy.sh)

Voir le contenu complet dans [GUIDE_SSH_GIT_LWS.md](GUIDE_SSH_GIT_LWS.md)

---

## 📚 Index des Guides

### Guides de Déploiement
- 🚀 [CLAUDE.md](CLAUDE.md) - Guide de déploiement initial complet
- 🔐 [GUIDE_SSH_GIT_LWS.md](GUIDE_SSH_GIT_LWS.md) - SSH et Git
- 📁 [GUIDE_MISE_A_JOUR_LWS.md](GUIDE_MISE_A_JOUR_LWS.md) - Mise à jour FTP
- ✅ [UPDATE_CHECKLIST.md](UPDATE_CHECKLIST.md) - Checklist rapide
- 📋 [FILES_TO_UPLOAD.txt](FILES_TO_UPLOAD.txt) - Liste des fichiers

### Démarrage Rapide
- 🏁 [QUICK_START_DEPLOY.md](QUICK_START_DEPLOY.md) - Démarrage rapide (si existe)
- 📖 [README.md](README.md) - Documentation générale

---

## 🆘 Support

### Problèmes Courants

**Erreur 500 :**
1. Vérifier permissions (storage/, bootstrap/cache/)
2. Vider les caches
3. Consulter logs: `/home/laravel-app/storage/logs/laravel.log`

**Cache non vidé :**
1. Vider manuellement via File Manager
2. Ou via clear-cache-lws.php
3. Ou via SSH: `php artisan optimize:clear`

**Git pull échoue :**
1. Vérifier connexion SSH
2. Reset hard: `git reset --hard origin/main`
3. Puis: `git pull origin main`

### Ressources LWS
- 📞 Support: Via panel LWS
- 📧 Email: support@lws.fr
- 📚 Docs: https://aide.lws.fr

---

**🎯 Choisissez la méthode qui vous convient le mieux et bon déploiement !**

---

**Dernière mise à jour :** 16 Octobre 2025
