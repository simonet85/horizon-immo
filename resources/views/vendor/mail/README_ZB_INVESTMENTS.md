# 📧 Templates Email ZB Investments

## 🎨 Design Personnalisé

Les templates d'emails ont été personnalisés avec le branding **ZB Investments** :

### Couleurs
- **Orange principal** : `#f97316` (gradient header)
- **Orange secondaire** : `#ea580c` (gradient header)
- **Vert succès** : `#10b981` (boutons success)
- **Gris texte** : `#4b5563`
- **Fond** : `#f9fafb`

### Modifications apportées

#### 1. **Header** (`header.blade.php`)
- Logo ZB Investments affiché automatiquement
- Fond dégradé orange
- Hauteur logo : 60px max

#### 2. **Footer** (`footer.blade.php`)
- Informations de contact ZB Investments
- Adresse : Afrique du Sud
- Email : info@zbinvestments-ci.com
- Téléphone : +27 (0) 11 123 4567
- Copyright automatique

#### 3. **Styles** (`themes/default.css`)
- Typographie améliorée (line-height 1.6)
- Boutons arrondis (border-radius 8px)
- Couleur principale orange
- Ombre plus moderne
- Card arrondie (border-radius 12px)

## 📝 Configuration Email

### Variables d'environnement (.env)
```env
APP_NAME="ZB Investments"
APP_URL=http://horizonimmo.test

MAIL_MAILER=smtp
MAIL_HOST=mail.zbinvestments-ci.com
MAIL_PORT=587
MAIL_USERNAME=info@zbinvestments-ci.com
MAIL_PASSWORD=qH4-G3bJrZKhwkK
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@zbinvestments-ci.com"
MAIL_FROM_NAME="ZB Investments"
```

## 🚀 Utilisation

Les emails Laravel utiliseront automatiquement ce template :

```php
use Illuminate\Support\Facades\Mail;

Mail::to('client@example.com')->send(new WelcomeMail());
```

Le template ajoutera automatiquement :
- ✅ Header avec logo ZB Investments
- ✅ Footer avec coordonnées
- ✅ Couleurs et style personnalisés
- ✅ Responsive design

## 📦 Fichiers modifiés

- `resources/views/vendor/mail/html/header.blade.php`
- `resources/views/vendor/mail/html/footer.blade.php`
- `resources/views/vendor/mail/html/themes/default.css`

## 🔄 Mise à jour

Après toute modification, vider les caches :

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 📸 Aperçu

Les emails afficheront :
- **En-tête** : Fond orange dégradé avec logo ZB Investments
- **Corps** : Carte blanche arrondie avec contenu
- **Boutons** : Orange primaire, arrondis
- **Pied de page** : Coordonnées complètes + copyright

---

**Créé pour ZB Investments** - Votre partenaire immobilier en Afrique du Sud 🏡
