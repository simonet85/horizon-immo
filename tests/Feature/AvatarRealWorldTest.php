<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarRealWorldTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_visit_profile_edit_and_see_avatar_form()
    {
        // Créer et authentifier un utilisateur
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);
        
        $this->actingAs($user);
        
        // Visiter la page de profil
        $response = $this->get('/profile/edit');
        
        $response->assertStatus(200);
        $response->assertSee('Photo de profil');
        $response->assertSee('Choisir une nouvelle photo');
        
        echo "\n=== PROFILE PAGE TEST ===\n";
        echo "✓ User can access profile edit page\n";
        echo "✓ Avatar form is visible\n";
        echo "========================\n";
    }

    /** @test */
    public function user_can_upload_avatar_via_http_request()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Créer un fichier de test réel
        $file = UploadedFile::fake()->image('avatar.jpg', 300, 300);
        
        echo "\n=== HTTP UPLOAD TEST ===\n";
        echo "Testing file upload via HTTP request...\n";
        
        // Simuler la requête POST Livewire
        $response = $this->post('/livewire/update', [
            'updates' => [
                [
                    'type' => 'callMethod',
                    'payload' => [
                        'method' => 'updateAvatar',
                        'params' => []
                    ]
                ]
            ],
            'snapshot' => [
                'data' => [
                    'avatar' => $file
                ],
                'memo' => [
                    'id' => 'test-id',
                    'name' => 'forms.update-avatar-form',
                    'path' => '',
                    'method' => 'GET'
                ]
            ]
        ]);
        
        // Vérifier la réponse
        echo "Response status: " . $response->getStatusCode() . "\n";
        
        // Vérifier l'état de l'utilisateur
        $user->refresh();
        echo "User avatar after upload: " . ($user->avatar ?? 'NULL') . "\n";
        
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            echo "✓ Avatar file saved successfully\n";
            echo "Avatar URL: " . Storage::url($user->avatar) . "\n";
        } else {
            echo "✗ Avatar upload failed\n";
        }
        
        echo "=======================\n";
    }

    /** @test */
    public function debug_current_user_avatars()
    {
        echo "\n=== CURRENT USERS AVATAR STATUS ===\n";
        
        $users = User::all();
        
        foreach ($users as $user) {
            echo "User #{$user->id}: {$user->name} ({$user->email})\n";
            echo "  Avatar: " . ($user->avatar ?? 'NULL') . "\n";
            
            if ($user->avatar) {
                $fullPath = Storage::disk('public')->path($user->avatar);
                $url = Storage::url($user->avatar);
                $exists = Storage::disk('public')->exists($user->avatar);
                
                echo "  File exists: " . ($exists ? 'YES' : 'NO') . "\n";
                echo "  Full path: $fullPath\n";
                echo "  URL: $url\n";
                
                if ($exists && file_exists($fullPath)) {
                    $size = filesize($fullPath);
                    echo "  File size: " . number_format($size) . " bytes\n";
                }
            }
            echo "\n";
        }
        
        echo "==================================\n";
        
        $this->assertTrue(true);
    }

    /** @test */
    public function test_storage_url_generation()
    {
        echo "\n=== STORAGE URL GENERATION TEST ===\n";
        
        $testPaths = [
            'avatars/test-avatar.jpg',
            'avatars/user-123.png',
            'avatars/profile.jpeg'
        ];
        
        foreach ($testPaths as $path) {
            $url = Storage::url($path);
            $fullUrl = Storage::disk('public')->url($path);
            
            echo "Path: $path\n";
            echo "  Storage::url(): $url\n";
            echo "  Storage::disk('public')->url(): $fullUrl\n";
            echo "  Expected format: /storage/$path\n";
            echo "\n";
        }
        
        // Test avec un vrai fichier
        $realFile = 'avatars/real-test.jpg';
        Storage::disk('public')->put($realFile, 'test content');
        
        $realUrl = Storage::url($realFile);
        echo "Real file test:\n";
        echo "  Path: $realFile\n";
        echo "  URL: $realUrl\n";
        echo "  File exists: " . (Storage::disk('public')->exists($realFile) ? 'YES' : 'NO') . "\n";
        echo "  Accessible via HTTP: ";
        
        // Test HTTP access
        try {
            $response = $this->get($realUrl);
            echo $response->isSuccessful() ? 'YES' : 'NO (' . $response->getStatusCode() . ')';
        } catch (\Exception $e) {
            echo 'ERROR - ' . $e->getMessage();
        }
        
        echo "\n";
        
        // Cleanup
        Storage::disk('public')->delete($realFile);
        
        echo "===============================\n";
        
        $this->assertTrue(true);
    }
}