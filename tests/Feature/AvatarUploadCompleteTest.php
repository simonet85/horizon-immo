<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarUploadCompleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /** @test */
    public function user_can_access_avatar_upload_form()
    {
        $user = User::factory()->create(['name' => 'John Doe']);

        $response = $this->actingAs($user)->get('/profile/edit');

        $response->assertStatus(200);
        $response->assertSeeLivewire('forms.update-avatar-form');
    }

    /** @test */
    public function user_can_upload_avatar_successfully()
    {
        $user = User::factory()->create(['name' => 'Marie-Claire Dubois']);
        $file = UploadedFile::fake()->image('avatar.jpg', 300, 300);

        Livewire::actingAs($user)
            ->test('forms.update-avatar-form')
            ->set('avatar', $file)
            ->call('updateAvatar')
            ->assertHasNoErrors()
            ->assertSessionHas('success', 'Avatar mis à jour avec succès !');

        // Vérifier que le fichier est stocké
        Storage::disk('public')->assertExists('avatars/'.$file->hashName());

        // Vérifier que l'utilisateur a l'avatar mis à jour
        $this->assertNotNull($user->fresh()->avatar);
    }

    /** @test */
    public function avatar_upload_validates_file_type()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        Livewire::actingAs($user)
            ->test('forms.update-avatar-form')
            ->set('avatar', $file)
            ->call('updateAvatar')
            ->assertHasErrors(['avatar']);
    }

    /** @test */
    public function avatar_upload_validates_file_size()
    {
        $user = User::factory()->create();
        // Créer un fichier de plus de 2MB
        $file = UploadedFile::fake()->image('large-avatar.jpg')->size(3000);

        Livewire::actingAs($user)
            ->test('forms.update-avatar-form')
            ->set('avatar', $file)
            ->call('updateAvatar')
            ->assertHasErrors(['avatar']);
    }

    /** @test */
    public function user_can_delete_avatar()
    {
        $user = User::factory()->create(['avatar' => 'avatars/test-avatar.jpg']);
        Storage::disk('public')->put('avatars/test-avatar.jpg', 'fake-content');

        Livewire::actingAs($user)
            ->test('forms.update-avatar-form')
            ->call('deleteAvatar')
            ->assertSessionHas('success', 'Avatar supprimé avec succès !');

        // Vérifier que le fichier est supprimé
        Storage::disk('public')->assertMissing('avatars/test-avatar.jpg');

        // Vérifier que l'avatar de l'utilisateur est null
        $this->assertNull($user->fresh()->avatar);
    }

    /** @test */
    public function avatar_preview_shows_when_file_selected()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $component = Livewire::actingAs($user)
            ->test('forms.update-avatar-form')
            ->set('avatar', $file);

        // Vérifier que temporaryUrl est défini
        $this->assertNotNull($component->get('temporaryUrl'));
    }

    /** @test */
    public function initials_extraction_works_correctly()
    {
        $user = User::factory()->create(['name' => 'Jean-Claude Van Damme']);

        $component = Livewire::actingAs($user)
            ->test('forms.update-avatar-form');

        $initials = $component->instance()->getUserInitials();
        $this->assertEquals('JCVD', $initials);
    }

    /** @test */
    public function initials_extraction_handles_edge_cases()
    {
        $testCases = [
            'Marie-Claire Dubois' => 'MCD',
            'Jean Dupont' => 'JD',
            'Anna' => 'A',
            '' => 'U',
            '   ' => 'U',
            'Pierre De La Fontaine' => 'PDLF',
            'A B C D E' => 'ABCDE',
        ];

        foreach ($testCases as $name => $expectedInitials) {
            $user = User::factory()->create(['name' => $name]);

            $component = Livewire::actingAs($user)
                ->test('forms.update-avatar-form');

            $initials = $component->instance()->getUserInitials();
            $this->assertEquals($expectedInitials, $initials, "Failed for name: '$name'");
        }
    }

    /** @test */
    public function component_emits_avatar_updated_event()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        Livewire::actingAs($user)
            ->test('forms.update-avatar-form')
            ->set('avatar', $file)
            ->call('updateAvatar')
            ->assertDispatched('avatar-updated');
    }

    /** @test */
    public function old_avatar_is_deleted_when_new_one_uploaded()
    {
        $user = User::factory()->create(['avatar' => 'avatars/old-avatar.jpg']);
        Storage::disk('public')->put('avatars/old-avatar.jpg', 'old-content');

        $newFile = UploadedFile::fake()->image('new-avatar.jpg');

        Livewire::actingAs($user)
            ->test('forms.update-avatar-form')
            ->set('avatar', $newFile)
            ->call('updateAvatar');

        // Vérifier que l'ancien fichier est supprimé
        Storage::disk('public')->assertMissing('avatars/old-avatar.jpg');

        // Vérifier que le nouveau fichier existe
        Storage::disk('public')->assertExists('avatars/'.$newFile->hashName());
    }
}
