# Guide de Test - Système d'Avatar

## 🎯 Objectifs de Test

Tester le système complet d'upload, prévisualisation et gestion des avatars utilisateur.

## 🚀 Étapes de Test

### 1. Accès à l'Interface

1. Aller sur `http://localhost:8000`
2. Se connecter avec un utilisateur existant
3. Naviguer vers `/profile/edit`

### 2. Test d'Upload d'Avatar

#### Test d'affichage initial

-   ✅ Vérifier l'affichage des initiales si pas d'avatar
-   ✅ Vérifier l'algorithme d'initiales avec noms complexes (Marie-Claire → MCD)

#### Test d'upload

1. Cliquer sur "Choisir une nouvelle photo"
2. Sélectionner une image (PNG, JPG, GIF)
3. ✅ Vérifier la prévisualisation en temps réel
4. ✅ Vérifier le bouton "Enregistrer cette photo" apparaît
5. Cliquer sur "Enregistrer cette photo"
6. ✅ Vérifier le message de succès
7. ✅ Vérifier que l'avatar est mis à jour dans la sidebar

#### Test de validation

1. Essayer d'uploader un fichier trop gros (>2MB)
2. ✅ Vérifier le message d'erreur de validation
3. Essayer d'uploader un fichier non-image (PDF, TXT)
4. ✅ Vérifier le message d'erreur de format

#### Test de suppression

1. Avec un avatar existant, cliquer sur "Supprimer la photo"
2. ✅ Vérifier la confirmation de suppression
3. Confirmer la suppression
4. ✅ Vérifier que l'avatar est supprimé
5. ✅ Vérifier le retour aux initiales dans la sidebar

### 3. Test de Synchronisation Interface

#### Navigation/Sidebar

-   ✅ L'avatar/initiales s'affichent correctement dans la navigation
-   ✅ Les changements d'avatar se reflètent immédiatement
-   ✅ L'algorithme d'initiales fonctionne pour tous types de noms

#### Gestion en temps réel

-   ✅ Les événements Livewire rafraîchissent l'interface
-   ✅ Pas de rechargement manuel nécessaire
-   ✅ Messages de feedback appropriés

### 4. Tests Edge Cases

#### Noms complexes pour initiales

-   Jean Dupont → JD
-   Marie-Claire Dubois → MCD
-   Jean-Paul Martin-Rodriguez → JPMR
-   Pierre De La Fontaine → PDLF
-   "" (vide) → U

#### Formats d'images

-   JPEG (photo standard)
-   PNG (avec transparence)
-   GIF (animé ou statique)
-   Fichiers corrompus → Erreur appropriée

## 🛠️ Dépannage

### Problèmes courants

1. **Avatar ne s'affiche pas** : Vérifier `php artisan storage:link`
2. **Upload échoue** : Vérifier les permissions du dossier storage
3. **Initiales incorrectes** : Vérifier l'algorithme regex `preg_split('/[\s\-]+/', $name)`

### Commandes utiles

```bash
# Vérifier le storage link
php artisan storage:link

# Tester avec Tinker
php artisan tinker
>>> $user = User::find(1)
>>> $user->avatar = 'avatars/test.jpg'
>>> $user->save()

# Démarrer le serveur
php artisan serve --host=0.0.0.0 --port=8000
```

## ✅ Checklist de Validation

-   [ ] Upload d'image fonctionne
-   [ ] Prévisualisation en temps réel
-   [ ] Validation des formats/tailles
-   [ ] Suppression d'avatar
-   [ ] Affichage des initiales correctes
-   [ ] Synchronisation sidebar/navigation
-   [ ] Messages de feedback appropriés
-   [ ] Gestion des erreurs
-   [ ] Interface responsive
-   [ ] Performance acceptable

## 📝 Notes de Test

[Espace pour noter les observations durant les tests]

-   Date de test :
-   Navigateur utilisé :
-   Bugs trouvés :
-   Suggestions d'amélioration :
