<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Town;
use Illuminate\Http\Request;

class TownController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $towns = Town::withCount('properties')->paginate(15);

        return view('admin.towns.index', compact('towns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.towns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:towns',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Town::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.towns.index')
            ->with('success', 'Ville créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Town $town)
    {
        $town->load(['properties' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.towns.show', compact('town'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Town $town)
    {
        return view('admin.towns.edit', compact('town'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Town $town)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:towns,name,'.$town->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $town->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.towns.index')
            ->with('success', 'Ville mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Town $town)
    {
        if ($town->properties()->count() > 0) {
            return redirect()->route('admin.towns.index')
                ->with('error', 'Impossible de supprimer cette ville car elle contient des propriétés.');
        }

        $town->delete();

        return redirect()->route('admin.towns.index')
            ->with('success', 'Ville supprimée avec succès.');
    }
}
