<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== Vérification des permissions pour admin@horizonimmo.com ===\n\n";

$user = User::where('email', 'admin@horizonimmo.com')->first();

if (!$user) {
    echo "❌ Utilisateur non trouvé!\n";
    exit;
}

echo "✅ Utilisateur trouvé: {$user->name}\n";
echo "📧 Email: {$user->email}\n\n";

echo "🎭 Rôles actuels:\n";
$roles = $user->getRoleNames();
if ($roles->count() > 0) {
    foreach ($roles as $role) {
        echo "  - {$role}\n";
    }
} else {
    echo "  ⚠️ Aucun rôle assigné\n";
}

echo "\n🔑 Permissions actuelles:\n";
$permissions = $user->getAllPermissions();
if ($permissions->count() > 0) {
    foreach ($permissions as $permission) {
        echo "  - {$permission->name}\n";
    }
} else {
    echo "  ⚠️ Aucune permission\n";
}

echo "\n🔍 Permission 'content.manage': ";
if ($user->can('content.manage')) {
    echo "✅ OUI\n";
} else {
    echo "❌ NON\n";

    // Créer la permission si elle n'existe pas
    $contentPermission = Permission::firstOrCreate(['name' => 'content.manage']);

    // Donner la permission à l'utilisateur
    $user->givePermissionTo('content.manage');

    echo "\n✅ Permission 'content.manage' ajoutée!\n";
}

echo "\n=== Vérification terminée ===\n";
