# ✅ Checklist Rapide - Mise à Jour LWS

## 🚀 Procédure en 5 Étapes

### 1️⃣ CONNEXION FTP
```
Hôte: ftp.horizonimmo.com
User: zbinv2677815
Port: 21
```

### 2️⃣ FICHIERS À UPLOADER (Dernières Modifications)

#### 📁 Models → `/home/laravel-app/app/Models/`
- ✅ `ContactMessage.php`
- ✅ `Property.php`
- ✅ `Town.php`

#### 📁 Controllers → `/home/laravel-app/app/Http/Controllers/Admin/`
- ✅ `ContactMessageController.php`
- ✅ `PropertyController.php`
- ✅ `TownController.php`

#### 📁 Views → `/home/laravel-app/resources/views/`
- ✅ `admin/categories/edit.blade.php`
- ✅ `admin/towns/edit.blade.php`
- ✅ `admin/contact-messages/index.blade.php`
- ✅ `admin/contact-messages/show.blade.php`
- ✅ `admin/dashboard.blade.php`
- ✅ `errors/503.blade.php`

#### 📁 Providers → `/home/laravel-app/app/Providers/`
- ✅ `AdminViewServiceProvider.php`

### 3️⃣ VIDER LES CACHES

**Option A - Via navigateur :**
```
1. Upload clear-cache-lws.php dans /htdocs/
2. Visitez: https://horizonimmo.com/clear-cache-lws.php
3. SUPPRIMER le fichier après usage !
```

**Option B - Via SSH :**
```bash
cd /home/laravel-app
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Option C - Manuel (File Manager LWS) :**
```
Supprimer dans /home/laravel-app/bootstrap/cache/ :
- config.php
- routes-v7.php
- services.php
```

### 4️⃣ VÉRIFICATIONS

- [ ] Badge messages contact affiche le bon nombre
- [ ] Édition catégorie → "Enregistrer" sauvegarde (ne supprime pas)
- [ ] Édition ville → "Enregistrer" sauvegarde (ne supprime pas)
- [ ] Actions "Marquer lu/Non lu" fonctionnent
- [ ] Aucune erreur dans les logs

### 5️⃣ EN CAS DE PROBLÈME

**Erreur 500 ?**
```
→ Vérifier permissions: storage/ et bootstrap/cache/ (775)
→ Consulter logs: /home/laravel-app/storage/logs/laravel.log
```

**Vue pas à jour ?**
```
→ Vider le cache des vues
→ Forcer le rafraîchissement (Ctrl+F5)
```

---

## 📋 Fichiers Modifiés Récemment (à uploader)

**Commits récents :**
- `f30a694` - Guide de mise à jour
- `a36ce82` - Fix town edit form
- `df3a5c1` - Fix category edit form
- `01e2e9d` - Update contact messages UI
- `13a7af3` - Fix unread scope
- `77641e2` - Fix contact badge

**Total : ~10 fichiers modifiés**

---

## 🔄 Workflow Complet

```
1. Connexion FTP (FileZilla)
   ↓
2. Upload fichiers modifiés
   ↓
3. Vider caches Laravel
   ↓
4. Test fonctionnalités
   ↓
5. ✅ Mise à jour terminée !
```

---

📖 **Guide détaillé :** [GUIDE_MISE_A_JOUR_LWS.md](GUIDE_MISE_A_JOUR_LWS.md)
