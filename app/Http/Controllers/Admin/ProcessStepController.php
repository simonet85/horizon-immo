<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessStepController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:content.manage');
    }

    /**
     * Store a newly created process step in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'required|integer|min:0',
            'active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['active'] = $request->has('active');

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('process-steps', 'public');
            $data['icon'] = $iconPath;
        }

        ProcessStep::create($data);

        return redirect()->route('admin.home-content.index')
            ->with('success', 'Étape de processus créée avec succès.');
    }

    /**
     * Show the form for creating a new process step.
     */
    public function create()
    {
        return view('admin.process-steps.create');
    }

    /**
     * Show the form for editing the specified process step.
     */
    public function edit(ProcessStep $processStep)
    {
        return view('admin.process-steps.edit', compact('processStep'));
    }

    /**
     * Update the specified process step in storage.
     */
    public function update(Request $request, ProcessStep $processStep)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'required|integer|min:0',
            'active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['active'] = $request->has('active');

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($processStep->icon) {
                Storage::disk('public')->delete($processStep->icon);
            }

            $iconPath = $request->file('icon')->store('process-steps', 'public');
            $data['icon'] = $iconPath;
        }

        $processStep->update($data);

        return redirect()->route('admin.home-content.index')
            ->with('success', 'Étape de processus mise à jour avec succès.');
    }

    /**
     * Remove the specified process step from storage.
     */
    public function destroy(ProcessStep $processStep)
    {
        // Delete icon file
        if ($processStep->icon) {
            Storage::disk('public')->delete($processStep->icon);
        }

        $processStep->delete();

        return redirect()->route('admin.home-content.index')
            ->with('success', 'Étape de processus supprimée avec succès.');
    }
}
