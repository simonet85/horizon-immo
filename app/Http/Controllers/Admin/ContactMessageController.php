<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()
            ->paginate(15);

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        // Marquer comme lu
        if ($contactMessage->status === 'unread') {
            $contactMessage->update(['status' => 'read']);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->update(['status' => 'read']);

        return back()->with('success', 'Message marqué comme lu');
    }

    public function markAsUnread(ContactMessage $contactMessage)
    {
        $contactMessage->update(['status' => 'unread']);

        return back()->with('success', 'Message marqué comme non lu');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return back()->with('success', 'Message supprimé avec succès');
    }

    /**
     * Ajouter une réponse à un message
     */
    public function respond(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'admin_response' => 'required|string',
        ]);

        $contactMessage->addResponse($validated['admin_response']);

        return redirect()->route('admin.contact-messages.show', $contactMessage)
            ->with('success', 'Réponse envoyée avec succès par email.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'messages' => 'required|array',
            'action' => 'required|in:mark_read,mark_unread,delete',
        ]);

        $messages = ContactMessage::whereIn('id', $request->messages);

        switch ($request->action) {
            case 'mark_read':
                $messages->update(['status' => 'read']);

                return back()->with('success', 'Messages marqués comme lus');
            case 'mark_unread':
                $messages->update(['status' => 'unread']);

                return back()->with('success', 'Messages marqués comme non lus');
            case 'delete':
                $messages->delete();

                return back()->with('success', 'Messages supprimés');
        }
    }
}
