<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les permissions
        $permissions = [
            // Propriétés
            'properties.view',
            'properties.create',
            'properties.edit',
            'properties.delete',

            // Catégories
            'categories.view',
            'categories.create',
            'categories.edit',
            'categories.delete',

            // Utilisateurs
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Messages
            'messages.view',
            'messages.respond',
            'messages.delete',

            // Applications
            'applications.view',
            'applications.manage',
            'applications.delete',

            // Dashboard
            'dashboard.admin',
            'dashboard.client',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer les rôles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Assigner toutes les permissions à l'admin
        $adminRole->syncPermissions(Permission::all());

        // Assigner des permissions limitées au client
        $clientRole->syncPermissions([
            'applications.view',
            'messages.view',
            'dashboard.client',
        ]);
    }
}
