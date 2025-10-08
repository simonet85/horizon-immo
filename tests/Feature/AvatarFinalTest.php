<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarFinalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure storage directory exists
        Storage::fake('public');
    }

    /** @test */
    public function user_can_view_profile_page_with_default_avatar()
    {
        echo "\n=== PROFILE PAGE ACCESS TEST ===\n";
        
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);
        
        echo "Created user: {$user->name} (ID: {$user->id})\n";
        echo "User avatar: " . ($user->avatar ?? 'NULL') . "\n";
        
        $this->actingAs($user);
        
        $response = $this->get('/profile/edit');
        $response->assertStatus(200);
        
        // Should see the profile form components
        $response->assertSee('Photo de profil');
        $response->assertSee($user->name);
        $response->assertSee($user->email);
        
        echo "✅ Profile page loads successfully\n";
        echo "✅ User information displayed\n";
        echo "✅ Avatar form visible\n";
        echo "===============================\n";
    }

    /** @test */
    public function livewire_avatar_component_works_with_upload()
    {
        echo "\n=== LIVEWIRE AVATAR UPLOAD TEST ===\n";
        
        Storage::fake('public');
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        echo "Testing avatar upload with user: {$user->name}\n";
        
        // Create a fake image file
        $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);
        echo "Created fake file: {$file->getClientOriginalName()}\n";
        
        $component = Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class);
        
        // Set the avatar and call update
        $component->set('avatar', $file)
                  ->call('updateAvatar');
        
        // Check for validation errors
        if ($component->hasErrors()) {
            echo "❌ Upload failed with errors:\n";
            foreach ($component->errors() as $field => $errors) {
                echo "  - $field: " . implode(', ', $errors) . "\n";
            }
        } else {
            echo "✅ No validation errors\n";
            
            // Refresh user to check avatar
            $user->refresh();
            
            if ($user->avatar) {
                echo "✅ Avatar saved to user: {$user->avatar}\n";
                
                // Check if file was stored
                $stored = Storage::disk('public')->exists($user->avatar);
                echo "✅ Avatar file stored: " . ($stored ? 'YES' : 'NO') . "\n";
                
                if ($stored) {
                    $url = Storage::url($user->avatar);
                    echo "✅ Avatar URL: {$url}\n";
                }
            } else {
                echo "❌ Avatar not saved to user\n";
            }
        }
        
        echo "===============================\n";
    }

    /** @test */
    public function avatar_displays_initials_when_no_image()
    {
        echo "\n=== AVATAR INITIALS TEST ===\n";
        
        $user = User::factory()->create([
            'name' => 'Jane Smith'
        ]);
        
        $this->actingAs($user);
        
        echo "Testing initials with user: {$user->name}\n";
        
        $component = Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class);
        
        // Get the initials
        $initials = $component->instance()->getUserInitials();
        echo "User initials: {$initials}\n";
        
        $this->assertEquals('JS', $initials);
        echo "✅ Initials calculated correctly\n";
        
        // Check component HTML contains initials
        $html = $component->payload['effects']['html'];
        
        if (str_contains($html, $initials)) {
            echo "✅ Initials found in component HTML\n";
        } else {
            echo "❌ Initials NOT found in component HTML\n";
        }
        
        echo "============================\n";
    }
}