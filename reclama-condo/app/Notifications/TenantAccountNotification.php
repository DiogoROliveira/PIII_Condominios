<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Tenant;
use Illuminate\Support\Facades\Crypt;

class TenantAccountNotification extends Notification
{
    use Queueable;

    /**
     * The tenant instance.
     *
     * @var Tenant
     */
    protected $tenant;

    /**
     * Create a new notification instance.
     *
     * @param Tenant $tenant
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        // Decrypt email
        $notifiable->email = Crypt::decrypt($notifiable->email);

        // Prepare account information
        $accountInfo = $this->prepareAccountInformation();

        return (new MailMessage)
            ->subject(__('notifications.account_statement'))
            ->greeting(__('notifications.hello', ['name' => $notifiable->name]))
            ->line(__('notifications.account_details'))
            ->line('---')
            ->line(__('notifications.rented_units'))
            ->line($accountInfo['units'])
            ->line('---')
            ->line(__('notifications.payment_summary'))
            ->line(__('notifications.total_payments') . " €" . number_format($accountInfo['totalPayments'], 2))
            ->line(__('notifications.pending_payments') . " €" . number_format($accountInfo['pendingPayments'], 2))
            ->line(__('notifications.overdue_payments') . " €" . number_format($accountInfo['overduePayments'], 2))
            ->line('---')
            ->line(__('notifications.lease_details'))
            ->line(__('notifications.lease_start') . ": " . $this->tenant->lease_start_date)
            ->line(__('notifications.lease_end') . ": " . $this->tenant->lease_end_date)
            ->action(__('notifications.view_details'), url('dashboard/rents'))
            ->line(__('notifications.contact_management'))
            ->salutation(__('notifications.regards'));
    }

    /**
     * Prepare comprehensive account information.
     *
     * @return array
     */
    protected function prepareAccountInformation(): array
    {
        // Get all units for the tenant
        $units = $this->tenant->units;

        // Format units information
        $unitsInfo = $units->map(function ($unit) {
            return sprintf(
                __("Unit %s in Block %s"),
                $unit->unit_number,
                $unit->block->block
            );
        })->implode(', ');

        // Calculate payment details
        $monthlyPayments = $this->tenant->monthly_payments;

        return [
            'units' => $unitsInfo ?: __('No units assigned'),
            'totalPayments' => $monthlyPayments->sum('amount'),
            'pendingPayments' => $monthlyPayments->where('status', 'pending')->sum('amount'),
            'overduePayments' => $monthlyPayments->where('status', 'overdue')->sum('amount'),
        ];
    }
}
