<?php

namespace Tests\Unit\Admin;

use App\Http\Controllers\Admin\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerLogicTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Vider le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // S'assurer que les rôles existent
        if (! Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin', 'guard_name' => 'web']);
        }

        if (! Role::where('name', 'client')->exists()) {
            Role::create(['name' => 'client', 'guard_name' => 'web']);
        }

        // S'assurer que les permissions existent
        $permissions = ['users.delete', 'users.view', 'users.create', 'users.edit'];

        foreach ($permissions as $permission) {
            if (! Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission, 'guard_name' => 'web']);
            }
        }

        // Assigner les permissions au rôle admin
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && $adminRole->permissions->isEmpty()) {
            $adminRole->givePermissionTo($permissions);
        }
    }

    /** @test */
    public function destroy_method_prevents_self_deletion(): void
    {
        // Créer un admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Simuler une session avec cet utilisateur connecté
        $this->actingAs($admin);

        // Créer le contrôleur
        $controller = new UserController;

        // Appeler la méthode destroy
        $response = $controller->destroy($admin);

        // Vérifier que c'est une redirection
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

        // Vérifier que l'utilisateur existe toujours
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    /** @test */
    public function destroy_method_prevents_last_admin_deletion(): void
    {
        // Créer exactement un admin
        $soleAdmin = User::factory()->create();
        $soleAdmin->assignRole('admin');

        // Créer un autre utilisateur pour faire la requête
        $requester = User::factory()->create();
        $requester->assignRole('admin');

        // Simuler une session avec le requester connecté
        $this->actingAs($requester);

        // S'assurer qu'il y a exactement 2 admins
        $this->assertEquals(2, User::role('admin')->count());

        // Retirer le rôle admin du requester pour qu'il ne reste qu'un admin
        $requester->removeRole('admin');

        // Vérifier qu'il ne reste qu'un admin
        $this->assertEquals(1, User::role('admin')->count());

        // Créer le contrôleur
        $controller = new UserController;

        // Appeler la méthode destroy sur le seul admin restant
        $response = $controller->destroy($soleAdmin);

        // Vérifier que c'est une redirection
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

        // Vérifier que l'utilisateur existe toujours
        $this->assertDatabaseHas('users', ['id' => $soleAdmin->id]);

        // Vérifier qu'il y a toujours exactement 1 admin
        $this->assertEquals(1, User::role('admin')->count());
    }

    /** @test */
    public function destroy_method_allows_normal_user_deletion(): void
    {
        // Créer un admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Créer un utilisateur normal
        $user = User::factory()->create();
        $user->assignRole('client');

        // Simuler une session avec l'admin connecté
        $this->actingAs($admin);

        // Créer le contrôleur
        $controller = new UserController;

        // Appeler la méthode destroy sur l'utilisateur normal
        $response = $controller->destroy($user);

        // Vérifier que c'est une redirection
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

        // Vérifier que l'utilisateur a été supprimé
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
