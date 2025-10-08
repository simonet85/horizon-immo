<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_avatar_system_integration(): void
    {
        // Créer un utilisateur avec un nom complet pour tester les initiales
        $user = User::factory()->create([
            'name' => 'Marie Dupont',
            'avatar' => null,
        ]);

        // Test 1: Vérifier l'affichage initial (initiales)
        $response = $this->actingAs($user)->get('/profile/edit');
        $response->assertStatus(200)
            ->assertSee('MD'); // Initiales

        // Test 2: Upload d'avatar via Livewire
        $file = UploadedFile::fake()->image('marie-avatar.jpg', 600, 600)->size(1200);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file)
            ->call('updateAvatar');

        $component->assertHasNoErrors();

        // Vérifier en base de données
        $user->refresh();
        $this->assertNotNull($user->avatar);
        Storage::disk('public')->assertExists($user->avatar);

        // Test 3: Vérifier l'affichage avec avatar
        $newResponse = $this->actingAs($user)->get('/profile/edit');
        $newResponse->assertStatus(200)
            ->assertSee('Avatar actuel')
            ->assertSee('Supprimer l\'avatar');

        // Test 4: Vérifier l'affichage dans la navigation
        $dashboardResponse = $this->actingAs($user)->get('/dashboard');
        $dashboardResponse->assertStatus(200)
            ->assertSee(Storage::url($user->avatar), false);

        // Test 5: Suppression d'avatar
        $avatarPath = $user->avatar;

        $deleteComponent = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->call('deleteAvatar');

        // Vérifier la suppression
        $user->refresh();
        $this->assertNull($user->avatar);
        Storage::disk('public')->assertMissing($avatarPath);

        // Test 6: Vérifier le retour aux initiales après suppression
        $finalResponse = $this->actingAs($user)->get('/profile/edit');
        $finalResponse->assertStatus(200)
            ->assertSee('MD') // Retour aux initiales
            ->assertSee('Ajouter une photo');
    }

    public function test_avatar_preview_functionality(): void
    {
        $user = User::factory()->create();

        // Créer un fichier test avec des métadonnées spécifiques
        $file = UploadedFile::fake()->image('preview-test.png', 400, 300)->size(850);

        $component = Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $file);

        // Vérifier que l'aperçu s'affiche avec les bonnes informations
        $component->assertSee('Aperçu de votre nouvelle photo')
            ->assertSee('preview-test.png')
            ->assertSee('0.8 KB') // Taille formatée
            ->assertSee('PNG'); // Type de fichier
    }

    public function test_avatar_validation_comprehensive(): void
    {
        $user = User::factory()->create();

        // Test validation taille
        $largeFile = UploadedFile::fake()->image('large.jpg', 2000, 2000)->size(3000);

        Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $largeFile)
            ->assertHasErrors('avatar');

        // Test validation type
        $wrongType = UploadedFile::fake()->create('document.txt', 100);

        Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $wrongType)
            ->assertHasErrors('avatar');

        // Test fichier valide
        $validFile = UploadedFile::fake()->image('valid.jpg', 400, 400)->size(1000);

        Livewire::actingAs($user)
            ->test('profile.update-avatar-form')
            ->set('avatar', $validFile)
            ->assertHasNoErrors();
    }

    public function test_initials_extraction_algorithm(): void
    {
        // Test différents formats de noms
        $testCases = [
            'Jean' => 'J',
            'Jean Paul' => 'JP',
            'Marie-Claire Dubois' => 'MCD',
            'José Miguel Santos Silva' => 'JMSS',
            'A B C D E' => 'ABCDE',
            '' => 'U', // Cas limite
            '   ' => 'U', // Espaces uniquement
        ];

        foreach ($testCases as $name => $expectedInitials) {
            $user = User::factory()->create(['name' => $name, 'avatar' => null]);

            $response = $this->actingAs($user)->get('/profile/edit');

            if ($expectedInitials !== 'U') {
                $response->assertSee($expectedInitials);
            }
        }
    }
}
