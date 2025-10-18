<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessPropertyImages;
use App\Models\Category;
use App\Models\Property;
use App\Models\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::with('category')->latest()->paginate(10);

        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $towns = Town::where('is_active', true)->orderBy('name')->get();

        return view('admin.properties.create', compact('categories', 'towns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Build base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'town_id' => 'nullable|exists:towns,id',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'surface_area' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(['available', 'reserved', 'sold'])],
            'is_featured' => 'boolean',
        ];

        // Only add images validation if files are actually present and valid
        if ($request->hasFile('images') && is_array($request->file('images'))) {
            $rules['images'] = 'nullable|array|max:10';

            foreach ($request->file('images') as $index => $image) {
                // Only validate if the image is not null and is valid
                if ($image && $image->isValid()) {
                    $rules["images.{$index}"] = 'image|mimes:jpeg,png,jpg,gif,webp|max:10240';
                }
            }
        }

        $validated = $request->validate($rules);

        // Créer la propriété sans les images
        unset($validated['images']);
        $property = Property::create($validated);

        // Traiter les images de manière asynchrone avec Spatie Media Library
        if ($request->hasFile('images') && is_array($request->file('images'))) {
            $tempPaths = [];

            foreach ($request->file('images') as $index => $image) {
                // Skip if image is null
                if (! $image) {
                    continue;
                }

                // Vérifier que l'image est valide et non vide
                if ($image->isValid() && $image->getSize() > 0) {
                    try {
                        // Générer un nom de fichier unique avec extension
                        $extension = $image->getClientOriginalExtension();

                        // Si pas d'extension, utiliser l'extension basée sur le MIME type
                        if (empty($extension)) {
                            $extension = $image->extension(); // Basé sur le MIME type
                        }

                        // Si toujours pas d'extension, utiliser 'jpg' par défaut
                        if (empty($extension)) {
                            $extension = 'jpg';
                        }

                        $filename = uniqid('property_', true).'.'.$extension;

                        // Créer le dossier temp s'il n'existe pas
                        $tempDir = storage_path('app/temp');
                        if (! is_dir($tempDir)) {
                            mkdir($tempDir, 0775, true);
                        }

                        // Chemin complet du fichier de destination
                        $destinationPath = $tempDir.'/'.$filename;

                        // Déplacer le fichier avec la méthode native de Laravel
                        $image->move($tempDir, $filename);
                        $tempPaths[] = $destinationPath;
                    } catch (\Exception $e) {
                        // Log l'erreur mais continue avec les autres images
                        \Log::error('Failed to store temp image: '.$e->getMessage(), [
                            'index' => $index,
                            'name' => $image->getClientOriginalName() ?? 'unknown',
                            'size' => $image->getSize(),
                            'extension_attempt' => $image->getClientOriginalExtension() ?? 'none',
                        ]);
                    }
                }
            }

            // Dispatcher le job pour traitement asynchrone
            if (! empty($tempPaths)) {
                ProcessPropertyImages::dispatch($property, $tempPaths);
            }
        }

        return redirect()->route('admin.properties.index')
            ->with('success', 'Propriété créée avec succès. Les images sont en cours de traitement.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load('category');

        return view('admin.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $categories = Category::all();
        $towns = Town::where('is_active', true)->orderBy('name')->get();

        return view('admin.properties.edit', compact('property', 'categories', 'towns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        // Build base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'town_id' => 'nullable|exists:towns,id',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'surface_area' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(['available', 'reserved', 'sold'])],
            'is_featured' => 'boolean',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:media,id',
        ];

        // Only add images validation if files are actually present and valid
        if ($request->hasFile('images') && is_array($request->file('images'))) {
            $rules['images'] = 'nullable|array|max:10';

            foreach ($request->file('images') as $index => $image) {
                // Only validate if the image is not null and is valid
                if ($image && $image->isValid()) {
                    $rules["images.{$index}"] = 'image|mimes:jpeg,png,jpg,gif,webp|max:10240';
                }
            }
        }

        $validated = $request->validate($rules);

        // Supprimer les images sélectionnées (Spatie Media Library)
        if ($request->has('delete_images') && is_array($request->delete_images)) {
            $property->media()->whereIn('id', $request->delete_images)->each->delete();
        }

        // Mettre à jour la propriété (sans les images)
        unset($validated['images'], $validated['delete_images']);
        $property->update($validated);

        // Ajouter les nouvelles images
        if ($request->hasFile('images') && is_array($request->file('images'))) {
            $tempPaths = [];

            foreach ($request->file('images') as $index => $image) {
                // Skip if image is null
                if (! $image) {
                    continue;
                }

                // Vérifier que l'image est valide et non vide
                if ($image->isValid() && $image->getSize() > 0) {
                    try {
                        // Générer un nom de fichier unique avec extension
                        $extension = $image->getClientOriginalExtension();

                        // Si pas d'extension, utiliser l'extension basée sur le MIME type
                        if (empty($extension)) {
                            $extension = $image->extension(); // Basé sur le MIME type
                        }

                        // Si toujours pas d'extension, utiliser 'jpg' par défaut
                        if (empty($extension)) {
                            $extension = 'jpg';
                        }

                        $filename = uniqid('property_', true).'.'.$extension;

                        // Créer le dossier temp s'il n'existe pas
                        $tempDir = storage_path('app/temp');
                        if (! is_dir($tempDir)) {
                            mkdir($tempDir, 0775, true);
                        }

                        // Chemin complet du fichier de destination
                        $destinationPath = $tempDir.'/'.$filename;

                        // Déplacer le fichier avec la méthode native de Laravel
                        $image->move($tempDir, $filename);
                        $tempPaths[] = $destinationPath;
                    } catch (\Exception $e) {
                        // Log l'erreur mais continue avec les autres images
                        \Log::error('Failed to store temp image: '.$e->getMessage(), [
                            'index' => $index,
                            'name' => $image->getClientOriginalName() ?? 'unknown',
                            'size' => $image->getSize(),
                            'extension_attempt' => $image->getClientOriginalExtension() ?? 'none',
                        ]);
                    }
                }
            }

            if (! empty($tempPaths)) {
                ProcessPropertyImages::dispatch($property, $tempPaths);
            }
        }

        return redirect()->route('admin.properties.index')
            ->with('success', 'Propriété mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('admin.properties.index')
            ->with('success', 'Propriété supprimée avec succès.');
    }

    // Bulk import methods removed
}
