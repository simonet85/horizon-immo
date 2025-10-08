<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Vider le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les rôles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'client', 'guard_name' => 'web']);

        // Créer des permissions
        $permissions = [
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'properties.view', 'properties.create', 'properties.edit', 'properties.delete',
            'dashboard.admin',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assigner toutes les permissions au rôle admin
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo($permissions);
    }

    /** @test */
    public function admin_cannot_delete_themselves(): void
    {
        // Créer un admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Se connecter en tant qu'admin
        $this->actingAs($admin);

        // Tenter de se supprimer
        $response = $this->delete(route('admin.users.destroy', $admin));

        // Vérifier que la suppression est refusée
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'Vous ne pouvez pas supprimer votre propre compte.');

        // Vérifier que l'admin existe toujours
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    /** @test */
    public function cannot_delete_last_admin(): void
    {
        // Créer un seul admin dans le système
        $soleAdmin = User::factory()->create();
        $soleAdmin->assignRole('admin');

        // Se connecter en tant que cet admin (pour pouvoir faire la requête)
        $this->actingAs($soleAdmin);

        // Vérifier qu'il n'y a qu'un seul admin
        $this->assertEquals(1, User::role('admin')->count());

        // Tenter de supprimer le seul admin
        $response = $this->delete(route('admin.users.destroy', $soleAdmin));

        // Vérifier que la suppression est refusée avec redirection
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'Vous ne pouvez pas supprimer le dernier administrateur du système.');

        // Vérifier que l'admin existe toujours
        $this->assertDatabaseHas('users', ['id' => $soleAdmin->id]);

        // Vérifier qu'il y a toujours exactement 1 admin
        $this->assertEquals(1, User::role('admin')->count());
    }

    /** @test */
    public function admin_can_delete_client_users(): void
    {
        // Créer un admin et un client
        $admin = User::factory()->create();
        $client = User::factory()->create();
        $admin->assignRole('admin');
        $client->assignRole('client');

        // Se connecter en tant qu'admin
        $this->actingAs($admin);

        // Supprimer le client
        $response = $this->delete(route('admin.users.destroy', $client));

        // Vérifier que la suppression réussit
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Utilisateur supprimé avec succès.');

        // Vérifier que le client est supprimé
        $this->assertDatabaseMissing('users', ['id' => $client->id]);
    }

    /** @test */
    public function admin_can_delete_other_admins_when_multiple_exist(): void
    {
        // Créer trois admins
        $admin1 = User::factory()->create();
        $admin2 = User::factory()->create();
        $admin3 = User::factory()->create();
        $admin1->assignRole('admin');
        $admin2->assignRole('admin');
        $admin3->assignRole('admin');

        // Se connecter en tant qu'admin1
        $this->actingAs($admin1);

        // Supprimer admin2 (doit réussir car il y a plusieurs admins)
        $response = $this->delete(route('admin.users.destroy', $admin2));

        // Vérifier que la suppression réussit
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Utilisateur supprimé avec succès.');

        // Vérifier que admin2 est supprimé
        $this->assertDatabaseMissing('users', ['id' => $admin2->id]);

        // Vérifier qu'il reste encore des admins
        $this->assertEquals(2, User::role('admin')->count());
    }
}
