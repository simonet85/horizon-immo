<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AvatarDebugSimpleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_checks_storage_configuration_and_user_state()
    {
        echo "\n=== AVATAR DEBUG ANALYSIS ===\n";
        
        // 1. Vérifier la configuration du stockage
        echo "1. STORAGE CONFIGURATION:\n";
        echo "   - Storage public path: " . Storage::disk('public')->path('') . "\n";
        echo "   - Storage public URL: " . Storage::disk('public')->url('') . "\n";
        echo "   - Public storage symlink exists: " . (file_exists(public_path('storage')) ? 'YES' : 'NO') . "\n";
        
        if (file_exists(public_path('storage'))) {
            echo "   - Is symlink: " . (is_link(public_path('storage')) ? 'YES' : 'NO') . "\n";
            if (is_link(public_path('storage'))) {
                echo "   - Symlink target: " . readlink(public_path('storage')) . "\n";
            }
        }
        
        // 2. Vérifier les permissions et dossiers
        echo "\n2. DIRECTORIES & PERMISSIONS:\n";
        $avatarsPath = Storage::disk('public')->path('avatars');
        echo "   - Avatars directory exists: " . (is_dir($avatarsPath) ? 'YES' : 'NO') . "\n";
        echo "   - Avatars path: " . $avatarsPath . "\n";
        
        if (is_dir($avatarsPath)) {
            echo "   - Avatars directory writable: " . (is_writable($avatarsPath) ? 'YES' : 'NO') . "\n";
            echo "   - Avatars directory permissions: " . substr(sprintf('%o', fileperms($avatarsPath)), -4) . "\n";
        }
        
        // 3. Vérifier les utilisateurs actuels
        echo "\n3. USERS WITH AVATARS:\n";
        $users = User::whereNotNull('avatar')->get();
        echo "   - Users with avatars count: " . $users->count() . "\n";
        
        foreach ($users as $user) {
            echo "   - User {$user->id} ({$user->name}): {$user->avatar}\n";
            $fullPath = Storage::disk('public')->path($user->avatar);
            echo "     * File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
            echo "     * File URL: " . Storage::disk('public')->url($user->avatar) . "\n";
        }
        
        // 4. Tester la création d'un fichier de test
        echo "\n4. STORAGE WRITE TEST:\n";
        try {
            $testFile = 'avatars/test-' . time() . '.txt';
            Storage::disk('public')->put($testFile, 'Test content');
            echo "   - Can write to storage: YES\n";
            echo "   - Test file URL: " . Storage::disk('public')->url($testFile) . "\n";
            
            // Nettoyer
            Storage::disk('public')->delete($testFile);
            echo "   - Test file cleaned up: YES\n";
        } catch (\Exception $e) {
            echo "   - Can write to storage: NO - " . $e->getMessage() . "\n";
        }
        
        echo "============================\n";
        
        $this->assertTrue(true); // Pour que le test passe
    }

    /** @test */
    public function it_tests_avatar_upload_with_real_user()
    {
        echo "\n=== AVATAR UPLOAD TEST ===\n";
        
        // Utiliser un utilisateur existant ou en créer un
        $user = User::first() ?? User::factory()->create([
            'name' => 'Test Avatar User',
            'email' => 'avatar-test@example.com'
        ]);
        
        echo "Testing with user: {$user->name} (ID: {$user->id})\n";
        echo "Current avatar: " . ($user->avatar ?? 'NULL') . "\n";
        
        // S'authentifier
        $this->actingAs($user);
        
        // Tester le composant avec un fichier fake
        try {
            $file = UploadedFile::fake()->image('test-avatar.jpg', 200, 200)->size(500);
            
            echo "Created fake file: {$file->getClientOriginalName()}\n";
            echo "File size: " . $file->getSize() . " bytes\n";
            echo "File mime: " . $file->getMimeType() . "\n";
            
            $component = Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class);
            
            echo "Component loaded successfully\n";
            
            // Set the file
            $component->set('avatar', $file);
            echo "File set on component\n";
            
            // Try to upload
            $component->call('updateAvatar');
            echo "Upload method called\n";
            
            // Check for errors
            if ($component->hasErrors()) {
                echo "ERRORS FOUND:\n";
                foreach ($component->errors() as $field => $errors) {
                    echo "  - $field: " . implode(', ', $errors) . "\n";
                }
            } else {
                echo "No validation errors\n";
            }
            
            // Check user after upload
            $user->refresh();
            echo "User avatar after upload: " . ($user->avatar ?? 'NULL') . "\n";
            
            if ($user->avatar) {
                $avatarPath = Storage::disk('public')->path($user->avatar);
                echo "Avatar file exists: " . (file_exists($avatarPath) ? 'YES' : 'NO') . "\n";
                echo "Avatar URL: " . Storage::disk('public')->url($user->avatar) . "\n";
            }
            
        } catch (\Exception $e) {
            echo "ERROR during upload test: " . $e->getMessage() . "\n";
            echo "Stack trace: " . $e->getTraceAsString() . "\n";
        }
        
        echo "========================\n";
        
        $this->assertTrue(true);
    }

    /** @test */
    public function it_tests_component_rendering()
    {
        echo "\n=== COMPONENT RENDERING TEST ===\n";
        
        $user = User::first() ?? User::factory()->create([
            'name' => 'Render Test User',
            'email' => 'render-test@example.com'
        ]);
        
        $this->actingAs($user);
        
        try {
            $component = Livewire::test(\App\Livewire\Forms\UpdateAvatarForm::class);
            
            echo "Component rendered successfully\n";
            echo "Component class: " . get_class($component->instance()) . "\n";
            
            // Test initials method
            $initials = $component->instance()->getUserInitials();
            echo "User initials: " . $initials . "\n";
            
            // Check what's being rendered
            $html = $component->payload['effects']['html'];
            echo "Component contains avatar image: " . (strpos($html, '<img') !== false ? 'YES' : 'NO') . "\n";
            echo "Component contains initials div: " . (strpos($html, 'bg-blue-500') !== false ? 'YES' : 'NO') . "\n";
            
        } catch (\Exception $e) {
            echo "ERROR during rendering test: " . $e->getMessage() . "\n";
        }
        
        echo "==============================\n";
        
        $this->assertTrue(true);
    }
}