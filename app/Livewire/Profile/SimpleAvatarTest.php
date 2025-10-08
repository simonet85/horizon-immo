<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SimpleAvatarTest extends Component
{
    public $currentAvatar;

    public function mount()
    {
        $this->currentAvatar = Auth::user()->avatar;
    }

    public function test()
    {
        session()->flash('status', 'Test successful!');
    }

    public function render()
    {
        return view('livewire.profile.simple-avatar-test');
    }
}
