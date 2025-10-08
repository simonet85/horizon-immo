<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
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
        // Partager le compteur de messages non lus avec le layout admin
        View::composer('layouts.admin', function ($view) {
            $unreadMessagesCount = Message::unread()->count();
            $view->with('unreadMessagesCount', $unreadMessagesCount);
        });
    }
}
