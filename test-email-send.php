<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Test d'envoi d'email via SMTP LWS ===\n\n";

echo "Configuration actuelle :\n";
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n";
echo "MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n\n";

// Test d'envoi
try {
    \Illuminate\Support\Facades\Mail::raw('Ceci est un test d\'envoi via SMTP LWS.', function($message) {
        $message->to('test@example.com')
                ->subject('Test SMTP LWS - ZB Investments');
    });

    echo "✅ Email envoyé avec succès !\n";
    echo "Vérifiez les logs pour confirmer l'envoi via mail.zbinvestments-ci.com\n";
} catch (\Exception $e) {
    echo "❌ Erreur lors de l'envoi : " . $e->getMessage() . "\n";
}
