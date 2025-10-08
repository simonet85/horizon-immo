<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SimpleAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_avatar_component_loads(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(\App\Livewire\Profile\UpdateAvatarForm::class);

        $component->assertOk();
    }

    public function test_avatar_file_input_works(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(500);

        $component = Livewire::actingAs($user)
            ->test(\App\Livewire\Profile\UpdateAvatarForm::class)
            ->set('avatar', $file);

        $component->assertOk()
            ->assertSet('avatar', function ($avatar) {
                return $avatar !== null;
            });
    }
}
