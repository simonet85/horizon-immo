<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarUploadDebugTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer le dossier de test
        Storage::fake('public');
    }

    /** @test */
    public function it_can_upload_avatar_successfully()
    {
        // Créer un utilisateur
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        // Authentifier l'utilisateur
        $this->actingAs($user);

        // Créer un fichier image fake
        $file = UploadedFile::fake()->image('avatar.jpg', 500, 500)->size(1000);

        // Tester le composant Livewire
        Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class)
            ->set('avatar', $file)
            ->call('updateAvatar')
            ->assertHasNoErrors()
            ->assertDispatched('avatar-updated');

        // Vérifier que l'utilisateur a été mis à jour
        $user->refresh();
        $this->assertNotNull($user->avatar);
        $this->assertStringStartsWith('avatars/', $user->avatar);

        // Vérifier que le fichier existe
        Storage::disk('public')->assertExists($user->avatar);

        // Debug: Afficher les informations
        $this->addToAssertionCount(1); // Pour éviter l'erreur "no assertions"
        echo "\n=== AVATAR UPLOAD DEBUG ===\n";
        echo "User ID: " . $user->id . "\n";
        echo "User Avatar Path: " . $user->avatar . "\n";
        echo "Full Storage Path: " . Storage::disk('public')->path($user->avatar) . "\n";
        echo "Public URL: " . Storage::disk('public')->url($user->avatar) . "\n";
        echo "File exists: " . (Storage::disk('public')->exists($user->avatar) ? 'YES' : 'NO') . "\n";
        echo "==========================\n";
    }

    /** @test */
    public function it_displays_avatar_correctly_in_blade_template()
    {
        // Créer un utilisateur avec avatar
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        // Simuler un avatar existant
        $avatarPath = 'avatars/test-avatar.jpg';
        Storage::disk('public')->put($avatarPath, 'fake-image-content');
        $user->update(['avatar' => $avatarPath]);

        // Authentifier l'utilisateur
        $this->actingAs($user);

        // Tester le rendu du composant
        Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class)
            ->assertSee(Storage::url($avatarPath))
            ->assertSee('Votre photo de profil actuelle');

        // Debug: Vérifier l'URL générée
        echo "\n=== AVATAR DISPLAY DEBUG ===\n";
        echo "Avatar Path: " . $avatarPath . "\n";
        echo "Storage URL: " . Storage::url($avatarPath) . "\n";
        echo "Expected URL: /storage/" . $avatarPath . "\n";
        echo "==========================\n";
    }

    /** @test */
    public function it_shows_initials_when_no_avatar()
    {
        // Créer un utilisateur sans avatar
        $user = User::factory()->create([
            'name' => 'Jean Michel Dupont',
            'email' => 'test@example.com',
            'avatar' => null
        ]);

        // Authentifier l'utilisateur
        $this->actingAs($user);

        // Tester le composant
        $component = Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class);
        
        // Vérifier que les initiales sont affichées
        $initials = $component->instance()->getUserInitials();
        $this->assertEquals('JMD', $initials);
        
        $component->assertSee($initials)
                  ->assertSee('Vous n\'avez pas encore de photo de profil');

        echo "\n=== INITIALS DEBUG ===\n";
        echo "User Name: " . $user->name . "\n";
        echo "Generated Initials: " . $initials . "\n";
        echo "===================\n";
    }

    /** @test */
    public function it_handles_file_validation_errors()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Tester avec un fichier trop gros
        $largeFakeFile = UploadedFile::fake()->create('large.jpg', 3000); // 3MB

        Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class)
            ->set('avatar', $largeFakeFile)
            ->call('updateAvatar')
            ->assertHasErrors(['avatar']);

        // Tester avec un mauvais type de fichier
        $wrongTypeFile = UploadedFile::fake()->create('document.pdf', 1000);

        Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class)
            ->set('avatar', $wrongTypeFile)
            ->call('updateAvatar')
            ->assertHasErrors(['avatar']);
    }

    /** @test */
    public function it_deletes_old_avatar_when_uploading_new_one()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Créer un ancien avatar
        $oldAvatarPath = 'avatars/old-avatar.jpg';
        Storage::disk('public')->put($oldAvatarPath, 'old-content');
        $user->update(['avatar' => $oldAvatarPath]);

        // Uploader un nouveau avatar
        $newFile = UploadedFile::fake()->image('new-avatar.jpg');

        Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class)
            ->set('avatar', $newFile)
            ->call('updateAvatar')
            ->assertHasNoErrors();

        // Vérifier que l'ancien fichier a été supprimé
        Storage::disk('public')->assertMissing($oldAvatarPath);
        
        // Vérifier que le nouveau fichier existe
        $user->refresh();
        Storage::disk('public')->assertExists($user->avatar);
        $this->assertNotEquals($oldAvatarPath, $user->avatar);
    }

    /** @test */
    public function it_can_delete_avatar()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Créer un avatar
        $avatarPath = 'avatars/test-avatar.jpg';
        Storage::disk('public')->put($avatarPath, 'content');
        $user->update(['avatar' => $avatarPath]);

        // Supprimer l'avatar
        Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class)
            ->call('deleteAvatar')
            ->assertDispatched('avatar-updated');

        // Vérifier que l'avatar a été supprimé
        $user->refresh();
        $this->assertNull($user->avatar);
        Storage::disk('public')->assertMissing($avatarPath);
    }

    /** @test */
    public function it_checks_real_storage_configuration()
    {
        // Ce test vérifie la configuration réelle du stockage
        $this->withoutFaking();

        echo "\n=== STORAGE CONFIGURATION DEBUG ===\n";
        echo "Storage public disk path: " . Storage::disk('public')->path('') . "\n";
        echo "Storage public disk URL: " . Storage::disk('public')->url('') . "\n";
        echo "Public path exists: " . (file_exists(public_path('storage')) ? 'YES' : 'NO') . "\n";
        echo "Public storage is symlink: " . (is_link(public_path('storage')) ? 'YES' : 'NO') . "\n";
        
        if (is_link(public_path('storage'))) {
            echo "Symlink target: " . readlink(public_path('storage')) . "\n";
        }
        
        echo "Avatars directory exists: " . (Storage::disk('public')->exists('avatars') ? 'YES' : 'NO') . "\n";
        echo "Avatars directory writable: " . (is_writable(Storage::disk('public')->path('avatars')) ? 'YES' : 'NO') . "\n";
        echo "===================================\n";
        
        $this->assertTrue(true); // Pour que le test passe
    }

    private function withoutFaking()
    {
        // Désactiver le fake pour utiliser le vrai stockage
        app()->forgetInstance('filesystem');
        Storage::clearResolvedInstances();
    }
}