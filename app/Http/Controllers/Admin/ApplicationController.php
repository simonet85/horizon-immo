<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccompanimentRequest;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = AccompanimentRequest::orderBy('created_at', 'desc')->paginate(15);
        $pendingCount = AccompanimentRequest::where('status', 'pending')->count();
        $processingCount = AccompanimentRequest::where('status', 'processing')->count();

        return view('admin.applications.index', compact('applications', 'pendingCount', 'processingCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.applications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country_residence' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:120',
            'profession' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'desired_city' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'budget_range' => 'required|string|max:255',
            'additional_info' => 'nullable|string',
            'personal_contribution_percentage' => 'required|integer|min:10|max:100',
            'message' => 'nullable|string',
        ]);

        AccompanimentRequest::create($validated);

        return redirect()->route('admin.applications.index')
            ->with('success', 'Demande d\'accompagnement créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccompanimentRequest $application)
    {
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccompanimentRequest $application)
    {
        return view('admin.applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccompanimentRequest $application)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country_residence' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:120',
            'profession' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'desired_city' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'budget_range' => 'required|string|max:255',
            'additional_info' => 'nullable|string',
            'personal_contribution_percentage' => 'required|integer|min:10|max:100',
            'message' => 'nullable|string',
            'status' => 'required|in:pending,processing,completed,rejected',
        ]);

        $application->update($validated);

        return redirect()->route('admin.applications.index')
            ->with('success', 'Demande d\'accompagnement mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccompanimentRequest $application)
    {
        $application->delete();

        return redirect()->route('admin.applications.index')
            ->with('success', 'Demande d\'accompagnement supprimée avec succès.');
    }

    /**
     * Mettre à jour le statut d'une demande
     */
    public function updateStatus(Request $request, AccompanimentRequest $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,rejected',
        ]);

        $application->update($validated);

        return redirect()->back()
            ->with('success', 'Statut mis à jour avec succès.');
    }
}
