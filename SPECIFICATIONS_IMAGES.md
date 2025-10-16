# 📸 SPÉCIFICATIONS DES IMAGES POUR HORIZONIMMO

## 🎯 Table des matières
1. [Hero Slider (Page détail propriété)](#1-hero-slider-page-détail-propriété)
2. [Galerie de photos](#2-galerie-de-photos)
3. [Cards catalogue](#3-cards-catalogue)
4. [Modal plein écran](#4-modal-plein-écran)
5. [Recommandations générales](#5-recommandations-générales)
6. [Outils de compression](#6-outils-de-compression)

---

## 1. Hero Slider (Page détail propriété)

### 📐 Dimensions du conteneur
- **Hauteur fixe** : `384px` (h-96 en Tailwind)
- **Largeur** : 100% de l'écran (responsive)
- **Ratio** : Adaptatif selon la largeur de l'écran

### 🖼️ Spécifications recommandées

| Appareil | Largeur écran | Résolution image recommandée | Ratio | Poids max |
|----------|---------------|------------------------------|-------|-----------|
| **Mobile** | 375px - 767px | **1600 × 900px** | 16:9 | 150-200 KB |
| **Tablette** | 768px - 1023px | **2048 × 1152px** | 16:9 | 200-300 KB |
| **Desktop** | 1024px - 1919px | **2560 × 1440px** | 16:9 | 300-400 KB |
| **4K/Retina** | 1920px+ | **3840 × 2160px** | 16:9 | 400-600 KB |

### ✅ **Recommandation optimale (tous écrans)**
```
Résolution : 2560 × 1440 pixels (QHD/2K)
Ratio : 16:9
Format : JPEG progressif
Qualité : 85%
Poids : 300-400 KB max
```

### 🎨 Caractéristiques techniques
- **CSS appliqué** : `object-cover` (l'image remplit le conteneur en conservant son ratio)
- **Overlay** : Fond noir à 50% d'opacité appliqué par-dessus
- **Texte superposé** : Titre + ville centré en blanc

### 💡 Pourquoi ce ratio 16:9 ?
- Ratio universel pour tous les écrans (TV, monitors, mobiles en paysage)
- Hauteur fixe de 384px = largeur idéale de 683px minimum (ratio 16:9)
- Sur grand écran (1920px), hauteur 384px = largeur 1920px (ratio respecté)

---

## 2. Galerie de photos

### 📐 Dimensions du conteneur
- **Hauteur fixe** : `192px` (h-48 en Tailwind)
- **Largeur** : Responsive en grille (2 colonnes mobile, 3 colonnes desktop)
- **Comportement** : `object-cover` avec effet hover `scale-105`

### 🖼️ Spécifications recommandées

| Type | Résolution | Ratio | Poids max |
|------|-----------|-------|-----------|
| **Miniature galerie** | **800 × 600px** | 4:3 | 80-120 KB |
| **Version optimale** | **1200 × 900px** | 4:3 | 150-200 KB |

### ✅ **Recommandation optimale**
```
Résolution : 1200 × 900 pixels
Ratio : 4:3
Format : JPEG progressif
Qualité : 80%
Poids : 120-150 KB max
```

### 💡 Pourquoi ce ratio 4:3 ?
- Conteneur presque carré (légèrement plus large que haut)
- Bon compromis pour photos intérieures (pièces, détails)
- Facilite le crop sans perdre d'informations importantes

---

## 3. Cards catalogue (propriétés similaires)

### 📐 Dimensions du conteneur
- **Hauteur fixe** : `256px` (h-64 en Tailwind)
- **Largeur** : Responsive (1, 2 ou 3 colonnes selon l'écran)
- **Comportement** : `object-cover` avec effet hover `scale-110`

### 🖼️ Spécifications recommandées

| Appareil | Résolution | Ratio | Poids max |
|----------|-----------|-------|-----------|
| **Mobile/Tablette** | **800 × 600px** | 4:3 | 100-150 KB |
| **Desktop** | **1200 × 900px** | 4:3 | 150-200 KB |

### ✅ **Recommandation optimale**
```
Résolution : 1200 × 900 pixels
Ratio : 4:3
Format : JPEG progressif
Qualité : 80%
Poids : 120-180 KB max
```

---

## 4. Modal plein écran (lightbox)

### 📐 Dimensions du conteneur
- **Hauteur** : 80% de la hauteur de l'écran (`h-[80vh]`)
- **Largeur** : 100% avec max-width 1536px (`max-w-6xl`)
- **Comportement** : `object-contain` (image entière visible sans crop)

### 🖼️ Spécifications recommandées

| Type | Résolution | Ratio | Poids max |
|------|-----------|-------|-----------|
| **HD** | **1920 × 1080px** | 16:9 | 400-600 KB |
| **Full HD+** | **2560 × 1440px** | 16:9 | 500-800 KB |
| **4K** | **3840 × 2160px** | 16:9 | 800 KB - 1.2 MB |

### ✅ **Recommandation optimale**
```
Résolution : 2560 × 1440 pixels (QHD)
Ratio : 16:9 ou libre
Format : JPEG progressif
Qualité : 90%
Poids : 500-700 KB max
```

### 💡 Notes importantes
- **`object-contain`** : L'image complète est visible (pas de crop)
- Idéal pour voir tous les détails en haute qualité
- Accepte n'importe quel ratio (l'image s'adapte)

---

## 5. Recommandations générales

### 🎯 **Format d'image**
| Format | Cas d'usage | Avantages | Inconvénients |
|--------|-------------|-----------|---------------|
| **JPEG** | Photos immobilières standard | Taille optimale, bonne qualité | Pas de transparence |
| **WebP** | Meilleure compression moderne | 25-35% plus léger que JPEG | Pas supporté par très vieux navigateurs |
| **AVIF** | Compression next-gen | 50% plus léger que JPEG | Support limité (Chrome 85+, Firefox 93+) |
| **PNG** | Logos, graphiques, transparence | Qualité parfaite | Très lourd pour photos |

### ✅ **Recommandation**
```
Format principal : JPEG progressif (qualité 80-85%)
Format moderne : WebP (en complément, avec fallback JPEG)
```

### 📏 **Résumé des tailles recommandées**

| Usage | Résolution idéale | Ratio | Poids max | Format |
|-------|------------------|-------|-----------|--------|
| **Hero Slider** | 2560 × 1440px | 16:9 | 350 KB | JPEG 85% |
| **Galerie miniatures** | 1200 × 900px | 4:3 | 150 KB | JPEG 80% |
| **Cards catalogue** | 1200 × 900px | 4:3 | 180 KB | JPEG 80% |
| **Modal plein écran** | 2560 × 1440px | 16:9 | 600 KB | JPEG 90% |

### 🎨 **Conseils qualité photo**
1. **Luminosité** : Privilégier la lumière naturelle
2. **Angle** : Shooter en mode paysage (horizontal)
3. **Stabilité** : Utiliser un trépied si possible
4. **Post-traitement** :
   - Corriger la balance des blancs
   - Ajuster légèrement la luminosité/contraste
   - Redresser les verticales (photos d'architecture)

### 📦 **Nombre d'images recommandé**
- **Minimum** : 4-6 images par propriété
- **Optimal** : 8-12 images
- **Maximum** : 20 images

**Photos essentielles** :
1. Façade extérieure
2. Salon/pièce principale
3. Cuisine
4. Chambres (toutes)
5. Salles de bain
6. Espaces extérieurs (jardin, balcon, terrasse)
7. Vue depuis la propriété
8. Détails intéressants (cheminée, finitions, etc.)

---

## 6. Outils de compression

### 🛠️ **Outils en ligne (gratuits)**

#### **TinyPNG / TinyJPG** ⭐ Recommandé
- 🔗 [https://tinypng.com](https://tinypng.com)
- Compression intelligente sans perte de qualité visible
- Supporte JPEG, PNG, WebP
- Limite : 20 images à la fois (5 MB max chacune)

#### **Squoosh** (Google)
- 🔗 [https://squoosh.app](https://squoosh.app)
- Comparaison avant/après en temps réel
- Conversion vers WebP, AVIF
- Ajustement manuel de la qualité

#### **ImageOptim** (Mac uniquement)
- 🔗 [https://imageoptim.com](https://imageoptim.com)
- Application desktop gratuite
- Compression par lot (drag & drop)

#### **Compressor.io**
- 🔗 [https://compressor.io](https://compressor.io)
- Compression jusqu'à 90% sans perte visible
- Supporte JPEG, PNG, GIF, SVG

### 🖥️ **Outils logiciels**

#### **Adobe Photoshop**
```
Fichier → Exporter → Enregistrer pour le Web (hérité)
Format : JPEG
Qualité : 80-85%
☑️ Progressif
☑️ Optimisé
```

#### **GIMP (gratuit)**
```
Fichier → Exporter sous
Format : JPEG
Qualité : 80-85%
☑️ Progressif
Sous-échantillonnage : 4:2:0 (chrominance)
```

#### **XnConvert (gratuit, Windows/Mac/Linux)**
- 🔗 [https://www.xnview.com/en/xnconvert/](https://www.xnview.com/en/xnconvert/)
- Traitement par lot
- Redimensionnement + compression automatique
- Préréglages personnalisables

### 📱 **Outils mobiles**

#### **Photoshop Express** (iOS/Android)
- Gratuit
- Compression et ajustements rapides

#### **Snapseed** (iOS/Android)
- Gratuit (Google)
- Ajustements professionnels
- Export en qualité ajustable

---

## 7. Workflow recommandé

### 📸 **Étape 1 : Prise de photo**
- Appareil photo reflex ou smartphone récent (12MP+)
- Mode HDR activé si disponible
- Shooter en haute résolution (4000×3000px minimum)

### ✂️ **Étape 2 : Recadrage**
```
Ratio Hero : 16:9 (2560 × 1440px)
Ratio Galerie : 4:3 (1200 × 900px)
```

### 🎨 **Étape 3 : Retouches**
- Balance des blancs
- Exposition / Contraste
- Netteté légère (+10%)
- Redressement des verticales

### 📦 **Étape 4 : Export et compression**
```
Format : JPEG progressif
Qualité : 80-85%
Résolution : selon usage (voir tableau ci-dessus)
Espace colorimétrique : sRGB
```

### ☑️ **Étape 5 : Compression finale**
- Passer par TinyPNG ou Squoosh
- Vérifier le poids final (< 400 KB pour hero)
- Tester l'affichage sur le site

---

## 8. Checklist avant upload

### ✅ **Vérifications obligatoires**

- [ ] **Format** : JPEG progressif
- [ ] **Résolution** : 2560×1440px (hero) ou 1200×900px (galerie)
- [ ] **Ratio** : 16:9 (hero) ou 4:3 (galerie)
- [ ] **Poids** : < 400 KB (hero) ou < 180 KB (galerie)
- [ ] **Qualité** : 80-85%
- [ ] **Orientation** : Paysage (horizontal)
- [ ] **Nom de fichier** : Descriptif (ex: `villa-cap-facade.jpg`)
- [ ] **Métadonnées** : Supprimées (EXIF, GPS) pour réduire le poids

### 🚫 **À éviter**

- ❌ Photos floues ou mal cadrées
- ❌ Images trop lourdes (> 1 MB)
- ❌ Ratios incorrects (portraits en paysage)
- ❌ Résolution trop faible (< 1200px largeur)
- ❌ Sur-compression (qualité < 70%)
- ❌ Filigrane ou watermark visible
- ❌ Photos sombres ou surexposées
- ❌ Mobilier encombrant ou désordonné visible

---

## 9. Performance et SEO

### ⚡ **Optimisation du chargement**

#### **Lazy Loading**
Le site utilise déjà le lazy loading natif pour les images :
```html
<img loading="lazy" src="..." alt="...">
```

#### **Format moderne avec fallback**
```html
<picture>
  <source srcset="image.webp" type="image/webp">
  <source srcset="image.jpg" type="image/jpeg">
  <img src="image.jpg" alt="Description">
</picture>
```

### 🔍 **SEO des images**

#### **Nommage des fichiers**
```
✅ Bon : appartement-cap-town-salon-lumineux.jpg
❌ Mauvais : IMG_20250115_142532.jpg
```

#### **Attribut ALT**
```html
✅ Bon : alt="Salon lumineux de 45m² avec vue mer - Appartement Cap Town"
❌ Mauvais : alt="Image 1"
```

#### **Métadonnées**
- **Title** : Description courte
- **Caption** : Description détaillée (optionnelle)
- **Copyright** : © ZB Investments 2025

---

## 10. Exemples pratiques

### 📸 **Exemple : Villa à Cap Town**

#### **Hero Slider (5 images)**
```
1. villa-cap-town-facade-principale.jpg       (2560×1440px, 380 KB)
2. villa-cap-town-salon-vue-mer.jpg           (2560×1440px, 360 KB)
3. villa-cap-town-cuisine-moderne.jpg         (2560×1440px, 340 KB)
4. villa-cap-town-chambre-master.jpg          (2560×1440px, 350 KB)
5. villa-cap-town-piscine-jardin.jpg          (2560×1440px, 390 KB)
```

#### **Galerie complète (12 images)**
```
Même fichiers que ci-dessus + :
6. villa-cap-town-salle-bain-master.jpg       (1200×900px, 160 KB)
7. villa-cap-town-chambre-enfant-1.jpg        (1200×900px, 150 KB)
8. villa-cap-town-chambre-enfant-2.jpg        (1200×900px, 155 KB)
9. villa-cap-town-bureau-domicile.jpg         (1200×900px, 145 KB)
10. villa-cap-town-terrasse-vue.jpg           (1200×900px, 170 KB)
11. villa-cap-town-garage-double.jpg          (1200×900px, 140 KB)
12. villa-cap-town-entree-principale.jpg      (1200×900px, 148 KB)
```

#### **Poids total**
- Hero (5 images) : ~1.8 MB
- Galerie (12 images) : ~3.0 MB
- **Total : ~4.8 MB** (acceptable pour une page de détail)

---

## 11. Support technique

### 🐛 **Problèmes courants**

#### **Image déformée dans le slider**
**Cause** : Ratio incorrect
**Solution** : Utiliser 16:9 (2560×1440px)

#### **Image floue sur écran Retina**
**Cause** : Résolution trop faible
**Solution** : Utiliser 2× la résolution affichée

#### **Temps de chargement lent**
**Cause** : Images trop lourdes
**Solution** : Compresser à < 400 KB par image

#### **Image coupée dans la galerie**
**Cause** : Ratio incorrect ou point focal mal placé
**Solution** : Utiliser ratio 4:3 et centrer le sujet

### 📊 **Tests de performance**

Testez vos pages avec :
- **PageSpeed Insights** : [https://pagespeed.web.dev/](https://pagespeed.web.dev/)
- **GTmetrix** : [https://gtmetrix.com/](https://gtmetrix.com/)
- **WebPageTest** : [https://www.webpagetest.org/](https://www.webpagetest.org/)

**Score cible** :
- ✅ PageSpeed : > 80/100
- ✅ Temps de chargement : < 3 secondes
- ✅ Largest Contentful Paint (LCP) : < 2.5s

---

## 📚 Ressources supplémentaires

### 📖 **Documentation**
- [Web.dev - Image Optimization](https://web.dev/fast/#optimize-your-images)
- [MDN - Responsive Images](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images)

### 🎓 **Tutoriels**
- [Google - WebP Guide](https://developers.google.com/speed/webp)
- [TinyPNG - Best Practices](https://tinypng.com/blog)

---

## ✅ Résumé rapide

| Élément | Résolution | Ratio | Poids | Format |
|---------|-----------|-------|-------|--------|
| **Hero Slider** | 2560 × 1440px | 16:9 | 350 KB | JPEG 85% |
| **Galerie** | 1200 × 900px | 4:3 | 150 KB | JPEG 80% |
| **Cards** | 1200 × 900px | 4:3 | 180 KB | JPEG 80% |
| **Modal** | 2560 × 1440px | 16:9 | 600 KB | JPEG 90% |

**Outil recommandé** : [TinyPNG](https://tinypng.com) pour la compression finale.

---

*Document créé pour HorizonImmo - Dernière mise à jour : Octobre 2025*
