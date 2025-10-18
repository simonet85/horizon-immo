# 🔐 Guide SSH et Déploiement Git sur LWS

## 📋 Table des matières
1. [Activer l'accès SSH sur LWS](#1-activer-laccès-ssh-sur-lws)
2. [Configurer les clés SSH](#2-configurer-les-clés-ssh)
3. [Se connecter en SSH](#3-se-connecter-en-ssh)
4. [Configuration Git sur le serveur](#4-configuration-git-sur-le-serveur)
5. [Déploiement via Git](#5-déploiement-via-git)
6. [Script de déploiement automatisé](#6-script-de-déploiement-automatisé)
7. [Workflow complet de déploiement](#7-workflow-complet-de-déploiement)
8. [Troubleshooting](#8-troubleshooting)

---

## 1. Activer l'Accès SSH sur LWS

### Étape 1.1 : Vérifier si SSH est disponible

1. Connectez-vous à votre [Espace Client LWS](https://panel.lws.fr)
2. Allez dans **Hébergement Web** → **Votre hébergement**
3. Cherchez la section **"SSH"** ou **"Accès SSH"**

### Étape 1.2 : Activer SSH

**Si SSH est disponible :**
1. Cliquez sur **"Activer l'accès SSH"**
2. Créez un mot de passe SSH (différent du mot de passe FTP)
3. Notez vos identifiants :
   ```
   Hôte SSH: ssh.horizonimmo.com (ou ssh.cluster0XX.lws.fr)
   Port: 22
   Utilisateur: zbinv2677815
   Mot de passe: [Votre mot de passe SSH]
   ```

**⚠️ Si SSH n'est pas disponible :**
- SSH est disponible uniquement sur certaines formules LWS (généralement à partir de l'offre Pro)
- Contactez le support LWS pour activer SSH ou upgrader votre formule

---

## 2. Configurer les Clés SSH

### Pourquoi utiliser des clés SSH ?

Les clés SSH offrent une **authentification sécurisée sans mot de passe** et sont plus pratiques et sûres que les mots de passe traditionnels.

**Avantages** :
- ✅ Plus sécurisé qu'un mot de passe
- ✅ Pas besoin de saisir le mot de passe à chaque connexion
- ✅ Requis pour certaines opérations Git automatisées
- ✅ Protection contre les attaques par force brute

### Étape 2.1 : Générer une paire de clés SSH

#### Sur Windows (PowerShell, Git Bash ou CMD)

```bash
# Générer une clé SSH avec l'algorithme ed25519 (recommandé)
ssh-keygen -t ed25519 -C "votre.email@example.com"
```

**Explication des paramètres** :
- `-t ed25519` : Utilise l'algorithme ed25519 (plus sécurisé et rapide)
- `-C "votre.email@example.com"` : Ajoute un commentaire pour identifier la clé

**Alternative** : Si votre système ne supporte pas ed25519, utilisez RSA :

```bash
ssh-keygen -t rsa -b 4096 -C "votre.email@example.com"
```

#### Questions lors de la génération

```bash
Enter file in which to save the key (C:\Users\VotreNom/.ssh/id_ed25519):
```
→ **Appuyez sur Entrée** pour utiliser l'emplacement par défaut

```bash
Enter passphrase (empty for no passphrase):
```
→ **Optionnel** : Saisissez une phrase de passe pour sécuriser davantage votre clé
→ Ou **appuyez sur Entrée** pour ne pas utiliser de phrase de passe

```bash
Enter same passphrase again:
```
→ Confirmez la phrase de passe (ou appuyez sur Entrée)

**Résultat** :
```
Your identification has been saved in C:\Users\VotreNom/.ssh/id_ed25519
Your public key has been saved in C:\Users\VotreNom/.ssh/id_ed25519.pub
```

Deux fichiers sont créés :
- `id_ed25519` : **Clé privée** (à garder secrète, ne jamais partager)
- `id_ed25519.pub` : **Clé publique** (à copier sur le serveur LWS)

### Étape 2.2 : Afficher et copier la clé publique

#### Sur Windows (PowerShell ou CMD)

```bash
# Afficher la clé publique
cat ~/.ssh/id_ed25519.pub

# Ou avec type (sur Windows CMD)
type %USERPROFILE%\.ssh\id_ed25519.pub
```

#### Sur Linux/Mac

```bash
cat ~/.ssh/id_ed25519.pub
```

**Résultat** (exemple) :
```
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIJq3... votre.email@example.com
```

**Copiez toute cette ligne** (du début `ssh-ed25519` jusqu'à votre email).

### Étape 2.3 : Ajouter la clé publique sur LWS

#### Méthode 1 : Via le panneau LWS (recommandé)

1. Connectez-vous à votre [Espace Client LWS](https://panel.lws.fr)
2. Allez dans : **Hébergement Web → SSH → Gestion des clés SSH**
3. Cliquez sur **"Ajouter une clé SSH"**
4. **Collez** votre clé publique (celle que vous avez copiée)
5. Donnez un **nom** à la clé (ex: "Laragon Windows PC")
6. Cliquez sur **"Valider"**

#### Méthode 2 : Via le fichier `~/.ssh/authorized_keys` (avancé)

Si vous avez déjà un accès SSH avec mot de passe :

```bash
# Copier la clé publique sur le serveur
ssh-copy-id zbinv2677815@ssh.horizonimmo.com

# Ou manuellement
cat ~/.ssh/id_ed25519.pub | ssh zbinv2677815@ssh.horizonimmo.com "mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys"
```

### Étape 2.4 : Tester la connexion SSH avec la clé

```bash
# Tester la connexion
ssh zbinv2677815@ssh.horizonimmo.com
```

**Si tout est correct** :
- Vous serez connecté **sans saisir de mot de passe** (si aucune phrase de passe sur la clé)
- Ou on vous demandera la **phrase de passe de la clé** (si vous en avez défini une)

### Étape 2.5 : Configuration SSH avancée (optionnel)

Pour simplifier vos connexions, créez un fichier de configuration SSH.

#### Créer/Éditer le fichier `~/.ssh/config`

**Sur Windows** : `C:\Users\VotreNom\.ssh\config`

**Sur Linux/Mac** : `~/.ssh/config`

**Contenu** :

```
# Configuration pour le serveur LWS HorizonImmo
Host horizonimmo-lws
    HostName ssh.horizonimmo.com
    User zbinv2677815
    Port 22
    IdentityFile ~/.ssh/id_ed25519
    ServerAliveInterval 60
    ServerAliveCountMax 3

# Ou avec le cluster LWS
Host lws-cluster
    HostName ssh.cluster0XX.lws.fr
    User zbinv2677815
    Port 22
    IdentityFile ~/.ssh/id_ed25519
```

**Avantages** :
- Connexion simplifiée : `ssh horizonimmo-lws` (au lieu de `ssh zbinv2677815@ssh.horizonimmo.com`)
- Configuration centralisée
- Keep-alive pour éviter les déconnexions

**Utilisation** :

```bash
# Connexion simplifiée
ssh horizonimmo-lws

# Se déconnecter
exit
```

### Étape 2.6 : Sécurité des clés SSH

#### ✅ Bonnes pratiques

1. **Ne jamais partager votre clé privée** (`id_ed25519`)
2. **Utiliser une phrase de passe** pour protéger votre clé privée
3. **Sauvegarder vos clés** dans un endroit sûr (gestionnaire de mots de passe, USB chiffré)
4. **Utiliser des clés différentes** pour différents serveurs (optionnel)
5. **Révoquer les clés** si vous perdez l'accès à votre machine

#### ❌ À éviter

- ❌ Ne jamais committer vos clés privées dans Git
- ❌ Ne jamais envoyer vos clés privées par email
- ❌ Ne pas utiliser la même clé sur des machines partagées
- ❌ Ne pas laisser vos clés sans protection (phrase de passe)

#### Révoquer une clé compromise

Si vous pensez que votre clé privée a été compromise :

1. **Connectez-vous à LWS** avec mot de passe ou une autre clé
2. **Supprimez la clé compromise** du panneau LWS (SSH → Gestion des clés)
3. **Générez une nouvelle paire de clés** et ajoutez la nouvelle clé publique

```bash
# Sur votre machine locale
rm ~/.ssh/id_ed25519 ~/.ssh/id_ed25519.pub
ssh-keygen -t ed25519 -C "votre.email@example.com"
```

### Troubleshooting Clés SSH

#### Problème : "Permission denied (publickey)"

**Cause** : La clé publique n'est pas reconnue sur le serveur.

**Solutions** :
1. Vérifiez que la clé publique est bien ajoutée sur LWS
2. Vérifiez que vous utilisez la bonne clé privée :
   ```bash
   ssh -i ~/.ssh/id_ed25519 zbinv2677815@ssh.horizonimmo.com
   ```
3. Vérifiez les permissions de votre clé privée :
   ```bash
   # Sur Linux/Mac
   chmod 600 ~/.ssh/id_ed25519
   chmod 644 ~/.ssh/id_ed25519.pub
   ```

#### Problème : "Bad permissions" sur Windows

**Cause** : Permissions trop ouvertes sur le fichier de clé.

**Solution** :
1. Clic droit sur le fichier `id_ed25519` → **Propriétés**
2. Onglet **Sécurité** → **Avancé**
3. **Désactiver l'héritage** → Supprimer toutes les permissions
4. **Ajouter** → Sélectionner votre utilisateur → Donner **Contrôle total**
5. Cliquez sur **OK**

#### Problème : Connexion réussie mais Git échoue

**Cause** : Git utilise une autre clé ou n'a pas accès à la clé.

**Solution** : Configurer Git pour utiliser SSH :

```bash
# Cloner avec SSH au lieu de HTTPS
git clone git@github.com:simonet85/horizon-immo.git

# Modifier l'URL remote d'un dépôt existant
git remote set-url origin git@github.com:simonet85/horizon-immo.git
```

---

## 3. Se Connecter en SSH

### Option 1 : Depuis Windows (PowerShell ou CMD)

```bash
# Commande de connexion SSH
ssh zbinv2677815@ssh.horizonimmo.com

# Ou avec le port explicite
ssh -p 22 zbinv2677815@ssh.horizonimmo.com
```

**Lors de la première connexion :**
```
The authenticity of host 'ssh.horizonimmo.com' can't be established.
Are you sure you want to continue connecting (yes/no)?
```
→ Tapez `yes` et appuyez sur Entrée

**Entrez votre mot de passe SSH** (il ne s'affichera pas à l'écran)

### Option 2 : Avec PuTTY (Windows)

1. **Téléchargez PuTTY** : https://www.putty.org/
2. **Configuration :**
   - Host Name: `ssh.horizonimmo.com`
   - Port: `22`
   - Connection type: `SSH`
3. Cliquez sur **"Open"**
4. Entrez votre login : `zbinv2677815`
5. Entrez votre mot de passe SSH

### Option 3 : Depuis Linux/Mac (Terminal)

```bash
ssh zbinv2677815@ssh.horizonimmo.com
```

### ✅ Vérification de la Connexion

Une fois connecté, vous devriez voir :
```bash
zbinv2677815@lwsXXXXX:~$
```

Testez les commandes de base :
```bash
# Voir où vous êtes
pwd
# Résultat attendu: /home/zbinv2677815

# Lister les fichiers
ls -la

# Aller dans le dossier Laravel
cd laravel-app
pwd
# Résultat attendu: /home/zbinv2677815/laravel-app
```

---

## 4. Configuration Git sur le Serveur

### Étape 4.1 : Vérifier si Git est installé

```bash
git --version
```

**Si Git n'est pas installé :**
```bash
# Sur LWS, Git est généralement préinstallé
# Si ce n'est pas le cas, contactez le support LWS
```

### Étape 4.2 : Configurer Git (première fois uniquement)

```bash
# Configurer votre nom
git config --global user.name "Votre Nom"

# Configurer votre email
git config --global user.email "votre.email@example.com"

# Vérifier la configuration
git config --list
```

### Étape 4.3 : Se Placer dans le Bon Dossier

```bash
# Aller dans le dossier de l'application
cd /home/zbinv2677815/laravel-app

# Vérifier qu'on est au bon endroit
pwd
ls -la
```

---

## 5. Déploiement via Git

### Méthode 1 : Clonage Initial (Si pas encore fait)

**Si votre projet n'a pas encore été cloné sur le serveur :**

```bash
# Se placer dans le dossier home
cd /home/zbinv2677815

# Cloner le dépôt GitHub
git clone https://github.com/simonet85/horizon-immo.git laravel-app

# Entrer dans le dossier
cd laravel-app
```

### Méthode 2 : Mise à Jour du Projet Existant

**Si le projet existe déjà sur le serveur :**

```bash
# Se placer dans le dossier Laravel
cd /home/zbinv2677815/laravel-app

# Vérifier l'état de Git
git status

# Récupérer les dernières modifications
git pull origin main
```

**Si vous avez des modifications locales non commitées :**
```bash
# Sauvegarder temporairement vos changements locaux
git stash

# Récupérer les modifications du dépôt
git pull origin main

# Réappliquer vos changements (si nécessaire)
git stash pop
```

### Méthode 3 : Réinitialiser Complètement (Reset Hard)

**⚠️ Attention : Cette commande écrase TOUTES les modifications locales !**

```bash
# Se placer dans le dossier Laravel
cd /home/zbinv2677815/laravel-app

# Réinitialiser au dernier commit de GitHub
git fetch origin
git reset --hard origin/main

# Forcer la mise à jour
git pull origin main
```

---

## 6. Script de Déploiement Automatisé

### Étape 6.1 : Créer le Script de Déploiement

```bash
# Créer le fichier de script
nano /home/zbinv2677815/laravel-app/deploy.sh
```

**Contenu du script `deploy.sh` :**

```bash
#!/bin/bash

echo "🚀 Démarrage du déploiement..."

# Couleurs pour les messages
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Se placer dans le bon dossier
cd /home/zbinv2677815/laravel-app || exit

# Mode maintenance
echo -e "${YELLOW}📦 Activation du mode maintenance...${NC}"
php artisan down --message="Mise à jour en cours. Retour dans quelques instants." || true

# Mise à jour du code depuis Git
echo -e "${YELLOW}🔄 Récupération des dernières modifications...${NC}"
git fetch origin
git reset --hard origin/main
git pull origin main

# Installation des dépendances Composer
echo -e "${YELLOW}📦 Mise à jour des dépendances Composer...${NC}"
composer install --no-dev --optimize-autoloader --no-interaction

# Vider les caches
echo -e "${YELLOW}🧹 Nettoyage des caches...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan event:clear

# Reconstruire les caches
echo -e "${YELLOW}🔨 Reconstruction des caches...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Exécuter les migrations (si nouvelles)
echo -e "${YELLOW}🗄️ Exécution des migrations...${NC}"
php artisan migrate --force --no-interaction

# Créer le lien symbolique storage (si pas encore fait)
echo -e "${YELLOW}🔗 Création du lien symbolique storage...${NC}"
php artisan storage:link || true

# Vérifier les permissions
echo -e "${YELLOW}🔐 Vérification des permissions...${NC}"
chmod -R 775 storage bootstrap/cache

# Désactiver le mode maintenance
echo -e "${YELLOW}✅ Désactivation du mode maintenance...${NC}"
php artisan up

echo -e "${GREEN}🎉 Déploiement terminé avec succès !${NC}"
echo ""
echo "📊 Informations :"
git log --oneline -1
echo ""
echo "✅ Le site est maintenant à jour et accessible."
```

**Enregistrer et quitter :**
- Appuyez sur `Ctrl + O` (pour sauvegarder)
- Appuyez sur `Entrée` (pour confirmer)
- Appuyez sur `Ctrl + X` (pour quitter)

### Étape 6.2 : Rendre le Script Exécutable

```bash
chmod +x /home/zbinv2677815/laravel-app/deploy.sh
```

### Étape 6.3 : Exécuter le Script

```bash
# Depuis le dossier laravel-app
./deploy.sh

# Ou depuis n'importe où
/home/zbinv2677815/laravel-app/deploy.sh
```

---

## 7. Workflow Complet de Déploiement

### Workflow Recommandé

```bash
# 1. Se connecter en SSH
ssh zbinv2677815@ssh.horizonimmo.com

# 2. Aller dans le dossier du projet
cd /home/zbinv2677815/laravel-app

# 3. Vérifier l'état actuel
git status
git log --oneline -5

# 4. Exécuter le déploiement
./deploy.sh

# 5. Vérifier que tout fonctionne
tail -f storage/logs/laravel.log
# Ctrl+C pour quitter

# 6. Se déconnecter
exit
```

### Commandes Git Utiles

```bash
# Voir l'historique des commits
git log --oneline -10

# Voir les différences avec la version GitHub
git fetch origin
git diff origin/main

# Voir les fichiers modifiés
git status

# Voir les branches
git branch -a

# Changer de branche (si vous en avez plusieurs)
git checkout nom-de-branche

# Voir le dernier commit
git log -1

# Voir les fichiers d'un commit spécifique
git show --name-only commit-hash
```

---

## 8. Troubleshooting

### Problème 1 : "Permission denied (publickey)"

**Cause :** Vous essayez de cloner via SSH mais n'avez pas configuré de clé SSH.

**Solution :**
```bash
# Utilisez HTTPS au lieu de SSH
git clone https://github.com/simonet85/horizon-immo.git laravel-app
```

### Problème 2 : "fatal: not a git repository"

**Cause :** Vous n'êtes pas dans un dossier Git.

**Solution :**
```bash
# Vérifiez que vous êtes dans le bon dossier
cd /home/zbinv2677815/laravel-app
ls -la .git
```

### Problème 3 : "error: Your local changes would be overwritten"

**Cause :** Vous avez des modifications locales non commitées.

**Solution 1 (Sauvegarder les changements) :**
```bash
git stash
git pull origin main
```

**Solution 2 (Écraser les changements locaux) :**
```bash
git fetch origin
git reset --hard origin/main
```

### Problème 4 : "Composer: command not found"

**Cause :** Composer n'est pas installé ou pas dans le PATH.

**Solution :**
```bash
# Vérifier l'emplacement de Composer
which composer

# Si Composer est dans ~/.composer
~/.composer/vendor/bin/composer install

# Ou utiliser le chemin complet
/usr/local/bin/composer install
```

### Problème 5 : Erreur 500 après déploiement

**Vérifications :**
```bash
# 1. Vérifier les permissions
chmod -R 775 storage bootstrap/cache

# 2. Vérifier le fichier .env
cat .env | grep APP_KEY

# 3. Générer une nouvelle clé si nécessaire
php artisan key:generate

# 4. Vider tous les caches
php artisan optimize:clear
```

### Problème 6 : "Could not resolve host: github.com"

**Cause :** Problème de DNS ou de connexion internet du serveur.

**Solution :**
```bash
# Tester la connexion
ping github.com

# Si ça ne fonctionne pas, contactez le support LWS
```

---

## 9. Sécurité et Bonnes Pratiques

### ✅ À Faire

1. **Toujours faire un backup avant déploiement**
   ```bash
   cp -r /home/zbinv2677815/laravel-app /home/zbinv2677815/laravel-app-backup-$(date +%Y%m%d)
   ```

2. **Utiliser le mode maintenance**
   ```bash
   php artisan down
   # ... déploiement ...
   php artisan up
   ```

3. **Vérifier les logs après déploiement**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Tester sur staging avant production** (si vous avez un environnement de staging)

### ❌ À Éviter

1. ❌ Ne jamais éditer les fichiers directement sur le serveur
2. ❌ Ne jamais commiter le fichier `.env`
3. ❌ Ne pas exécuter `composer update` en production (utiliser `composer install`)
4. ❌ Ne pas oublier de vider les caches après déploiement

---

## 10. Commandes de Diagnostic Utiles

```bash
# Vérifier la version PHP
php -v

# Vérifier les extensions PHP
php -m

# Vérifier l'espace disque
df -h

# Vérifier la mémoire
free -h

# Voir les processus PHP en cours
ps aux | grep php

# Vérifier les permissions
ls -la storage/
ls -la bootstrap/cache/

# Vérifier la configuration Laravel
php artisan about

# Tester la connexion à la base de données
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

---

## 11. Alternative : Déploiement Automatisé via GitHub Actions

Si vous voulez automatiser complètement le déploiement, vous pouvez utiliser GitHub Actions :

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
    - name: Deploy via SSH
      uses: appleboy/ssh-action@master
      with:
        host: ${{ secrets.SSH_HOST }}
        username: ${{ secrets.SSH_USERNAME }}
        password: ${{ secrets.SSH_PASSWORD }}
        port: 22
        script: |
          cd /home/zbinv2677815/laravel-app
          ./deploy.sh
```

**Configurer les secrets GitHub :**
1. Allez dans **Settings → Secrets and variables → Actions**
2. Ajoutez :
   - `SSH_HOST` : `ssh.horizonimmo.com`
   - `SSH_USERNAME` : `zbinv2677815`
   - `SSH_PASSWORD` : Votre mot de passe SSH

---

## 📊 Résumé Rapide

**Connexion SSH :**
```bash
ssh zbinv2677815@ssh.horizonimmo.com
```

**Déploiement Rapide :**
```bash
cd /home/zbinv2677815/laravel-app
./deploy.sh
```

**Mise à jour manuelle :**
```bash
cd /home/zbinv2677815/laravel-app
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan optimize
```

---

## 📚 Ressources

- 📖 [Guide de déploiement initial](CLAUDE.md)
- 🔄 [Guide de mise à jour FTP](GUIDE_MISE_A_JOUR_LWS.md)
- ✅ [Checklist rapide](UPDATE_CHECKLIST.md)
- 📋 [Fichiers à uploader](FILES_TO_UPLOAD.txt)

---

**🎉 Vous êtes maintenant prêt à déployer via Git sur LWS !**
