<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg', 300, 300)->size(1024);

        $this->actingAs($user);

        $component = Livewire::test('profile.update-avatar-form')
            ->set('avatar', $file)
            ->call('updateAvatar');

        $component->assertHasNoErrors();

        $this->assertNotNull($user->fresh()->avatar);
        Storage::disk('public')->assertExists($user->fresh()->avatar);
    }

    public function test_user_can_delete_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user);

        // D'abord uploader un avatar
        $file = UploadedFile::fake()->image('avatar.jpg', 300, 300)->size(1024);

        Livewire::test('profile.update-avatar-form')
            ->set('avatar', $file)
            ->call('updateAvatar');

        $avatarPath = $user->fresh()->avatar;
        $this->assertNotNull($avatarPath);

        // Ensuite le supprimer
        Livewire::test('profile.update-avatar-form')
            ->call('deleteAvatar')
            ->assertHasNoErrors();

        $this->assertNull($user->fresh()->avatar);
        Storage::disk('public')->assertMissing($avatarPath);
    }

    public function test_avatar_upload_validates_file_size(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user);

        // Fichier trop volumineux (3MB)
        $file = UploadedFile::fake()->image('avatar.jpg', 1000, 1000)->size(3072);

        Livewire::test('profile.update-avatar-form')
            ->set('avatar', $file)
            ->assertHasErrors(['avatar']);
    }

    public function test_avatar_upload_validates_file_type(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user);

        // Mauvais type de fichier
        $file = UploadedFile::fake()->create('document.pdf', 100);

        Livewire::test('profile.update-avatar-form')
            ->set('avatar', $file)
            ->assertHasErrors(['avatar']);
    }

    public function test_avatar_is_displayed_in_navigation(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'avatar' => 'avatars/test-avatar.jpg',
        ]);

        // Créer un fichier factice pour le test
        Storage::disk('public')->put('avatars/test-avatar.jpg', 'fake-image-content');

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSee(Storage::url($user->avatar), false);
    }

    public function test_user_initials_are_displayed_when_no_avatar(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'avatar' => null,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSee('JD'); // Initiales du nom
    }
}
