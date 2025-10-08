<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarPreviewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_avatar_preview_shows_on_file_selection(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400)->size(1000);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file);

        // Vérifier que l'aperçu apparaît
        $component->assertSee('Aperçu de votre nouvelle photo')
            ->assertSee('Cette photo remplacera votre avatar actuel')
            ->assertSee('avatar.jpg')
            ->assertSee('1000 KB'); // Taille du fichier
    }

    public function test_avatar_preview_can_be_cancelled(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400)->size(1000);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file);

        // Vérifier que l'aperçu est là
        $component->assertSee('Aperçu de votre nouvelle photo');

        // Annuler la sélection
        $component->call('$set', 'avatar', null);

        // Vérifier que l'aperçu a disparu
        $component->assertDontSee('Aperçu de votre nouvelle photo');
    }

    public function test_current_avatar_is_displayed(): void
    {
        // Créer un avatar existant
        $file = UploadedFile::fake()->image('existing.jpg', 300, 300);
        $avatarPath = $file->store('avatars', 'public');

        $user = User::factory()->create([
            'avatar' => $avatarPath,
        ]);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form');

        // Vérifier que l'avatar actuel est affiché
        $component->assertSee('Avatar actuel')
            ->assertSee('Changer la photo');
    }

    public function test_no_avatar_shows_initials(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'avatar' => null,
        ]);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form');

        // Vérifier que les initiales sont affichées
        $component->assertSee('JD'); // Initiales
    }

    public function test_file_validation_messages_are_displayed(): void
    {
        $user = User::factory()->create();

        // Test avec un fichier trop volumineux
        $largeFile = UploadedFile::fake()->image('large.jpg', 2000, 2000)->size(3072);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $largeFile);

        $component->assertHasErrors('avatar');
    }

    public function test_temporary_url_works_for_preview(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400)->size(1000);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file);

        // Vérifier que temporaryUrl() peut être appelé pour l'aperçu
        $component->assertStatus(200);

        // Le fichier temporaire doit être accessible
        $this->assertTrue($component->get('avatar') !== null);
    }
}
