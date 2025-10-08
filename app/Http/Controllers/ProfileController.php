<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // Si l'utilisateur a un rôle admin ou client, utiliser le layout admin
        if ($user->hasAnyRole(['admin', 'client'])) {
            return view('profile-admin');
        }

        // Sinon, utiliser la vue profile standard
        return view('profile');
    }

    public function show()
    {
        return $this->edit();
    }
}
