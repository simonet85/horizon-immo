<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_avatar_upload_component_loads(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/profile/edit');

        $response->assertStatus(200)
            ->assertSeeLivewire('profile.update-avatar-form');
    }

    public function test_user_can_upload_avatar_successfully(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400)->size(1000);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file);

        // Vérifier que le fichier est bien défini
        $component->assertSet('avatar', function ($avatar) {
            return $avatar !== null;
        });

        // Maintenant soumettre le formulaire
        $component->call('updateAvatar')
            ->assertHasNoErrors();

        // Vérifier que l'avatar a été sauvegardé
        $user->refresh();
        $this->assertNotNull($user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
    }

    public function test_avatar_preview_works(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400)->size(1000);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file);

        // Vérifier que l'aperçu est disponible
        $component->assertSee('Aperçu de votre nouvelle photo');
    }

    public function test_avatar_validation_file_size(): void
    {
        $user = User::factory()->create();

        // Fichier trop volumineux (3MB)
        $file = UploadedFile::fake()->image('avatar.jpg', 1000, 1000)->size(3072);

        Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file)
            ->assertHasErrors('avatar');
    }

    public function test_avatar_validation_file_type(): void
    {
        $user = User::factory()->create();

        // Mauvais type de fichier
        $file = UploadedFile::fake()->create('document.pdf', 100);

        Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file)
            ->assertHasErrors('avatar');
    }

    public function test_user_can_delete_avatar(): void
    {
        $user = User::factory()->create();

        // D'abord, uploader un avatar
        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400)->size(1000);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file)
            ->call('updateAvatar');

        $user->refresh();
        $avatarPath = $user->avatar;
        $this->assertNotNull($avatarPath);

        // Maintenant le supprimer
        $component->call('deleteAvatar');

        $user->refresh();
        $this->assertNull($user->avatar);
        Storage::disk('public')->assertMissing($avatarPath);
    }

    public function test_avatar_updates_in_navigation(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'avatar' => null,
        ]);

        // Test sans avatar - doit afficher les initiales
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertSee('JD');

        // Ajouter un avatar
        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400)->size(1000);
        $avatarPath = $file->store('avatars', 'public');
        $user->update(['avatar' => $avatarPath]);

        // Test avec avatar - doit afficher l'image
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertSee(Storage::url($avatarPath), false);
    }
}
