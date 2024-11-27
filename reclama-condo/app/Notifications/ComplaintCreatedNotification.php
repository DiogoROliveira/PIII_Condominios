<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Complaint;
use Illuminate\Support\Facades\Crypt;

class ComplaintCreatedNotification extends Notification
{
    use Queueable;

    protected $complaint;

    /**
     * Cria uma nova instância de notificação.
     */
    public function __construct(Complaint $complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * Define os canais de entrega.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Conteúdo do email enviado ao usuário.
     */
    public function toMail($notifiable)
    {

        $notifiable->email = Crypt::decrypt($notifiable->email);

        return (new MailMessage)
            ->subject('New Complaint Created')
            ->greeting('Hello, ' . $notifiable->name)
            ->line('Your complaint has been successfully created.')
            ->line('Title: ' . $this->complaint->title)
            ->line('Description: ' . $this->complaint->description)
            ->action('View Complaints', url('/dashboard/complaints/' . $this->complaint->id))
            ->line('Thank you for using our complaint management system.');
    }
}
