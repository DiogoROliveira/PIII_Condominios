<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Complaint;

class ComplaintUpdatedNotification extends Notification
{
    use Queueable;

    protected $complaint;

    public function __construct(Complaint $complaint)
    {
        $this->complaint = $complaint;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
                        ->subject('Complaint Update')
                        ->greeting('Hello, ' . $notifiable->name)
                        ->line('Your complaint has been updated.')

                        ->line('Current Status: ' . $this->complaint->status);

        if ($this->complaint->response) {
            $mailMessage->line('Administrator’s Response: ' . $this->complaint->response);
        }

        $mailMessage->action('View Complaint', url('dashboard/complaints/' . $this->complaint->id))
                    ->line('Thank you for using our complaint management system.');

        return $mailMessage;
    }

}
