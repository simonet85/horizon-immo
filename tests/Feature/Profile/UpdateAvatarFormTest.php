<?php

namespace Tests\Feature\Profile;

use App\Livewire\Profile\UpdateAvatarForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateAvatarFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_user_can_upload_avatar()
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400)->size(500);

        Livewire::actingAs($user)
            ->test(UpdateAvatarForm::class)
            ->set('avatar', $file)
            ->call('updateAvatar')
            ->assertHasNoErrors()
            ->assertSet('avatar', null);

        $user->refresh();
        $this->assertNotNull($user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
    }

    public function test_avatar_upload_validation()
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('document.pdf', 1000);

        Livewire::actingAs($user)
            ->test(UpdateAvatarForm::class)
            ->set('avatar', $file)
            ->assertHasErrors(['avatar']);
    }

    public function test_user_can_delete_avatar()
    {
        $user = User::factory()->create(['avatar' => 'avatars/test.jpg']);
        Storage::disk('public')->put('avatars/test.jpg', 'fake-image-content');

        Livewire::actingAs($user)
            ->test(UpdateAvatarForm::class)
            ->call('deleteAvatar');

        $user->refresh();
        $this->assertNull($user->avatar);
        Storage::disk('public')->assertMissing('avatars/test.jpg');
    }
}
