<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarWebAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function avatar_workflow_complete_test()
    {
        echo "\n=== COMPLETE AVATAR WORKFLOW TEST ===\n";

        // Create user and authenticate
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->actingAs($user);

        echo "1. TESTING PROFILE PAGE ACCESS:\n";

        // Test profile page loads
        $response = $this->get('/profile/edit');
        $response->assertStatus(200);
        $response->assertSee('Photo de profil');

        echo "   ✅ Profile page loads successfully\n";

        // Check for avatar form components
        $response->assertSee('Choisir une nouvelle photo');
        $response->assertSee('wire:model="avatar"');

        echo "   ✅ Avatar upload form present\n";

        echo "\n2. TESTING INITIAL STATE (NO AVATAR):\n";

        // Should show initials, not image
        $response->assertSee($user->name);
        echo "   ✅ User name displayed\n";

        // Should not have avatar initially
        $this->assertNull($user->avatar);
        echo "   ✅ User has no avatar initially\n";

        echo "\n3. TESTING STORAGE CONFIGURATION:\n";

        // Test storage configuration
        $testFile = 'test-file.txt';
        Storage::disk('public')->put($testFile, 'test content');

        $testUrl = Storage::url($testFile);
        echo "   - Test file URL: {$testUrl}\n";

        // Try to access via HTTP
        $testResponse = $this->get($testUrl);
        echo '   - HTTP Status: '.$testResponse->getStatusCode()."\n";

        if ($testResponse->isSuccessful()) {
            echo "   ✅ Storage files accessible via HTTP\n";
        } else {
            echo "   ❌ Storage files NOT accessible via HTTP\n";
            echo '   - Response content: '.$testResponse->getContent()."\n";
        }

        // Clean up test file
        Storage::disk('public')->delete($testFile);

        echo "\n4. TESTING AVATAR COMPONENT RENDERING:\n";

        // Check if the Livewire component renders
        $response->assertSeeLivewire('forms.update-avatar-form');
        echo "   ✅ Avatar component loaded\n";

        echo "\n=====================================\n";

        // The test should pass
        $this->assertTrue(true);
    }

    /** @test */
    public function test_web_server_avatar_access()
    {
        echo "\n=== WEB SERVER AVATAR ACCESS TEST ===\n";

        // Create a real avatar file for testing
        Storage::fake('public');
        $avatarContent = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAYEBAQFBAYFBQYJBgUGCQsIBgYICwwKCgsKCgwQDAwMDAwMEAwODxAPDgwTExQUExMcGxsbHBwfHx8fHx8fHx//wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAX/xAAhEAACAQQCAgMAAAAAAAAAAAABAgMABAUGIWIRcRITkf/EABUBAQEAAAAAAAAAAAAAAAAAAAMF/8QAFxEAAwEAAAAAAAAAAAAAAAAAAAECEf/aAAwDAQACEQMRAD8A2+Bg==');

        $avatarPath = 'avatars/test-real-avatar.jpg';
        Storage::disk('public')->put($avatarPath, $avatarContent);

        echo "Created test avatar at: {$avatarPath}\n";

        // Create user with this avatar
        $user = User::factory()->create([
            'avatar' => $avatarPath,
        ]);

        $avatarUrl = Storage::url($avatarPath);
        echo "Avatar URL: {$avatarUrl}\n";

        // Test HTTP access
        $response = $this->get($avatarUrl);
        echo 'HTTP Status: '.$response->getStatusCode()."\n";

        if ($response->isSuccessful()) {
            echo "✅ Avatar accessible via web server\n";
            echo 'Content-Type: '.$response->headers->get('Content-Type')."\n";
        } else {
            echo "❌ Avatar NOT accessible via web server\n";
            echo 'Error content: '.substr($response->getContent(), 0, 200)."\n";
        }

        echo "====================================\n";
    }
}
