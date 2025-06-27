<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\RecurringTransaction;

class RecurringTransactionNotification extends Notification
{
    use Queueable;

    protected $recurringTransaction;
    protected $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct(RecurringTransaction $recurringTransaction, $transaction = null)
    {
        $this->recurringTransaction = $recurringTransaction;
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
        $amount = number_format($this->recurringTransaction->amount, 2) . ' ' . $this->recurringTransaction->currency->code;
        
        return (new MailMessage)
                    ->subject('Transaction récurrente exécutée')
                    ->greeting('Bonjour ' . $notifiable->name . ' !')
                    ->line('Votre transaction récurrente a été exécutée avec succès.')
                    ->line('Détails de la transaction :')
                    ->line('• Description : ' . $this->recurringTransaction->description)
                    ->line('• Montant : ' . $amount)
                    ->line('• Compte : ' . $this->recurringTransaction->account->name)
                    ->line('• Catégorie : ' . $this->recurringTransaction->category->name)
                    ->action('Voir les détails', route('recurring-transactions.show', $this->recurringTransaction))
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
            'type' => 'recurring_transaction',
            'title' => 'Transaction récurrente exécutée',
            'message' => 'La transaction récurrente "' . $this->recurringTransaction->description . '" a été exécutée.',
            'amount' => $this->recurringTransaction->amount,
            'currency' => $this->recurringTransaction->currency->code,
            'account_name' => $this->recurringTransaction->account->name,
            'category_name' => $this->recurringTransaction->category->name,
            'recurring_transaction_id' => $this->recurringTransaction->id,
            'transaction_id' => $this->transaction ? $this->transaction->id : null,
            'created_at' => now(),
        ];
    }
}
