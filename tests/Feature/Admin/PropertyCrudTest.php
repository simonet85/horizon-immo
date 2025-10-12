<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PropertyCrudTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $adminUser;

    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer les rôles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'client']);

        // Créer un utilisateur admin
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('admin');

        // Créer une catégorie
        $this->category = Category::factory()->create();

        Storage::fake('public');
    }

    public function test_admin_can_view_properties_index(): void
    {
        Property::factory()->count(3)->create();

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.properties.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.properties.index');
        $response->assertSee('Gestion des Propriétés');
    }

    public function test_admin_can_view_create_property_form(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.properties.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.properties.create');
        $response->assertSee('Ajouter une Propriété');
    }

    public function test_admin_can_create_property(): void
    {
        $propertyData = [
            'title' => 'Test Property',
            'price' => 250000,
            'surface_area' => 120,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'city' => 'Test City',
            'address' => 'Test Address',
            'type' => 'Appartement',
            'transaction_type' => 'Vente',
            'status' => 'available',
            'category_id' => $this->category->id,
            'description' => 'Test description for property',
            'images' => [UploadedFile::fake()->image('test1.jpg')],
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.properties.store'), $propertyData);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', [
            'title' => 'Test Property',
            'price' => 250000,
            'city' => 'Test City',
        ]);
    }

    public function test_admin_can_view_property_details(): void
    {
        $property = Property::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.properties.show', $property));

        $response->assertStatus(200);
        $response->assertViewIs('admin.properties.show');
        $response->assertSee($property->title);
    }

    public function test_admin_can_view_edit_property_form(): void
    {
        $property = Property::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.properties.edit', $property));

        $response->assertStatus(200);
        $response->assertViewIs('admin.properties.edit');
        $response->assertSee('Modifier la Propriété');
        $response->assertSee($property->title);
    }

    public function test_admin_can_update_property(): void
    {
        $property = Property::factory()->create([
            'title' => 'Original Title',
            'price' => 200000,
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'price' => 300000,
            'surface_area' => $property->surface_area,
            'bedrooms' => $property->bedrooms,
            'bathrooms' => $property->bathrooms,
            'city' => $property->city,
            'address' => $property->address,
            'transaction_type' => $property->transaction_type,
            'status' => $property->status,
            'category_id' => $property->category_id,
            'description' => $property->description,
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.properties.update', $property), $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'title' => 'Updated Title',
            'price' => 300000,
        ]);
    }

    public function test_admin_can_delete_property(): void
    {
        $property = Property::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.properties.destroy', $property));

        $response->assertRedirect();
        $this->assertDatabaseMissing('properties', [
            'id' => $property->id,
        ]);
    }

    public function test_non_admin_cannot_access_property_admin(): void
    {
        $clientUser = User::factory()->create();
        $clientUser->assignRole('client');

        $response = $this->actingAs($clientUser)
            ->get(route('admin.properties.index'));

        $response->assertStatus(403);
    }
}
