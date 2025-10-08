<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Afficher la liste des messages du client
     */
    public function index()
    {
        $user = auth()->user();

        // Récupérer les messages liés aux propriétés ET les messages de contact du client
        $propertyMessages = Message::where('email', $user->email)
            ->with('property')
            ->latest()
            ->get();

        $contactMessages = ContactMessage::where('email', $user->email)
            ->latest()
            ->get();

        return view('client.messages.index', compact('propertyMessages', 'contactMessages'));
    }

    /**
     * Afficher un message spécifique
     */
    public function show(Message $message)
    {
        // Vérifier que le message appartient au client connecté
        if ($message->email !== auth()->user()->email) {
            abort(403, 'Accès non autorisé');
        }

        return view('client.messages.show', compact('message'));
    }

    /**
     * Afficher un message de contact spécifique
     */
    public function showContact(ContactMessage $contactMessage)
    {
        // Vérifier que le message appartient au client connecté
        if ($contactMessage->email !== auth()->user()->email) {
            abort(403, 'Accès non autorisé');
        }

        return view('client.messages.show-contact', compact('contactMessage'));
    }
}
