<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Component;

class ContactPage extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $message = '';
    public $showSuccess = false;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10'
    ];

    protected $messages = [
        'first_name.required' => 'Le prénom est requis',
        'last_name.required' => 'Le nom est requis',
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email doit être valide',
        'phone.required' => 'Le téléphone est requis',
        'subject.required' => 'Le sujet est requis',
        'message.required' => 'Le message est requis',
        'message.min' => 'Le message doit contenir au moins 10 caractères'
    ];

    public function sendMessage()
    {
        $this->validate();

        ContactMessage::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $this->reset(['first_name', 'last_name', 'email', 'phone', 'subject', 'message']);
        $this->showSuccess = true;

        // Auto-hide success message after 5 seconds
        $this->dispatch('hideSuccess');
    }

    public function render()
    {
        return view('livewire.contact-page')->layout('layouts.site');
    }
}
