<?php

/**
 * Script temporaire pour vider les caches Laravel sur LWS
 * À uploader dans /htdocs/ et accéder via https://votre-domaine.com/clear-cache-lws.php
 * ⚠️ SUPPRIMER CE FICHIER APRÈS UTILISATION !
 */

// Charger l'application Laravel
require __DIR__.'/../home/laravel-app/vendor/autoload.php';

$app = require_once __DIR__.'/../home/laravel-app/bootstrap/app.php';

// Démarrer l'application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '<h1>Vidage des caches Laravel</h1>';
echo '<pre>';

try {
    // Vider le cache de configuration
    Artisan::call('config:clear');
    echo "✅ Cache de configuration vidé\n";

    // Vider le cache des routes
    Artisan::call('route:clear');
    echo "✅ Cache des routes vidé\n";

    // Vider le cache des vues
    Artisan::call('view:clear');
    echo "✅ Cache des vues vidé\n";

    // Vider le cache de l'application
    Artisan::call('cache:clear');
    echo "✅ Cache de l'application vidé\n";

    // Vider le cache des événements
    Artisan::call('event:clear');
    echo "✅ Cache des événements vidé\n";

    echo "\n🎉 Tous les caches ont été vidés avec succès !\n";
    echo "\n⚠️ IMPORTANT : Supprimez ce fichier maintenant pour des raisons de sécurité !\n";

} catch (Exception $e) {
    echo '❌ Erreur : '.$e->getMessage()."\n";
}

echo '</pre>';
