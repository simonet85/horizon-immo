<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageBadgeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer les rôles nécessaires pour les tests
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'client']);
    }

    public function test_admin_layout_shows_unread_contact_messages_badge(): void
    {
        // Créer des messages de contact non lus
        ContactMessage::factory()->count(3)->create(['status' => 'unread']);

        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Authentifier l'utilisateur
        auth()->login($admin);

        // Rendre la vue admin layout
        $view = view('layouts.admin');
        $view->render();

        // Vérifier que la variable unreadContactMessagesCount est présente et correcte
        $data = $view->getData();
        $this->assertArrayHasKey('unreadContactMessagesCount', $data);
        $this->assertEquals(3, $data['unreadContactMessagesCount']);

        // Vérifier que la variable est disponible pour toutes les vues admin
        $this->assertArrayHasKey('unreadMessagesCount', $data);
        $this->assertArrayHasKey('pendingApplicationsCount', $data);
    }

    public function test_admin_layout_does_not_show_badge_when_no_unread_contact_messages(): void
    {
        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Créer des messages lus uniquement
        ContactMessage::factory()->count(2)->create(['status' => 'read']);

        // Accéder à la page admin
        $response = $this->actingAs($admin)->get(route('admin.contact-messages.index'));

        // Vérifier que la page se charge
        $response->assertStatus(200);

        // Le badge ne devrait pas s'afficher (vérifié via le HTML)
        $response->assertDontSee('bg-red-500 text-white text-xs px-2 py-1 rounded-full');
    }

    public function test_unread_contact_messages_count_updates_correctly(): void
    {
        // Créer des messages non lus
        $message1 = ContactMessage::factory()->create(['status' => 'unread']);
        $message2 = ContactMessage::factory()->create(['status' => 'unread']);
        $message3 = ContactMessage::factory()->create(['status' => 'read']);

        // Vérifier le comptage
        $this->assertEquals(2, ContactMessage::unread()->count());

        // Marquer un message comme lu
        $message1->update(['status' => 'read']);

        // Vérifier le nouveau comptage
        $this->assertEquals(1, ContactMessage::unread()->count());
    }

    public function test_view_composer_provides_unread_contact_messages_count_to_admin_layout(): void
    {
        // Créer des messages non lus
        ContactMessage::factory()->count(5)->create(['status' => 'unread']);

        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Accéder à une page admin
        auth()->login($admin);

        $view = view('layouts.admin');
        $view->render();

        // Vérifier que la variable est disponible
        $this->assertArrayHasKey('unreadContactMessagesCount', $view->getData());
        $this->assertEquals(5, $view->getData()['unreadContactMessagesCount']);
    }
}
