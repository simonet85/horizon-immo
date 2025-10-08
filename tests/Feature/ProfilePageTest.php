<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_edit_page_displays_correctly(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile/edit');

        $response->assertOk()
            ->assertSee('Photo de profil')
            ->assertSee('Informations du profil')
            ->assertSee('Modifier le mot de passe')
            ->assertSee('Supprimer le compte');
    }

    public function test_profile_page_displays_correctly(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertOk()
            ->assertSee('Avatar')
            ->assertSee('Informations du profil')
            ->assertSee('Modifier le mot de passe')
            ->assertSee('Supprimer le compte');
    }

    public function test_avatar_upload_form_has_proper_buttons(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile/edit');

        // Vérifier que le formulaire d'upload contient les éléments nécessaires
        $response->assertSee('wire:model="avatar"', false)
            ->assertSee('Télécharger un nouvel avatar')
            ->assertSee('accept="image/*"', false);
    }
}
