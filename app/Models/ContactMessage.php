<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ContactMessage extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_response',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Route notifications to the message sender's email
     */
    public function routeNotificationForMail(): string
    {
        return $this->email;
    }

    /**
     * Ajouter une réponse de l'admin
     */
    public function addResponse(string $response): void
    {
        $this->update([
            'admin_response' => $response,
            'responded_at' => now(),
            'status' => 'responded',
        ]);

        // Envoyer une notification par email à l'utilisateur
        $this->notify(new \App\Notifications\AdminResponseNotification($this, $response));
    }

    /**
     * Scope pour les messages non lus
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * Scope pour les messages récents
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
