<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AccompanimentRequest;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistiques du client
        $stats = [
            'total_applications' => AccompanimentRequest::where('email', $user->email)->count(),
            'pending_applications' => AccompanimentRequest::where('email', $user->email)
                ->where('status', 'pending')->count(),
            'approved_applications' => AccompanimentRequest::where('email', $user->email)
                ->where('status', 'approved')->count(),
            'total_messages' => ContactMessage::where('email', $user->email)->count(),
        ];

        // Applications récentes du client
        $recentApplications = AccompanimentRequest::where('email', $user->email)
            ->latest()
            ->take(5)
            ->get();

        // Messages récents du client
        $recentMessages = ContactMessage::where('email', $user->email)
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact(
            'stats',
            'recentApplications',
            'recentMessages'
        ));
    }
}
