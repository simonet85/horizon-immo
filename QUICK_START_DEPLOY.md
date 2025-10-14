# ⚡ DÉMARRAGE RAPIDE - DÉPLOIEMENT GIT HORIZONIMMO

## 🎯 Configuration initiale (à faire une seule fois)

### 1️⃣ Sur GitHub

1. **Créer un Personal Access Token** :
   - Va sur [github.com/settings/tokens](https://github.com/settings/tokens)
   - Clique sur **"Generate new token (classic)"**
   - Nom: `HorizonImmo-Deploy`
   - Permissions: cocher `repo`
   - Copie le token : `ghp_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`

2. **Configurer les secrets GitHub Actions** (optionnel pour auto-déploiement) :
   - Va sur [github.com/simonet85/horizon-immo/settings/secrets/actions](https://github.com/simonet85/horizon-immo/settings/secrets/actions)
   - Ajoute 3 secrets :
     - `LWS_SSH_HOST` : `ssh.cluster0XX.lws.fr`
     - `LWS_SSH_USER` : `zbinv2677815`
     - `LWS_SSH_PASSWORD` : ton mot de passe SSH

### 2️⃣ Sur Laragon (Windows)

```bash
# Ouvre le terminal Laragon
cd C:\laragon\www\HorizonImmo

# Configure Git Credential Manager (une seule fois)
git config --global credential.helper wincred

# Vérifie la connexion GitHub
git remote -v
```

### 3️⃣ Sur LWS (via SSH)

```bash
# Connecte-toi en SSH
ssh zbinv2677815@ssh.cluster0XX.lws.fr

# Va dans le dossier home
cd /home

# Clone le projet (si pas déjà fait)
git clone https://github.com/simonet85/horizon-immo.git laravel-app

# Entre ton username GitHub et ton Personal Access Token comme password

# Configure Git sur LWS
cd /home/laravel-app
git config credential.helper store
git config user.name "Ton Nom"
git config user.email "ton-email@example.com"

# Rend le script de déploiement exécutable
chmod +x deploy-lws.sh

# Crée le dossier de backup
mkdir -p /home/backups

# Configure le .env de production (voir CLAUDE.md)
nano .env

# Premier déploiement
./deploy-lws.sh
```

---

## 🚀 Workflow quotidien (3 étapes simples)

### Étape 1 : Développer localement sur Laragon

```bash
# Terminal Laragon
cd C:\laragon\www\HorizonImmo

# Vérifie sur quelle branche tu es
git status

# Code ton projet...
# Teste localement : http://horizonimmo.test

# Compile les assets pour production
npm run build
```

### Étape 2 : Commit et push sur GitHub

```bash
# Vérifie les fichiers modifiés
git status

# Ajoute tous les fichiers modifiés
git add .

# Ou ajoute des fichiers spécifiques
git add app/Http/Controllers/HomeController.php
git add resources/views/home.blade.php

# Crée un commit avec un message clair
git commit -m "Add: nouvelle fonctionnalité pour la page d'accueil"

# Push vers GitHub
git push origin main

# La première fois, entre ton username GitHub et ton Personal Access Token
```

### Étape 3 : Déployer sur LWS

#### Option A : Déploiement manuel (recommandé)

```bash
# Connecte-toi en SSH
ssh zbinv2677815@ssh.cluster0XX.lws.fr

# Exécute le script de déploiement
/home/laravel-app/deploy-lws.sh

# Déconnexion
exit
```

#### Option B : Déploiement automatique (GitHub Actions)

Si tu as configuré les secrets GitHub :

1. Push sur `main` déclenche automatiquement le déploiement
2. Ou va sur GitHub → **Actions** → **Deploy to LWS** → **Run workflow**

---

## 📋 Commandes essentielles

### Sur Laragon (développement)

| Commande | Description |
|----------|-------------|
| `git status` | Voir les fichiers modifiés |
| `git add .` | Ajouter tous les fichiers |
| `git commit -m "message"` | Créer un commit |
| `git push origin main` | Push vers GitHub |
| `npm run dev` | Mode développement (hot reload) |
| `npm run build` | Build pour production |
| `php artisan serve` | Lancer le serveur local |

### Sur LWS (production)

| Commande | Description |
|----------|-------------|
| `ssh user@host` | Se connecter |
| `/home/laravel-app/deploy-lws.sh` | Déployer |
| `tail -f /home/laravel-app/storage/logs/laravel.log` | Voir les logs |
| `php artisan down` | Mode maintenance |
| `php artisan up` | Quitter maintenance |

---

## ✅ Checklist avant chaque déploiement

- [ ] Code testé localement
- [ ] `npm run build` exécuté
- [ ] Pas d'erreurs dans les logs Laravel
- [ ] Commit créé avec message clair
- [ ] Push vers GitHub effectué

---

## 🆘 Problèmes courants

### Erreur 500 après déploiement

```bash
# SSH sur LWS
ssh zbinv2677815@ssh.cluster0XX.lws.fr

# Vérifie les permissions
chmod -R 775 /home/laravel-app/storage
chmod -R 775 /home/laravel-app/bootstrap/cache

# Vide les caches
php artisan optimize:clear

# Vérifie les logs
tail -f /home/laravel-app/storage/logs/laravel.log
```

### Assets 404 (CSS/JS introuvables)

```bash
# SSH sur LWS
cd /home/laravel-app
npm run build
cp -r public/build /htdocs/
```

### Git pull échoue sur LWS

```bash
# SSH sur LWS
cd /home/laravel-app
git stash
git pull origin main
git stash pop
```

---

## 📞 Support

- **Documentation complète** : Voir [DEPLOIEMENT_GIT.md](DEPLOIEMENT_GIT.md)
- **Configuration LWS** : Voir [CLAUDE.md](CLAUDE.md)
- **Support LWS** : [panel.lws.fr](https://panel.lws.fr)
- **GitHub** : [github.com/simonet85/horizon-immo](https://github.com/simonet85/horizon-immo)

---

## 🎉 C'est tout !

Avec ces 3 étapes simples, tu peux déployer HorizonImmo en quelques minutes :

1. **Code** sur Laragon → **Test** local
2. **Commit** et **Push** sur GitHub
3. **Deploy** sur LWS avec le script

**🚀 Bon déploiement !**
