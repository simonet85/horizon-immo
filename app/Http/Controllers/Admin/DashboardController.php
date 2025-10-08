<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccompanimentRequest;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Message;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_properties' => Property::count(),
            'available_properties' => Property::where('status', 'available')->count(),
            'featured_properties' => Property::where('is_featured', true)->count(),
            'total_users' => User::count(),
            'admin_users' => User::role('admin')->count(),
            'client_users' => User::role('client')->count(),
            'total_categories' => Category::where('is_active', true)->count(),
            'unread_contact_messages' => ContactMessage::where('status', 'unread')->count(),
            'unread_property_messages' => Message::where('is_read', false)->count(),
            'unread_messages' => ContactMessage::where('status', 'unread')->count() +
                               Message::where('is_read', false)->count(),
            'pending_applications' => AccompanimentRequest::where('status', 'pending')->count(),
        ];

        // Propriétés récentes
        $recentProperties = Property::latest()
            ->take(5)
            ->get();

        // Messages récents - Les deux types séparément
        $recentContactMessages = ContactMessage::latest()->take(3)->get();
        $recentPropertyMessages = Message::with(['property'])->latest()->take(3)->get();

        // Ajouter un type pour différencier dans la vue
        foreach ($recentContactMessages as $message) {
            $message->type = 'contact';
        }
        foreach ($recentPropertyMessages as $message) {
            $message->type = 'property';
        }

        // Combiner et trier par date
        $allMessages = collect($recentContactMessages)->concat($recentPropertyMessages);
        $recentMessages = $allMessages->sortByDesc('created_at')->take(5);        // Applications récentes
        $recentApplications = AccompanimentRequest::latest()
            ->take(5)
            ->get();

        // Statistiques mensuelles pour les graphiques
        $monthlyStats = $this->getMonthlyStats();

        return view('admin.dashboard', compact(
            'stats',
            'monthlyStats',
            'recentProperties',
            'recentMessages',
            'recentApplications'
        ));
    }

    private function getMonthlyStats()
    {
        $months = [];
        $propertiesData = [];
        $messagesData = [];
        $applicationsData = [];

        // Générer les données pour les 6 derniers mois
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            // Propriétés créées ce mois
            $propertiesData[] = Property::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Messages reçus ce mois
            $messagesData[] = ContactMessage::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Applications reçues ce mois
            $applicationsData[] = AccompanimentRequest::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return [
            'months' => $months,
            'properties' => $propertiesData,
            'messages' => $messagesData,
            'applications' => $applicationsData,
        ];
    }
}
