<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileButtonTest extends TestCase
{
    use RefreshDatabase;

    public function test_upload_button_is_visible_on_profile_page(): void
    {
        $user = User::factory()->create(['avatar' => null]);

        $response = $this->actingAs($user)->get('/profile/edit');

        $response->assertOk()
            ->assertSee('Ajouter une photo')
            ->assertSee('Parcourir mes fichiers')
            ->assertSee('wire:model="avatar"', false)
            ->assertSee('accept="image/*"', false);
    }

    public function test_delete_button_is_visible_when_avatar_exists(): void
    {
        $user = User::factory()->create(['avatar' => 'avatars/test.jpg']);

        $response = $this->actingAs($user)->get('/profile/edit');

        $response->assertOk()
            ->assertSee('Ajouter une photo')
            ->assertSee('Supprimer la photo');
    }

    public function test_upload_functionality_shows_update_button(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile/edit');

        // Vérifier que les éléments nécessaires pour l'upload sont présents
        $response->assertSee('wire:click="updateAvatar"', false)
            ->assertSee('Mettre à jour l\'avatar');
    }
}
