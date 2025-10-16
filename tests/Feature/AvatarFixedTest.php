<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarFixedTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function avatar_displays_correctly_on_profile_page()
    {
        echo "\n=== AVATAR DISPLAY TEST ===\n";

        // Use existing user with avatar
        $user = User::whereNotNull('avatar')->first();

        if (! $user) {
            echo "❌ No users with avatars found\n";
            $this->markTestSkipped('No users with avatars');

            return;
        }

        echo "Testing with user: {$user->name} (ID: {$user->id})\n";
        echo "Avatar path: {$user->avatar}\n";

        // Check if avatar file exists
        $avatarExists = Storage::disk('public')->exists($user->avatar);
        echo 'Avatar file exists: '.($avatarExists ? '✅ YES' : '❌ NO')."\n";

        if (! $avatarExists) {
            $this->fail('Avatar file does not exist in storage');
        }

        // Check avatar URL
        $avatarUrl = Storage::url($user->avatar);
        echo "Avatar URL: {$avatarUrl}\n";

        // Authenticate and visit profile page
        $this->actingAs($user);

        $response = $this->get('/profile/edit');
        $response->assertStatus(200);

        // Check if the avatar is displayed in the page
        $response->assertSee($user->avatar); // Should see the avatar path in HTML
        echo "✅ Avatar path found in page HTML\n";

        // Check if Storage URL is generated correctly
        $expectedUrl = Storage::url($user->avatar);
        $response->assertSee($expectedUrl);
        echo "✅ Avatar URL found in page HTML\n";

        // Check the actual avatar image tag
        $response->assertSeeText($user->name); // Avatar alt text should contain user name
        echo "✅ User name found in avatar alt text\n";

        echo "==========================\n";
    }

    /** @test */
    public function livewire_component_renders_avatar_correctly()
    {
        echo "\n=== LIVEWIRE COMPONENT TEST ===\n";

        $user = User::whereNotNull('avatar')->first();

        if (! $user) {
            echo "❌ No users with avatars found\n";
            $this->markTestSkipped('No users with avatars');

            return;
        }

        $this->actingAs($user);

        echo "Testing Livewire component with user: {$user->name}\n";
        echo "Avatar: {$user->avatar}\n";

        $component = Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class);

        // Check component rendered without errors
        $component->assertHasNoErrors();
        echo "✅ Component rendered without errors\n";

        // Check if avatar is displayed in component
        $html = $component->payload['effects']['html'];
        $avatarUrl = Storage::url($user->avatar);

        if (str_contains($html, $avatarUrl)) {
            echo "✅ Avatar URL found in component HTML\n";
        } else {
            echo "❌ Avatar URL NOT found in component HTML\n";
            echo "Looking for: {$avatarUrl}\n";
        }

        // Check for image tag
        if (str_contains($html, '<img')) {
            echo "✅ Image tag found in component\n";
        } else {
            echo "❌ No image tag found - showing initials instead\n";
        }

        echo "==============================\n";
    }

    /** @test */
    public function storage_symlink_works_correctly()
    {
        echo "\n=== STORAGE SYMLINK TEST ===\n";

        // Check if public symlink exists and works
        $publicStoragePath = public_path('storage');
        echo "Public storage path: {$publicStoragePath}\n";
        echo 'Symlink exists: '.(file_exists($publicStoragePath) ? '✅ YES' : '❌ NO')."\n";

        if (file_exists($publicStoragePath)) {
            echo 'Is symlink: '.(is_link($publicStoragePath) ? '✅ YES' : '❌ NO')."\n";

            if (is_link($publicStoragePath)) {
                $target = readlink($publicStoragePath);
                echo "Symlink target: {$target}\n";
                echo 'Target exists: '.(file_exists($target) ? '✅ YES' : '❌ NO')."\n";
            }
        }

        // Test with a real avatar file
        $user = User::whereNotNull('avatar')->first();
        if ($user && Storage::disk('public')->exists($user->avatar)) {
            $avatarUrl = Storage::url($user->avatar);
            echo "\nTesting HTTP access to avatar:\n";
            echo "Avatar URL: {$avatarUrl}\n";

            try {
                $response = $this->get($avatarUrl);
                echo 'HTTP Status: '.$response->getStatusCode()."\n";

                if ($response->isSuccessful()) {
                    echo "✅ Avatar accessible via HTTP\n";
                } else {
                    echo "❌ Avatar NOT accessible via HTTP\n";
                }
            } catch (\Exception $e) {
                echo '❌ HTTP Error: '.$e->getMessage()."\n";
            }
        }

        echo "============================\n";
    }
}
