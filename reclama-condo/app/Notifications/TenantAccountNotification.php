<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class TenantAccountNotification extends Notification
{
    use Queueable;

    /**
     * The user instance.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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

        $mailMessage = (new MailMessage)
            ->subject(__('notifications.account_statement'))
            ->greeting(__('notifications.hello', ['name' => $notifiable->name]))
            ->line(__('notifications.account_details'))
            ->line('---')
            ->line(__('notifications.rented_units'));

        // Add units information grouped by condominium
        foreach ($accountInfo['unitsByCondominium'] as $condominium => $units) {
            $mailMessage->line($condominium . ':')
                ->line($units);
        }

        $mailMessage->line('---')
            ->line(__('notifications.payment_summary'))
            ->line(__('notifications.total_payments') . " €" . number_format($accountInfo['totalPayments'], 2))
            ->line(__('notifications.pending_payments') . " €" . number_format($accountInfo['pendingPayments'], 2))
            ->line(__('notifications.overdue_payments') . " €" . number_format($accountInfo['overduePayments'], 2))
            ->line('---')
            ->line(__('notifications.lease_details'));

        // Add lease dates for each unit
        foreach ($accountInfo['leaseDates'] as $unitInfo => $dates) {
            $mailMessage->line($unitInfo . ':')
                ->line(__('notifications.lease_start') . ": " . $dates['start'])
                ->line(__('notifications.lease_end') . ": " . $dates['end']);
        }

        return $mailMessage
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
        $unitsByCondominium = [];
        $leaseDates = [];
        $totalPayments = 0;
        $pendingPayments = 0;
        $overduePayments = 0;

        foreach ($this->user->tenants as $tenant) {
            // Get payments
            $monthlyPayments = $tenant->monthly_payments;
            $totalPayments += $monthlyPayments->sum('amount');
            $pendingPayments += $monthlyPayments->where('status', 'pending')->sum('amount');
            $overduePayments += $monthlyPayments->where('status', 'overdue')->sum('amount');

            // Group units by condominium
            foreach ($tenant->units as $unit) {
                $condominiumName = $unit->block->condominium->name;

                if (!isset($unitsByCondominium[$condominiumName])) {
                    $unitsByCondominium[$condominiumName] = [];
                }

                $unitInfo = sprintf(
                    __("Unit %s in Block %s"),
                    $unit->unit_number,
                    $unit->block->block
                );

                $unitsByCondominium[$condominiumName][] = $unitInfo;

                // Store lease dates for each unit
                $leaseDates[$unitInfo] = [
                    'start' => $tenant->lease_start_date,
                    'end' => $tenant->lease_end_date
                ];
            }
        }

        // Convert unit arrays to strings
        foreach ($unitsByCondominium as $condominium => $units) {
            $unitsByCondominium[$condominium] = implode(', ', $units);
        }

        return [
            'unitsByCondominium' => $unitsByCondominium,
            'leaseDates' => $leaseDates,
            'totalPayments' => $totalPayments,
            'pendingPayments' => $pendingPayments,
            'overduePayments' => $overduePayments,
        ];
    }
}
