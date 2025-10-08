<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AccompanimentRequest;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Afficher la liste des demandes d'accompagnement du client
     */
    public function index()
    {
        $user = auth()->user();

        $applications = AccompanimentRequest::where('email', $user->email)
            ->latest()
            ->paginate(10);

        return view('client.applications.index', compact('applications'));
    }

    /**
     * Afficher le formulaire de création d'une nouvelle demande
     */
    public function create()
    {
        return view('client.applications.create');
    }

    /**
     * Enregistrer une nouvelle demande d'accompagnement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country_residence' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:120',
            'profession' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'desired_city' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'budget_range' => 'required|string|max:255',
            'personal_contribution_percentage' => 'required|integer|min:0|max:100',
            'additional_info' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        // Ajouter l'email de l'utilisateur connecté
        $validated['email'] = auth()->user()->email;
        $validated['status'] = 'pending';

        AccompanimentRequest::create($validated);

        return redirect()->route('client.applications.index')
            ->with('success', 'Votre demande d\'accompagnement a été soumise avec succès.');
    }

    /**
     * Afficher une demande spécifique
     */
    public function show(AccompanimentRequest $application)
    {
        // Vérifier que la demande appartient au client connecté
        if ($application->email !== auth()->user()->email) {
            abort(403, 'Accès non autorisé');
        }

        return view('client.applications.show', compact('application'));
    }

    /**
     * Afficher le formulaire d'édition (si la demande est encore en attente)
     */
    public function edit(AccompanimentRequest $application)
    {
        // Vérifier que la demande appartient au client connecté
        if ($application->email !== auth()->user()->email) {
            abort(403, 'Accès non autorisé');
        }

        // Ne permettre l'édition que si le statut est 'pending'
        if ($application->status !== 'pending') {
            return redirect()->route('client.applications.show', $application)
                ->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        return view('client.applications.edit', compact('application'));
    }

    /**
     * Mettre à jour une demande d'accompagnement
     */
    public function update(Request $request, AccompanimentRequest $application)
    {
        // Vérifier que la demande appartient au client connecté
        if ($application->email !== auth()->user()->email) {
            abort(403, 'Accès non autorisé');
        }

        // Ne permettre la modification que si le statut est 'pending'
        if ($application->status !== 'pending') {
            return redirect()->route('client.applications.show', $application)
                ->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country_residence' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:120',
            'profession' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'desired_city' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'budget_range' => 'required|string|max:255',
            'personal_contribution_percentage' => 'required|integer|min:0|max:100',
            'additional_info' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        $application->update($validated);

        return redirect()->route('client.applications.show', $application)
            ->with('success', 'Votre demande a été mise à jour avec succès.');
    }

    /**
     * Supprimer une demande (seulement si en attente)
     */
    public function destroy(AccompanimentRequest $application)
    {
        // Vérifier que la demande appartient au client connecté
        if ($application->email !== auth()->user()->email) {
            abort(403, 'Accès non autorisé');
        }

        // Ne permettre la suppression que si le statut est 'pending'
        if ($application->status !== 'pending') {
            return redirect()->route('client.applications.index')
                ->with('error', 'Cette demande ne peut pas être supprimée.');
        }

        $application->delete();

        return redirect()->route('client.applications.index')
            ->with('success', 'Votre demande a été supprimée.');
    }
}
