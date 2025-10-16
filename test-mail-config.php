<?php

// Test direct de la configuration email
require __DIR__.'/vendor/autoload.php';

// Charger le .env manuellement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== Configuration Email depuis .env ===\n";
echo 'MAIL_HOST: '.getenv('MAIL_HOST')."\n";
echo 'MAIL_PORT: '.getenv('MAIL_PORT')."\n";
echo 'MAIL_USERNAME: '.getenv('MAIL_USERNAME')."\n";
echo 'MAIL_ENCRYPTION: '.getenv('MAIL_ENCRYPTION')."\n";
echo 'MAIL_FROM_ADDRESS: '.getenv('MAIL_FROM_ADDRESS')."\n";
echo "\n";

// Charger Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Configuration Email depuis Laravel Config ===\n";
echo 'mail.mailers.smtp.host: '.config('mail.mailers.smtp.host')."\n";
echo 'mail.mailers.smtp.port: '.config('mail.mailers.smtp.port')."\n";
echo 'mail.mailers.smtp.username: '.config('mail.mailers.smtp.username')."\n";
echo 'mail.mailers.smtp.encryption: '.config('mail.mailers.smtp.encryption')."\n";
echo 'mail.from.address: '.config('mail.from.address')."\n";
