<?php

namespace Tests\Feature\Admin;

use App\Models\ContactContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ContactContentTest extends TestCase
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

    public function test_admin_can_update_contact_header(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $data = [
            'title' => 'Nouveau Titre Contact',
            'description' => 'Nouvelle description pour la page de contact',
        ];

        $response = $this->actingAs($admin)->put(route('admin.home-content.update-contact-header'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_contents', [
            'section' => 'header',
            'key' => 'title',
            'value' => 'Nouveau Titre Contact',
        ]);

        $this->assertDatabaseHas('contact_contents', [
            'section' => 'header',
            'key' => 'description',
            'value' => 'Nouvelle description pour la page de contact',
        ]);
    }

    public function test_admin_can_update_contact_form(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $data = [
            'section_title' => 'Nouveau titre formulaire',
            'subtitle' => 'Nouveau sous-titre',
            'label_prenom' => 'Prénom',
            'label_nom' => 'Nom de famille',
            'label_email' => 'Adresse email',
            'label_telephone' => 'Numéro de téléphone',
            'label_sujet' => 'Objet du message',
            'label_message' => 'Votre message',
            'button_text' => 'Envoyer maintenant',
        ];

        $response = $this->actingAs($admin)->put(route('admin.home-content.update-contact-form'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_contents', [
            'section' => 'form',
            'key' => 'section_title',
            'value' => 'Nouveau titre formulaire',
        ]);
    }

    public function test_admin_can_update_contact_info(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $data = [
            'section_title' => 'Nos Coordonnées',
            'address_label' => 'Notre Adresse',
            'address_line1' => '456 Rue Test',
            'address_line2' => '75002 Paris, France',
            'phone_label' => 'Nos Téléphones',
            'phone_france' => '+33 1 11 22 33 44',
            'phone_south_africa' => '+27 111 222 333',
            'email_label' => 'Nos Emails',
            'email_contact' => 'nouveau@test.com',
            'email_rh' => 'rh@test.com',
            'hours_label' => 'Nos Horaires',
            'hours_weekdays' => 'Du lundi au vendredi: 8h-19h',
            'hours_saturday' => 'Samedi: 8h-12h',
            'hours_sunday' => 'Dimanche: Fermé',
        ];

        $response = $this->actingAs($admin)->put(route('admin.home-content.update-contact-info'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_contents', [
            'section' => 'contact_info',
            'key' => 'email_contact',
            'value' => 'nouveau@test.com',
        ]);
    }

    public function test_contact_content_model_methods(): void
    {
        // Tester la méthode getBySection
        ContactContent::create([
            'section' => 'test_section',
            'key' => 'test_key',
            'value' => 'test_value',
            'is_active' => true,
            'order' => 1,
        ]);

        $result = ContactContent::getBySection('test_section');
        $this->assertEquals(['test_key' => 'test_value'], $result);

        // Tester la méthode updateSection
        ContactContent::updateSection('test_section', [
            'new_key' => 'new_value',
            'test_key' => 'updated_value',
        ]);

        $updated = ContactContent::getBySection('test_section');
        $this->assertEquals('updated_value', $updated['test_key']);
        $this->assertEquals('new_value', $updated['new_key']);
    }
}
