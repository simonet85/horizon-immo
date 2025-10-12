<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
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

        return view('admin.properties.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'city' => 'required|string',
            'address' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'surface_area' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(['available', 'reserved', 'sold'])],
            'is_featured' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gérer l'upload des images
        $imageUrls = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Vérifier que l'image n'est pas null et est valide
                if ($image && $image->isValid()) {
                    try {
                        // Générer un nom de fichier unique
                        $filename = uniqid().'_'.time().'.'.$image->getClientOriginalExtension();

                        // Définir le chemin de destination
                        $destinationPath = storage_path('app/public/properties');

                        // S'assurer que le dossier existe
                        if (! file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }

                        // Déplacer le fichier uploadé
                        $image->move($destinationPath, $filename);

                        // Ajouter le chemin relatif pour le stockage en BDD
                        $imageUrls[] = '/storage/properties/'.$filename;
                    } catch (\Exception $e) {
                        \Log::error('Erreur upload image: '.$e->getMessage());
                        // Continue avec les autres images
                    }
                }
            }
        }
        $validated['images'] = $imageUrls;

        Property::create($validated);

        return redirect()->route('admin.properties.index')
            ->with('success', 'Propriété créée avec succès.');
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

        return view('admin.properties.edit', compact('property', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'city' => 'required|string',
            'address' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'surface_area' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(['available', 'reserved', 'sold'])],
            'is_featured' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gérer l'upload des nouvelles images
        if ($request->hasFile('images')) {
            $imageUrls = [];
            foreach ($request->file('images') as $image) {
                // Vérifier que l'image n'est pas null et est valide
                if ($image && $image->isValid()) {
                    try {
                        // Générer un nom de fichier unique
                        $filename = uniqid().'_'.time().'.'.$image->getClientOriginalExtension();

                        // Définir le chemin de destination
                        $destinationPath = storage_path('app/public/properties');

                        // S'assurer que le dossier existe
                        if (! file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }

                        // Déplacer le fichier uploadé
                        $image->move($destinationPath, $filename);

                        // Ajouter le chemin relatif pour le stockage en BDD
                        $imageUrls[] = '/storage/properties/'.$filename;
                    } catch (\Exception $e) {
                        \Log::error('Erreur upload image lors de la mise à jour: '.$e->getMessage());
                        // Continue avec les autres images
                    }
                }
            }
            // Mettre à jour uniquement si des images valides ont été uploadées
            if (! empty($imageUrls)) {
                $validated['images'] = $imageUrls;
            } else {
                unset($validated['images']);
            }
        } else {
            // Si aucune nouvelle image, garder les images existantes
            unset($validated['images']);
        }

        $property->update($validated);

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
}
