#!/usr/bin/env php
<?php

/**
 * Script de test pour vérifier la configuration de la queue sur LWS
 *
 * Upload ce fichier dans /home/zbinv2677815/laravel-app/
 * Puis exécuter : php test-queue-lws.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=======================================================\n";
echo "TEST DE CONFIGURATION QUEUE - ZB INVESTMENTS\n";
echo "=======================================================\n\n";

// 1. Vérifier la configuration de la queue
echo "1. Configuration de la queue\n";
echo '   QUEUE_CONNECTION: '.config('queue.default')."\n";
echo '   Driver utilisé: '.config('queue.connections.'.config('queue.default').'.driver')."\n\n";

// 2. Vérifier la connexion à la base de données
echo "2. Connexion base de données\n";
try {
    $pdo = DB::connection()->getPdo();
    echo "   ✅ Connexion DB réussie\n";
    echo '   Base: '.DB::connection()->getDatabaseName()."\n\n";
} catch (\Exception $e) {
    echo '   ❌ Erreur DB: '.$e->getMessage()."\n\n";
    exit(1);
}

// 3. Vérifier que la table jobs existe
echo "3. Table jobs\n";
try {
    $tableExists = DB::getSchemaBuilder()->hasTable('jobs');
    if ($tableExists) {
        echo "   ✅ Table 'jobs' existe\n";

        // Compter les jobs en attente
        $pendingJobs = DB::table('jobs')->count();
        echo '   Jobs en attente: '.$pendingJobs."\n\n";
    } else {
        echo "   ❌ Table 'jobs' n'existe pas\n";
        echo "   Exécuter: php artisan queue:table && php artisan migrate\n\n";
    }
} catch (\Exception $e) {
    echo '   ❌ Erreur: '.$e->getMessage()."\n\n";
}

// 4. Vérifier les jobs échoués
echo "4. Jobs échoués\n";
try {
    $failedJobs = DB::table('failed_jobs')->count();
    echo '   Jobs échoués: '.$failedJobs."\n";

    if ($failedJobs > 0) {
        echo "   ⚠️  Il y a des jobs échoués à vérifier\n";
        echo "   Commande: php artisan queue:failed\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   ❌ Table 'failed_jobs' introuvable\n\n";
}

// 5. Vérifier la configuration email
echo "5. Configuration email (SMTP LWS)\n";
echo '   MAIL_HOST: '.config('mail.mailers.smtp.host')."\n";
echo '   MAIL_PORT: '.config('mail.mailers.smtp.port')."\n";
echo '   MAIL_USERNAME: '.config('mail.mailers.smtp.username')."\n";
echo '   MAIL_ENCRYPTION: '.config('mail.mailers.smtp.encryption')."\n";
echo '   MAIL_FROM: '.config('mail.from.address')."\n\n";

// 6. Vérifier les permissions
echo "6. Permissions des dossiers\n";
$storagePath = storage_path();
$bootstrapCachePath = base_path('bootstrap/cache');

$storagePerms = substr(sprintf('%o', fileperms($storagePath)), -3);
$cachePerms = substr(sprintf('%o', fileperms($bootstrapCachePath)), -3);

echo '   storage/: '.$storagePerms.' '.(is_writable($storagePath) ? '✅ Accessible en écriture' : '❌ Non accessible en écriture')."\n";
echo '   bootstrap/cache/: '.$cachePerms.' '.(is_writable($bootstrapCachePath) ? '✅ Accessible en écriture' : '❌ Non accessible en écriture')."\n\n";

// 7. Test d'envoi d'un job
echo "7. Test d'envoi d'un job dans la queue\n";
try {
    // Créer un job de test simple
    $testJob = function () {
        \Illuminate\Support\Facades\Log::info('Test job exécuté avec succès depuis test-queue-lws.php');
    };

    $jobsBefore = DB::table('jobs')->count();

    // Dispatcher un job simple
    dispatch(function () {
        \Illuminate\Support\Facades\Log::info('✅ Test job exécuté avec succès - LWS Queue');
    })->onQueue('default');

    $jobsAfter = DB::table('jobs')->count();

    if ($jobsAfter > $jobsBefore) {
        echo "   ✅ Job de test créé avec succès\n";
        echo "   Jobs avant: $jobsBefore, Jobs après: $jobsAfter\n";
        echo "   Exécuter: php artisan queue:work --stop-when-empty\n\n";
    } else {
        echo "   ℹ️  Job peut-être traité immédiatement (driver sync ?)\n\n";
    }
} catch (\Exception $e) {
    echo '   ❌ Erreur lors de la création du job: '.$e->getMessage()."\n\n";
}

// 8. Chemin PHP
echo "8. Configuration serveur\n";
echo '   Chemin PHP: '.PHP_BINARY."\n";
echo '   Version PHP: '.PHP_VERSION."\n";
echo '   Chemin Laravel: '.base_path()."\n\n";

// 9. Commande CRON recommandée
echo "=======================================================\n";
echo "COMMANDE CRON RECOMMANDÉE POUR LWS\n";
echo "=======================================================\n\n";

$phpPath = PHP_BINARY;
$laravelPath = base_path();

echo "Fréquence: Toutes les minutes (* * * * *)\n\n";
echo "Commande:\n";
echo "$phpPath $laravelPath/artisan queue:work --stop-when-empty --max-time=50 2>&1\n\n";

echo "=======================================================\n";
echo "RÉSUMÉ\n";
echo "=======================================================\n\n";

$allGood = true;

// Vérifications critiques
$checks = [
    'Base de données accessible' => isset($pdo),
    'Table jobs existe' => isset($tableExists) && $tableExists,
    'Configuration queue correcte' => config('queue.default') === 'database',
    'SMTP configuré (LWS)' => config('mail.mailers.smtp.host') === 'mail.zbinvestments-ci.com',
    'Storage accessible en écriture' => is_writable($storagePath),
];

foreach ($checks as $check => $status) {
    echo ($status ? '✅' : '❌')." $check\n";
    if (! $status) {
        $allGood = false;
    }
}

echo "\n";

if ($allGood) {
    echo "🎉 Tout est prêt ! La queue peut être configurée dans LWS Panel.\n";
} else {
    echo "⚠️  Certaines vérifications ont échoué. Corrigez les problèmes avant de continuer.\n";
}

echo "\n=======================================================\n";
echo "FIN DU TEST\n";
echo "=======================================================\n";
