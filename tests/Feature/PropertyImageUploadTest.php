<?php

namespace Tests\Feature;

use App\Jobs\ProcessPropertyImages;
use App\Models\Category;
use App\Models\Property;
use App\Models\Town;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PropertyImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role and user
        $adminRole = Role::create(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($adminRole);

        // Create required data
        $category = Category::factory()->create();
        $town = Town::factory()->create();

        // Create a property to test with
        $this->property = Property::factory()->create([
            'category_id' => $category->id,
            'town_id' => $town->id,
        ]);

        // Ensure temp directory exists
        Storage::disk('local')->makeDirectory('temp');
    }

    /** @test */
    public function it_can_upload_five_images_successfully()
    {
        Queue::fake();

        // Arrange: Create 5 test image files
        $images = $this->createTestImages(5);

        // Act: Upload images via the update endpoint
        $response = $this->actingAs($this->admin)
            ->put(route('admin.properties.update', $this->property), [
                'title' => $this->property->title,
                'description' => $this->property->description,
                'price' => $this->property->price,
                'category_id' => $this->property->category_id,
                'town_id' => $this->property->town_id,
                'status' => $this->property->status,
                'images' => $images,
            ]);

        // Assert: Request was successful
        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success');

        // Assert: Check temp files were created
        $tempFiles = Storage::disk('local')->files('temp');
        $this->assertCount(5, $tempFiles, 'Expected 5 temp files to be created');

        // Assert: Each temp file has the correct format
        foreach ($tempFiles as $file) {
            $this->assertMatchesRegularExpression(
                '/property_[0-9a-f.]+\.(jpg|jpeg|png|gif|webp)$/i',
                $file,
                'Temp file should match expected naming pattern'
            );
        }

        // Cleanup temp files manually to avoid file system race conditions
        $tempDir = storage_path('app/temp');
        if (is_dir($tempDir)) {
            $files = glob($tempDir.'/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }

    /** @test */
    public function it_dispatches_process_images_job_when_uploading()
    {
        Queue::fake();

        // Arrange
        $images = $this->createTestImages(3);

        // Act
        $this->actingAs($this->admin)
            ->put(route('admin.properties.update', $this->property), [
                'title' => $this->property->title,
                'description' => $this->property->description,
                'price' => $this->property->price,
                'category_id' => $this->property->category_id,
                'town_id' => $this->property->town_id,
                'status' => $this->property->status,
                'images' => $images,
            ]);

        // Assert: Job was dispatched
        Queue::assertPushed(ProcessPropertyImages::class, function ($job) {
            return count($job->imagePaths) === 3;
        });
    }

    /** @test */
    public function it_can_update_property_without_uploading_images()
    {
        // Act: Update property without images
        $response = $this->actingAs($this->admin)
            ->put(route('admin.properties.update', $this->property), [
                'title' => 'Updated Title',
                'description' => $this->property->description,
                'price' => $this->property->price,
                'category_id' => $this->property->category_id,
                'town_id' => $this->property->town_id,
                'status' => $this->property->status,
            ]);

        // Assert: Request was successful
        $response->assertRedirect(route('admin.properties.index'));

        // Assert: Property was updated
        $this->property->refresh();
        $this->assertEquals('Updated Title', $this->property->title);

        // Assert: No temp files created
        $tempFiles = Storage::disk('local')->files('temp');
        $this->assertCount(0, $tempFiles);
    }

    /** @test */
    public function it_accepts_images_of_various_sizes()
    {
        Queue::fake();

        // Arrange: Create images of various sizes (dimension validation removed from controller)
        $smallImage = UploadedFile::fake()->image('small.jpg', 500, 400);
        $largeImage = UploadedFile::fake()->image('large.jpg', 2000, 1500);

        // Act
        $response = $this->actingAs($this->admin)
            ->put(route('admin.properties.update', $this->property), [
                'title' => $this->property->title,
                'description' => $this->property->description,
                'price' => $this->property->price,
                'category_id' => $this->property->category_id,
                'town_id' => $this->property->town_id,
                'status' => $this->property->status,
                'images' => [$smallImage, $largeImage],
            ]);

        // Assert: Request was successful (no dimension validation in controller)
        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success');

        // Cleanup
        $tempDir = storage_path('app/temp');
        if (is_dir($tempDir)) {
            $files = glob($tempDir.'/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }

    /** @test */
    public function it_validates_maximum_10_images()
    {
        // Arrange: Try to upload 11 images
        $images = $this->createTestImages(11);

        // Act
        $response = $this->actingAs($this->admin)
            ->put(route('admin.properties.update', $this->property), [
                'title' => $this->property->title,
                'description' => $this->property->description,
                'price' => $this->property->price,
                'category_id' => $this->property->category_id,
                'town_id' => $this->property->town_id,
                'status' => $this->property->status,
                'images' => $images,
            ]);

        // Assert: Validation failed
        $response->assertSessionHasErrors('images');
    }

    /** @test */
    public function it_validates_file_types_jpeg_png_gif_webp()
    {
        // Arrange: Create an invalid file type (PDF)
        $invalidFile = UploadedFile::fake()->create('document.pdf', 100);

        // Act
        $response = $this->actingAs($this->admin)
            ->put(route('admin.properties.update', $this->property), [
                'title' => $this->property->title,
                'description' => $this->property->description,
                'price' => $this->property->price,
                'category_id' => $this->property->category_id,
                'town_id' => $this->property->town_id,
                'status' => $this->property->status,
                'images' => [$invalidFile],
            ]);

        // Assert: Validation failed
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_validates_maximum_file_size_10mb()
    {
        // Arrange: Create a file larger than 10MB (10241 KB = ~10.001 MB)
        $largeFile = UploadedFile::fake()->image('large.jpg')->size(10241);

        // Act
        $response = $this->actingAs($this->admin)
            ->put(route('admin.properties.update', $this->property), [
                'title' => $this->property->title,
                'description' => $this->property->description,
                'price' => $this->property->price,
                'category_id' => $this->property->category_id,
                'town_id' => $this->property->town_id,
                'status' => $this->property->status,
                'images' => [$largeFile],
            ]);

        // Assert: Validation failed
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_creates_property_with_images_successfully()
    {
        Queue::fake();

        // Arrange
        $category = Category::factory()->create();
        $town = Town::factory()->create();
        $images = $this->createTestImages(3);

        // Act
        $response = $this->actingAs($this->admin)
            ->post(route('admin.properties.store'), [
                'title' => 'New Property with Images',
                'description' => 'Test property description',
                'price' => 1000000,
                'category_id' => $category->id,
                'town_id' => $town->id,
                'status' => 'available',
                'images' => $images,
            ]);

        // Assert
        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success');

        // Assert: Property was created
        $this->assertDatabaseHas('properties', [
            'title' => 'New Property with Images',
        ]);

        // Assert: Temp files were created
        $tempFiles = Storage::disk('local')->files('temp');
        $this->assertCount(3, $tempFiles);

        // Cleanup manually
        $tempDir = storage_path('app/temp');
        if (is_dir($tempDir)) {
            $files = glob($tempDir.'/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }

    /**
     * Create test images using real fixture files
     */
    protected function createTestImages(int $count): array
    {
        $images = [];
        $fixturesPath = base_path('tests/Fixtures');

        for ($i = 1; $i <= min($count, 5); $i++) {
            $fixturePath = $fixturesPath.'/test-image-'.$i.'.jpg';

            if (file_exists($fixturePath)) {
                // Create UploadedFile from real fixture
                $images[] = new UploadedFile(
                    $fixturePath,
                    'test-image-'.$i.'.jpg',
                    'image/jpeg',
                    null,
                    true // test mode
                );
            } else {
                // Fallback to fake image if fixture doesn't exist
                $images[] = UploadedFile::fake()->image('test-'.$i.'.jpg', 900, 700);
            }
        }

        // If we need more than 5, create fake ones
        for ($i = 6; $i <= $count; $i++) {
            $images[] = UploadedFile::fake()->image('test-'.$i.'.jpg', 900, 700);
        }

        return $images;
    }

    protected function tearDown(): void
    {
        // Clean up temp directory manually to avoid file system issues
        $tempDir = storage_path('app/temp');
        if (is_dir($tempDir)) {
            $files = glob($tempDir.'/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }

        parent::tearDown();
    }
}
