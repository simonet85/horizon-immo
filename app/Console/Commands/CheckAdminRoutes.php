<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class CheckAdminRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:check-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if all admin routes are properly configured';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des routes administrateur...');
        $this->newLine();

        $adminRoutes = [
            'admin.dashboard' => 'Dashboard Principal',
            'admin.properties.index' => 'Gestion des Propriétés',
            'admin.categories.index' => 'Gestion des Catégories',
            'admin.users.index' => 'Gestion des Utilisateurs',
            'admin.messages.index' => 'Gestion des Messages',
            'admin.applications.index' => 'Gestion des Applications',
        ];

        $clientRoutes = [
            'client.dashboard' => 'Dashboard Client',
            'client.applications.index' => 'Mes Applications',
        ];

        $this->checkRoutes('ROUTES ADMIN', $adminRoutes);
        $this->newLine();
        $this->checkRoutes('ROUTES CLIENT', $clientRoutes);

        $this->newLine();
        $this->info('✅ Vérification terminée !');

        return 0;
    }

    private function checkRoutes(string $section, array $routes)
    {
        $this->line("<fg=yellow>$section</>");
        $this->line(str_repeat('-', strlen($section)));

        foreach ($routes as $routeName => $description) {
            if (Route::has($routeName)) {
                $this->line("  ✅ $description ($routeName)");
            } else {
                $this->line("  ❌ $description ($routeName) - ROUTE MANQUANTE");
            }
        }
    }
}
