<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_complete_avatar_upload_workflow(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
        ]);

        // Étape 1: Vérifier l'état initial (sans avatar)
        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form');

        $component->assertSee('TU') // Initiales
            ->assertSee('Ajouter une photo')
            ->assertDontSee('Avatar actuel');

        // Étape 2: Sélectionner un fichier
        $file = UploadedFile::fake()->image('new-avatar.jpg', 400, 400)->size(1500);

        $component->set('avatar', $file);

        // Vérifier que l'aperçu apparaît
        $component->assertSee('Aperçu de votre nouvelle photo')
            ->assertSee('new-avatar.jpg')
            ->assertSee('1.5 KB') // Taille
            ->assertSee('Mettre à jour l\'avatar');

        // Étape 3: Sauvegarder l'avatar
        $component->call('updateAvatar');

        // Vérifier que c'est sauvegardé
        $component->assertHasNoErrors()
            ->assertSet('avatar', null); // Le fichier temporaire est effacé

        // Vérifier en base de données
        $user->refresh();
        $this->assertNotNull($user->avatar);
        $this->assertStringStartsWith('avatars/', $user->avatar);
        Storage::disk('public')->assertExists($user->avatar);

        // Étape 4: Vérifier l'affichage après upload
        $newComponent = Livewire::actingAs($user)
            ->test('profile.update-avatar-form');

        $newComponent->assertSee('Avatar actuel')
            ->assertSee('Changer la photo')
            ->assertSee('Supprimer l\'avatar');

        // Étape 5: Supprimer l'avatar
        $avatarPath = $user->avatar;
        $newComponent->call('deleteAvatar');

        // Vérifier la suppression
        $user->refresh();
        $this->assertNull($user->avatar);
        Storage::disk('public')->assertMissing($avatarPath);

        // Vérifier l'affichage après suppression
        $finalComponent = Livewire::actingAs($user)
            ->test('profile.update-avatar-form');

        $finalComponent->assertSee('TU') // Retour aux initiales
            ->assertSee('Ajouter une photo')
            ->assertDontSee('Avatar actuel');
    }

    public function test_avatar_file_size_validation_workflow(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form');

        // Test avec un fichier trop volumineux
        $largeFile = UploadedFile::fake()->image('large.jpg', 2000, 2000)->size(3072);

        $component->set('avatar', $largeFile);

        // Vérifier que la validation échoue
        $component->assertHasErrors('avatar');

        // Vérifier qu'aucun fichier n'est sauvegardé
        $user->refresh();
        $this->assertNull($user->avatar);
    }

    public function test_avatar_file_type_validation_workflow(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form');

        // Test avec un mauvais type de fichier
        $badFile = UploadedFile::fake()->create('document.pdf', 100);

        $component->set('avatar', $badFile);

        // Vérifier que la validation échoue
        $component->assertHasErrors('avatar');

        // Vérifier qu'aucun fichier n'est sauvegardé
        $user->refresh();
        $this->assertNull($user->avatar);
    }
}
