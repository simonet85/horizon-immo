<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\NewContactMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester l\'envoi d\'emails via Mailtrap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Test d\'envoi d\'email avec Mailtrap...');

        // Créer un message de test
        $testMessage = ContactMessage::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'phone' => '+27 123 456 789',
            'subject' => 'Test d\'envoi d\'email',
            'message' => 'Ceci est un message de test pour vérifier la configuration des emails avec Mailtrap.',
        ]);

        // Envoyer notification aux admins
        $admins = User::role('admin')->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new NewContactMessage($testMessage));
            $this->info('Email envoyé à '.$admins->count().' admin(s)');

            foreach ($admins as $admin) {
                $this->line('- '.$admin->email);
            }
        } else {
            $this->error('Aucun admin trouvé !');
        }

        $this->info('Message de test créé avec l\'ID: '.$testMessage->id);
        $this->info('Vérifiez votre boîte Mailtrap pour voir l\'email.');

        return 0;
    }
}
