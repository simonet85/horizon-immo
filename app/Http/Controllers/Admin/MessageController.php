<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Property;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::with('property')
            ->recent()
            ->paginate(15);

        $unreadCount = Message::unread()->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::orderBy('title')->get();

        return view('admin.messages.create', compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'property_id' => 'nullable|exists:properties,id',
        ]);

        Message::create($validated);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        // Marquer comme lu si pas encore lu
        if (! $message->is_read) {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        $properties = Property::orderBy('title')->get();

        return view('admin.messages.edit', compact('message', 'properties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'property_id' => 'nullable|exists:properties,id',
            'admin_response' => 'nullable|string',
        ]);

        // Si une réponse admin est ajoutée, marquer comme répondu
        if (! empty($validated['admin_response']) && empty($message->admin_response)) {
            $validated['responded_at'] = now();
        }

        $message->update($validated);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message supprimé avec succès.');
    }

    /**
     * Marquer un message comme lu
     */
    public function markAsRead(Message $message)
    {
        $message->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Ajouter une réponse à un message
     */
    public function respond(Request $request, Message $message)
    {
        $validated = $request->validate([
            'admin_response' => 'required|string',
        ]);

        $message->addResponse($validated['admin_response']);

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Réponse envoyée avec succès par email à '.$message->email);
    }
}
