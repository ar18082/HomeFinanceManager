<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Credit;

class CreditPaymentNotification extends Notification
{
    use Queueable;

    protected $credit;
    protected $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct(Credit $credit, $transaction = null)
    {
        $this->credit = $credit;
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $amount = number_format($this->credit->monthly_payment, 2) . ' ' . $this->credit->currency->code;
        $remainingBalance = number_format($this->credit->remaining_balance, 2) . ' ' . $this->credit->currency->code;
        
        return (new MailMessage)
                    ->subject('Paiement de crédit effectué')
                    ->greeting('Bonjour ' . $notifiable->name . ' !')
                    ->line('Votre paiement de crédit mensuel a été effectué avec succès.')
                    ->line('Détails du paiement :')
                    ->line('• Crédit : ' . $this->credit->name)
                    ->line('• Montant payé : ' . $amount)
                    ->line('• Solde restant : ' . $remainingBalance)
                    ->line('• Compte : ' . $this->credit->account->name)
                    ->action('Voir les détails', route('credits.show', $this->credit))
                    ->line('Merci d\'utiliser notre application de gestion financière !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'credit_payment',
            'title' => 'Paiement de crédit effectué',
            'message' => 'Le paiement mensuel pour le crédit "' . $this->credit->name . '" a été effectué.',
            'amount' => $this->credit->monthly_payment,
            'currency' => $this->credit->currency->code,
            'remaining_balance' => $this->credit->remaining_balance,
            'account_name' => $this->credit->account->name,
            'credit_id' => $this->credit->id,
            'transaction_id' => $this->transaction ? $this->transaction->id : null,
            'created_at' => now(),
        ];
    }
}
