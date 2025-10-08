<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class FrenchTranslationTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_forms_are_displayed_in_french(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        // Vérifier les traductions françaises
        $response->assertSee('Informations du profil');
        $response->assertSee('Modifier le mot de passe');
        $response->assertSee('Supprimer le compte');
        $response->assertSee('Avatar');
        $response->assertSee('Enregistrer');
    }

    public function test_profile_information_form_uses_french_labels(): void
    {
        $user = User::factory()->create();

        Volt::actingAs($user)
            ->test('profile.update-profile-information-form')
            ->assertSee('Informations du profil')
            ->assertSee('Nom')
            ->assertSee('E-mail')
            ->assertSee('Enregistrer');
    }

    public function test_password_form_uses_french_labels(): void
    {
        $user = User::factory()->create();

        Volt::actingAs($user)
            ->test('profile.update-password-form')
            ->assertSee('Modifier le mot de passe')
            ->assertSee('Mot de passe actuel')
            ->assertSee('Nouveau mot de passe')
            ->assertSee('Confirmer le mot de passe')
            ->assertSee('Conseils de sécurité');
    }

    public function test_delete_account_form_uses_french_labels(): void
    {
        $user = User::factory()->create();

        Volt::actingAs($user)
            ->test('profile.delete-user-form')
            ->assertSee('Supprimer le compte')
            ->assertSee('Action irréversible');
    }
}
