<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePageAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_loads_with_avatar_component(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile/edit');

        $response->assertStatus(200)
            ->assertSeeLivewire('profile.update-avatar-form')
            ->assertSee('Photo de profil')
            ->assertSee('Ajouter une photo')
            ->assertSee('Formats acceptés : JPG, PNG, GIF')
            ->assertSee('Taille max : 2 MB');
    }

    public function test_profile_page_shows_current_avatar_when_exists(): void
    {
        $user = User::factory()->create([
            'avatar' => 'avatars/test-avatar.jpg',
        ]);

        // Créer un fichier factice pour le test
        \Storage::disk('public')->put('avatars/test-avatar.jpg', 'fake-image-content');

        $response = $this->actingAs($user)->get('/profile/edit');

        $response->assertStatus(200)
            ->assertSee('Avatar actuel')
            ->assertSee('Changer la photo');
    }

    public function test_profile_page_shows_initials_when_no_avatar(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Smith',
            'avatar' => null,
        ]);

        $response = $this->actingAs($user)->get('/profile/edit');

        $response->assertStatus(200)
            ->assertSee('JS'); // Initiales
    }

    public function test_profile_page_has_upload_instructions(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile/edit');

        $response->assertStatus(200)
            ->assertSee('Conseils pour une photo parfaite')
            ->assertSee('Utilisez une photo récente et claire')
            ->assertSee('Évitez les photos floues')
            ->assertSee('Formats recommandés : JPG ou PNG');
    }
}
