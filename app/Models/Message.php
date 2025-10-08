<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Message extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'property_id',
        'is_read',
        'read_at',
        'admin_response',
        'responded_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    /**
     * Relation avec la propriété concernée
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Marquer le message comme lu
     */
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Ajouter une réponse de l'admin
     */
    public function addResponse(string $response): void
    {
        $this->update([
            'admin_response' => $response,
            'responded_at' => now(),
            'is_read' => true,
            'read_at' => $this->read_at ?? now(),
        ]);

        // Envoyer une notification par email à l'utilisateur
        $this->notify(new \App\Notifications\AdminResponseNotification($this, $response));
    }

    /**
     * Scope pour les messages non lus
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope pour les messages récents
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Route notifications to the message sender's email
     */
    public function routeNotificationForMail(): string
    {
        return $this->email;
    }
}
