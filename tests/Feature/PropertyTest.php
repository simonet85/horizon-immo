<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer les rôles et permissions nécessaires
        $this->artisan('db:seed', ['--class' => 'RolePermissionSeeder']);
        $this->artisan('db:seed', ['--class' => 'CategorySeeder']);
    }

    /**
     * Test : Un administrateur peut créer une propriété sans image
     */
    public function test_admin_can_create_property_without_image(): void
    {
        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Récupérer une catégorie
        $category = Category::first();

        // Données de la propriété
        $propertyData = [
            'title' => 'Villa de luxe au Cap',
            'description' => 'Magnifique villa avec vue sur l\'océan',
            'price' => 5000000,
            'category_id' => $category->id,
            'city' => 'Cape Town',
            'address' => '123 Ocean Drive',
            'bedrooms' => 4,
            'bathrooms' => 3,
            'surface_area' => 350,
            'transaction_type' => 'Vente',
            'status' => 'available',
            'is_featured' => true,
        ];

        // Se connecter en tant qu'admin et créer la propriété
        $response = $this->actingAs($admin)
            ->post(route('admin.properties.store'), $propertyData);

        // Vérifier la redirection
        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success', 'Propriété créée avec succès.');

        // Vérifier que la propriété a été créée dans la base de données
        $this->assertDatabaseHas('properties', [
            'title' => 'Villa de luxe au Cap',
            'price' => 5000000,
            'category_id' => $category->id,
            'city' => 'Cape Town',
            'status' => 'available',
        ]);
    }

    /**
     * Test : Un administrateur peut créer une propriété avec des images
     */
    public function test_admin_can_create_property_with_images(): void
    {
        // Créer un fake storage pour les tests
        Storage::fake('public');

        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Récupérer une catégorie
        $category = Category::first();

        // Créer des images fake
        $image1 = UploadedFile::fake()->image('property1.jpg', 800, 600);
        $image2 = UploadedFile::fake()->image('property2.jpg', 800, 600);

        // Données de la propriété avec images
        $propertyData = [
            'title' => 'Appartement moderne',
            'description' => 'Bel appartement rénové au centre-ville',
            'price' => 2500000,
            'category_id' => $category->id,
            'city' => 'Johannesburg',
            'address' => '45 Main Street',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'surface_area' => 120,
            'transaction_type' => 'Vente',
            'status' => 'available',
            'is_featured' => false,
            'images' => [$image1, $image2],
        ];

        // Se connecter en tant qu'admin et créer la propriété
        $response = $this->actingAs($admin)
            ->post(route('admin.properties.store'), $propertyData);

        // Vérifier la redirection
        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success', 'Propriété créée avec succès.');

        // Vérifier que la propriété a été créée dans la base de données
        $this->assertDatabaseHas('properties', [
            'title' => 'Appartement moderne',
            'price' => 2500000,
        ]);

        // Récupérer la propriété créée
        $property = Property::where('title', 'Appartement moderne')->first();

        // Vérifier que les images ont été uploadées
        $this->assertNotEmpty($property->images);
        $this->assertCount(2, $property->images);

        // Vérifier que les fichiers existent dans le système de fichiers réel
        foreach ($property->images as $imagePath) {
            $fullPath = public_path($imagePath);
            $this->assertFileExists($fullPath);
        }
    }

    /**
     * Test : Un utilisateur non-admin ne peut pas créer de propriété
     */
    public function test_non_admin_cannot_create_property(): void
    {
        // Créer un utilisateur client
        $client = User::factory()->create();
        $client->assignRole('client');

        // Récupérer une catégorie
        $category = Category::first();

        // Données de la propriété
        $propertyData = [
            'title' => 'Villa test',
            'description' => 'Description test',
            'price' => 1000000,
            'category_id' => $category->id,
            'city' => 'Cape Town',
            'address' => 'Test address',
            'status' => 'available',
        ];

        // Tenter de créer la propriété en tant que client
        $response = $this->actingAs($client)
            ->post(route('admin.properties.store'), $propertyData);

        // Vérifier que l'accès est refusé (redirection ou 403)
        $response->assertStatus(403);
    }

    /**
     * Test : Validation des champs obligatoires
     */
    public function test_property_creation_requires_mandatory_fields(): void
    {
        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Tenter de créer une propriété sans données
        $response = $this->actingAs($admin)
            ->post(route('admin.properties.store'), []);

        // Vérifier les erreurs de validation
        $response->assertSessionHasErrors([
            'title',
            'description',
            'price',
            'category_id',
            'city',
            'status',
        ]);
    }

    /**
     * Test : Validation du format des images
     */
    public function test_property_images_must_be_valid_image_files(): void
    {
        Storage::fake('public');

        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Récupérer une catégorie
        $category = Category::first();

        // Créer un fichier qui n'est pas une image
        $invalidFile = UploadedFile::fake()->create('document.pdf', 1000);

        // Données de la propriété avec un fichier invalide
        $propertyData = [
            'title' => 'Test Villa',
            'description' => 'Description',
            'price' => 3000000,
            'category_id' => $category->id,
            'city' => 'Durban',
            'address' => 'Test address',
            'status' => 'available',
            'images' => [$invalidFile],
        ];

        // Tenter de créer la propriété
        $response = $this->actingAs($admin)
            ->post(route('admin.properties.store'), $propertyData);

        // Vérifier l'erreur de validation sur les images
        $response->assertSessionHasErrors('images.0');
    }

    /**
     * Test : Un administrateur peut mettre à jour une propriété
     */
    public function test_admin_can_update_property(): void
    {
        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Créer une propriété existante
        $category = Category::first();
        $property = Property::factory()->create([
            'category_id' => $category->id,
            'title' => 'Ancien titre',
            'price' => 1000000,
        ]);

        // Nouvelles données
        $updatedData = [
            'title' => 'Nouveau titre',
            'description' => 'Nouvelle description',
            'price' => 2000000,
            'category_id' => $category->id,
            'city' => 'Durban',
            'address' => 'Nouvelle adresse',
            'bedrooms' => 5,
            'bathrooms' => 3,
            'surface_area' => 250,
            'transaction_type' => 'Location',
            'status' => 'reserved',
            'is_featured' => true,
        ];

        // Mettre à jour la propriété
        $response = $this->actingAs($admin)
            ->put(route('admin.properties.update', $property), $updatedData);

        // Vérifier la redirection
        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success', 'Propriété mise à jour avec succès.');

        // Vérifier que les données ont été mises à jour
        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'title' => 'Nouveau titre',
            'price' => 2000000,
            'city' => 'Durban',
            'status' => 'reserved',
        ]);
    }

    /**
     * Test : Un administrateur peut mettre à jour une propriété avec de nouvelles images
     */
    public function test_admin_can_update_property_with_new_images(): void
    {
        Storage::fake('public');

        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Créer une propriété avec des images existantes
        $category = Category::first();
        $property = Property::factory()->create([
            'category_id' => $category->id,
            'images' => ['/storage/old_image.jpg'],
        ]);

        // Nouvelles images
        $newImage = UploadedFile::fake()->image('new_property.jpg', 800, 600);

        // Données de mise à jour
        $updatedData = [
            'title' => $property->title,
            'description' => $property->description,
            'price' => $property->price,
            'category_id' => $category->id,
            'city' => $property->city,
            'address' => $property->address,
            'status' => $property->status,
            'images' => [$newImage],
        ];

        // Mettre à jour la propriété
        $response = $this->actingAs($admin)
            ->put(route('admin.properties.update', $property), $updatedData);

        // Vérifier la redirection
        $response->assertRedirect(route('admin.properties.index'));

        // Recharger la propriété
        $property->refresh();

        // Vérifier que les nouvelles images ont été uploadées
        $this->assertNotEmpty($property->images);
        $this->assertNotEquals(['/storage/old_image.jpg'], $property->images);
    }

    /**
     * Test : Un administrateur peut supprimer une propriété
     */
    public function test_admin_can_delete_property(): void
    {
        // Créer un utilisateur admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Créer une propriété
        $category = Category::first();
        $property = Property::factory()->create([
            'category_id' => $category->id,
        ]);

        $propertyId = $property->id;

        // Supprimer la propriété
        $response = $this->actingAs($admin)
            ->delete(route('admin.properties.destroy', $property));

        // Vérifier la redirection
        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success', 'Propriété supprimée avec succès.');

        // Vérifier que la propriété a été supprimée
        $this->assertDatabaseMissing('properties', [
            'id' => $propertyId,
        ]);
    }

    /**
     * Test : Un utilisateur non-admin ne peut pas supprimer de propriété
     */
    public function test_non_admin_cannot_delete_property(): void
    {
        // Créer un utilisateur client
        $client = User::factory()->create();
        $client->assignRole('client');

        // Créer une propriété
        $category = Category::first();
        $property = Property::factory()->create([
            'category_id' => $category->id,
        ]);

        // Tenter de supprimer la propriété
        $response = $this->actingAs($client)
            ->delete(route('admin.properties.destroy', $property));

        // Vérifier que l'accès est refusé
        $response->assertStatus(403);

        // Vérifier que la propriété existe toujours
        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
        ]);
    }
}
