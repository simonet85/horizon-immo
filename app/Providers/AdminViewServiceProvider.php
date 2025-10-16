<?php

namespace App\Providers;

use App\Models\AccompanimentRequest;
use App\Models\Message;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AdminViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Partager les compteurs de notifications avec les vues admin
        // Utiliser '*' pour couvrir toutes les vues qui utilisent le layout admin
        View::composer('layouts.admin', function ($view) {
            $unreadMessagesCount = Message::unread()->count();
            $unreadContactMessagesCount = \App\Models\ContactMessage::unread()->count();
            $pendingApplicationsCount = AccompanimentRequest::where('status', 'pending')->count();

            $view->with([
                'unreadMessagesCount' => $unreadMessagesCount,
                'unreadContactMessagesCount' => $unreadContactMessagesCount,
                'pendingApplicationsCount' => $pendingApplicationsCount,
            ]);
        });
    }
}
