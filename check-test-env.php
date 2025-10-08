<?php

/**
 * Script de vérification de la séparation des environnements
 *
 * Ce script vérifie que les tests utilisent bien une base de données séparée
 * et que les données de production sont protégées.
 */

// Vérification de l'environnement de production
echo "=== ENVIRONNEMENT DE PRODUCTION ===\n";
echo 'Base de données: '.env('DB_DATABASE')."\n";
echo 'Host: '.env('DB_HOST')."\n";
echo 'Utilisateur: '.env('DB_USERNAME')."\n\n";

// Vérification de l'environnement de test
echo "=== ENVIRONNEMENT DE TEST ===\n";
$testEnv = parse_ini_file('.env.testing');
echo 'Base de données: '.$testEnv['DB_DATABASE']."\n";
echo 'Host: '.$testEnv['DB_HOST']."\n";
echo 'Utilisateur: '.$testEnv['DB_USERNAME']."\n\n";

// Vérification que les bases sont différentes
if (env('DB_DATABASE') !== $testEnv['DB_DATABASE']) {
    echo "✅ SÉCURISÉ: Les bases de données sont séparées\n";
    echo '   Production: '.env('DB_DATABASE')."\n";
    echo '   Test: '.$testEnv['DB_DATABASE']."\n";
} else {
    echo "❌ ATTENTION: Les bases de données sont identiques!\n";
    echo "   Risque pour les données de production.\n";
}

echo "\n=== COMMANDES UTILES ===\n";
echo "Tester sans risque: php artisan test\n";
echo "Vérifier config test: php artisan config:show database --env=testing\n";
echo "Effacer cache test: php artisan config:clear --env=testing\n";
