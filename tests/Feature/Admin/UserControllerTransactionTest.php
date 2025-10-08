<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTransactionTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Vider le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // S'assurer que les rôles existent (les créer seulement s'ils n'existent pas)
        if (! Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin', 'guard_name' => 'web']);
        }

        if (! Role::where('name', 'client')->exists()) {
            Role::create(['name' => 'client', 'guard_name' => 'web']);
        }

        // S'assurer que les permissions existent
        $permissions = [
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'properties.view', 'properties.create', 'properties.edit', 'properties.delete',
            'dashboard.admin',
        ];

        foreach ($permissions as $permission) {
            if (! Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission, 'guard_name' => 'web']);
            }
        }

        // Assigner toutes les permissions au rôle admin s'il n'en a pas
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && $adminRole->permissions->isEmpty()) {
            $adminRole->givePermissionTo($permissions);
        }
    }

    /** @test */
    public function admin_cannot_delete_themselves(): void
    {
        // Créer un admin temporaire pour le test
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Se connecter en tant qu'admin
        $this->actingAs($admin);

        // Tenter de se supprimer
        $response = $this->delete(route('admin.users.destroy', $admin));

        // Vérifier que la suppression est refusée avec le bon message
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'Vous ne pouvez pas supprimer votre propre compte.');

        // Vérifier que l'admin existe toujours
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    /** @test */
    public function cannot_delete_last_admin(): void
    {
        // S'assurer qu'il n'y a qu'un seul admin dans le système
        // Retirer tous les rôles admin existants
        $existingAdmins = User::role('admin')->get();
        foreach ($existingAdmins as $admin) {
            $admin->removeRole('admin');
        }

        // Créer exactement un admin
        $soleAdmin = User::factory()->create();
        $soleAdmin->assignRole('admin');

        // Créer un autre admin pour faire la requête
        $requestingAdmin = User::factory()->create();
        $requestingAdmin->assignRole('admin');

        // Se connecter en tant que requesting admin
        $this->actingAs($requestingAdmin);

        // Vérifier qu'il y a 2 admins avant le test
        $this->assertEquals(2, User::role('admin')->count());

        // Maintenant supprimer le rôle admin du requesting admin pour qu'il ne reste que soleAdmin
        $requestingAdmin->removeRole('admin');

        // Vérifier qu'il ne reste qu'un seul admin
        $this->assertEquals(1, User::role('admin')->count());

        // Redonner temporairement le rôle admin au requesting user pour qu'il puisse faire la requête
        $requestingAdmin->assignRole('admin');

        // Maintenant il y a 2 admins, mais on va tester la protection quand même
        // en modifiant temporairement la logique via un mock ou en testant directement

        // Test de l'API directement
        $response = $this->delete(route('admin.users.destroy', $soleAdmin));

        // Retirer le rôle admin du requesting admin pour simuler qu'il ne reste qu'un admin
        $requestingAdmin->removeRole('admin');

        // Maintenant tester ce qui se passe quand on essaie de supprimer le dernier
        $this->assertEquals(1, User::role('admin')->count());

        // Simuler la requête via tinker pour éviter les problèmes de permissions
        $result = app(\App\Http\Controllers\Admin\UserController::class)->destroy($soleAdmin);

        // Vérifier que l'admin existe toujours
        $this->assertDatabaseHas('users', ['id' => $soleAdmin->id]);

        // Restaurer les admins existants
        foreach ($existingAdmins as $admin) {
            $admin->assignRole('admin');
        }
    }

    /** @test */
    public function admin_can_delete_other_users(): void
    {
        // Créer un admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Créer un utilisateur client
        $client = User::factory()->create();
        $client->assignRole('client');

        // Se connecter en tant qu'admin
        $this->actingAs($admin);

        // Supprimer le client
        $response = $this->delete(route('admin.users.destroy', $client));

        // Vérifier que la suppression réussit
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Utilisateur supprimé avec succès.');

        // Vérifier que le client n'existe plus
        $this->assertDatabaseMissing('users', ['id' => $client->id]);
    }

    /** @test */
    public function admin_can_delete_other_admin_if_not_last(): void
    {
        // Créer deux admins
        $admin1 = User::factory()->create();
        $admin1->assignRole('admin');

        $admin2 = User::factory()->create();
        $admin2->assignRole('admin');

        // Se connecter en tant que premier admin
        $this->actingAs($admin1);

        // S'assurer qu'il y a au moins 2 admins
        $this->assertGreaterThanOrEqual(2, User::role('admin')->count());

        // Supprimer le deuxième admin
        $response = $this->delete(route('admin.users.destroy', $admin2));

        // Vérifier que la suppression réussit
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Utilisateur supprimé avec succès.');

        // Vérifier que le deuxième admin n'existe plus
        $this->assertDatabaseMissing('users', ['id' => $admin2->id]);

        // Vérifier qu'il reste au moins un admin
        $this->assertGreaterThanOrEqual(1, User::role('admin')->count());
    }
}
