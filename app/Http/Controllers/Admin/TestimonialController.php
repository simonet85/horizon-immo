<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::ordered()->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_title' => 'nullable|string|max:255',
            'testimonial' => 'required|string',
            'client_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'property_type' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        // Upload de la photo si fournie
        if ($request->hasFile('client_photo')) {
            $data['client_photo'] = $request->file('client_photo')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.home-content.index')
            ->with('success', 'Témoignage créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_title' => 'nullable|string|max:255',
            'testimonial' => 'required|string',
            'client_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'property_type' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        // Upload de la nouvelle photo si fournie
        if ($request->hasFile('client_photo')) {
            // Supprimer l'ancienne photo
            if ($testimonial->client_photo && Storage::disk('public')->exists($testimonial->client_photo)) {
                Storage::disk('public')->delete($testimonial->client_photo);
            }
            $data['client_photo'] = $request->file('client_photo')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()->route('admin.home-content.index')
            ->with('success', 'Témoignage mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Supprimer la photo si elle existe
        if ($testimonial->client_photo && Storage::disk('public')->exists($testimonial->client_photo)) {
            Storage::disk('public')->delete($testimonial->client_photo);
        }

        $testimonial->delete();

        return redirect()->route('admin.home-content.index')
            ->with('success', 'Témoignage supprimé avec succès.');
    }
}
