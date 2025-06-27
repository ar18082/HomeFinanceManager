<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SavingsGoal;

class SavingsGoalNotification extends Notification
{
    use Queueable;

    protected $savingsGoal;
    protected $transaction;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(SavingsGoal $savingsGoal, $transaction = null, $type = 'contribution')
    {
        $this->savingsGoal = $savingsGoal;
        $this->transaction = $transaction;
        $this->type = $type; // 'contribution' ou 'completed'
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
        if ($this->type === 'completed') {
            return (new MailMessage)
                        ->subject('Objectif d\'épargne atteint !')
                        ->greeting('Félicitations ' . $notifiable->name . ' !')
                        ->line('Vous avez atteint votre objectif d\'épargne !')
                        ->line('Détails :')
                        ->line('• Objectif : ' . $this->savingsGoal->name)
                        ->line('• Montant cible : ' . number_format($this->savingsGoal->target_amount, 2) . ' ' . $this->savingsGoal->currency->code)
                        ->line('• Montant actuel : ' . number_format($this->savingsGoal->current_amount, 2) . ' ' . $this->savingsGoal->currency->code)
                        ->action('Voir les détails', route('savings-goals.show', $this->savingsGoal))
                        ->line('Continuez comme ça !');
        }

        $amount = $this->transaction ? number_format($this->transaction->amount, 2) . ' ' . $this->transaction->currency->code : '';
        $progress = number_format($this->savingsGoal->getProgressPercentage(), 1) . '%';
        
        return (new MailMessage)
                    ->subject('Contribution à l\'objectif d\'épargne')
                    ->greeting('Bonjour ' . $notifiable->name . ' !')
                    ->line('Une contribution a été ajoutée à votre objectif d\'épargne.')
                    ->line('Détails :')
                    ->line('• Objectif : ' . $this->savingsGoal->name)
                    ->line('• Contribution : ' . $amount)
                    ->line('• Progression : ' . $progress)
                    ->line('• Compte : ' . $this->savingsGoal->account->name)
                    ->action('Voir les détails', route('savings-goals.show', $this->savingsGoal))
                    ->line('Continuez à épargner !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if ($this->type === 'completed') {
            return [
                'type' => 'savings_goal_completed',
                'title' => 'Objectif d\'épargne atteint !',
                'message' => 'Félicitations ! Vous avez atteint votre objectif "' . $this->savingsGoal->name . '".',
                'target_amount' => $this->savingsGoal->target_amount,
                'current_amount' => $this->savingsGoal->current_amount,
                'currency' => $this->savingsGoal->currency->code,
                'account_name' => $this->savingsGoal->account->name,
                'savings_goal_id' => $this->savingsGoal->id,
                'created_at' => now(),
            ];
        }

        return [
            'type' => 'savings_goal_contribution',
            'title' => 'Contribution à l\'objectif d\'épargne',
            'message' => 'Une contribution a été ajoutée à votre objectif "' . $this->savingsGoal->name . '".',
            'amount' => $this->transaction ? $this->transaction->amount : 0,
            'currency' => $this->savingsGoal->currency->code,
            'progress_percentage' => $this->savingsGoal->getProgressPercentage(),
            'account_name' => $this->savingsGoal->account->name,
            'savings_goal_id' => $this->savingsGoal->id,
            'transaction_id' => $this->transaction ? $this->transaction->id : null,
            'created_at' => now(),
        ];
    }
}
