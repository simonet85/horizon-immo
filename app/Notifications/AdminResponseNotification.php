<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Message|ContactMessage $message,
        public string $adminResponse
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $isPropertyMessage = $this->message instanceof Message;
        $propertyTitle = $isPropertyMessage ? $this->message->property?->title : null;

        $mail = (new MailMessage)
            ->subject('Réponse à votre message - ZB Investments')
            ->bcc(config('mail.from.address')) // Copie vers l'email professionnel
            ->greeting('Bonjour '.$this->message->name.',')
            ->line('Nous avons bien reçu votre message et voici notre réponse :');

        if ($propertyTitle) {
            $mail->line('**Propriété concernée :** '.$propertyTitle);
        }

        $mail->line('**Votre message original :**')
            ->line('"'.$this->message->message.'"')
            ->line('**Notre réponse :**')
            ->line($this->adminResponse)
            ->line('Si vous avez d\'autres questions, n\'hésitez pas à nous contacter.')
            ->salutation('L\'équipe ZB Investments');

        // Note: Property link temporarily disabled due to routing issues
        // Will be re-enabled once route is properly configured
        // if ($propertyTitle) {
        //     $mail->action('Voir la propriété', route('property.detail', $this->message->property_id));
        // }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'message_type' => get_class($this->message),
            'admin_response' => $this->adminResponse,
            'property_title' => $this->message instanceof Message ? $this->message->property?->title : null,
        ];
    }
}
