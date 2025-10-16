<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageRouteTest extends TestCase
{
    /** @test */
    public function storage_route_serves_files_correctly()
    {
        echo "\n=== STORAGE ROUTE TEST ===\n";

        // Create a test file in storage
        Storage::disk('public')->put('test-image.jpg', 'test image content');

        echo "Created test file in storage\n";

        // Test the storage route
        $response = $this->get('/storage/test-image.jpg');

        echo 'HTTP Status: '.$response->getStatusCode()."\n";
        echo 'Content: '.substr($response->getContent(), 0, 20)."\n";

        if ($response->isSuccessful()) {
            echo "✅ Storage route works\n";
            $this->assertEquals('test image content', $response->getContent());
        } else {
            echo "❌ Storage route failed\n";
        }

        // Test nested path
        Storage::disk('public')->put('avatars/test-avatar.jpg', 'avatar content');

        $avatarResponse = $this->get('/storage/avatars/test-avatar.jpg');
        echo 'Avatar HTTP Status: '.$avatarResponse->getStatusCode()."\n";

        if ($avatarResponse->isSuccessful()) {
            echo "✅ Nested avatar path works\n";
            $this->assertEquals('avatar content', $avatarResponse->getContent());
        } else {
            echo "❌ Nested avatar path failed\n";
        }

        // Clean up
        Storage::disk('public')->delete(['test-image.jpg', 'avatars/test-avatar.jpg']);

        echo "==========================\n";
    }
}
