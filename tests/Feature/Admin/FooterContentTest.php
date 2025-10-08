<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FooterContentTest extends TestCase
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
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_can_update_footer_company_information(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $data = [
            'company_name' => 'Test Company',
            'company_description' => 'Test Description',
            'certification_1' => 'Test Cert 1',
            'certification_2' => 'Test Cert 2',
        ];

        $response = $this->actingAs($admin)->put(route('admin.home-content.update-footer-company'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('footer_contents', [
            'section' => 'company',
            'key' => 'company_name',
            'value' => 'Test Company',
        ]);
    }

    public function test_admin_can_update_footer_contact_information(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $data = [
            'email' => 'test@test.com',
            'phone_france' => '+33 1 23 45 67 89',
            'phone_south_africa' => '+27 123 456 789',
            'address' => 'Test Address',
            'hours_weekdays' => 'Lun-Ven: 9h-18h',
            'hours_saturday' => 'Sam: 9h-13h',
            'hours_sunday' => 'Fermé',
        ];

        $response = $this->actingAs($admin)->put(route('admin.home-content.update-footer-contact'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('footer_contents', [
            'section' => 'contact',
            'key' => 'email',
            'value' => 'test@test.com',
        ]);
    }
}
