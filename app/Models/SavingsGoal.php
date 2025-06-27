<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SavingsGoal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'account_id',
        'currency_id',
        'name',
        'target_amount',
        'current_amount',
        'target_date',
        'icon',
        'color',
        'description',
        'active',
        'completed',
        'completed_at'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'target_date' => 'date',
        'completed_at' => 'date',
        'active' => 'boolean',
        'completed' => 'boolean'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true)->where('completed', false);
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    // Méthodes
    public function getProgressPercentage()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        return min(100, ($this->current_amount / $this->target_amount) * 100);
    }

    public function getRemainingAmount()
    {
        return max(0, $this->target_amount - $this->current_amount);
    }

    public function getDaysRemaining()
    {
        if ($this->completed) {
            return 0;
        }
        return max(0, Carbon::now()->startOfDay()->diffInDays($this->target_date, false));
    }

    public function getMonthlyTargetAmount()
    {
        $daysRemaining = $this->getDaysRemaining();
        if ($daysRemaining <= 0) {
            return 0;
        }
        $monthsRemaining = $daysRemaining / 30;
        return $this->getRemainingAmount() / $monthsRemaining;
    }

    public function checkAndUpdateCompletion()
    {
        if (!$this->completed && $this->current_amount >= $this->target_amount) {
            $this->update([
                'completed' => true,
                'completed_at' => Carbon::now()
            ]);
            return true;
        }
        return false;
    }

    public function addProgress($amount)
    {
        if ($this->completed) {
            return false;
        }

        $this->current_amount += $amount;
        $this->save();
        
        // Créer une transaction pour la contribution
        $transaction = \App\Models\Transaction::create([
            'user_id' => $this->user_id,
            'account_id' => $this->account_id,
            'category_id' => $this->getSavingsCategoryId(),
            'currency_id' => $this->currency_id,
            'type' => 'income',
            'amount' => $amount,
            'description' => 'Contribution - ' . $this->name,
            'date' => now(),
        ]);

        // Envoyer la notification de contribution
        $this->user->notify(new \App\Notifications\SavingsGoalNotification($this, $transaction, 'contribution'));
        
        $completed = $this->checkAndUpdateCompletion();
        
        // Si l'objectif est atteint, envoyer une notification de félicitations
        if ($completed) {
            $this->user->notify(new \App\Notifications\SavingsGoalNotification($this, $transaction, 'completed'));
        }
        
        return $completed;
    }

    /**
     * Obtenir l'ID de la catégorie "Épargne" pour l'utilisateur
     */
    private function getSavingsCategoryId()
    {
        // Chercher une catégorie "Épargne" existante
        $savingsCategory = \App\Models\Category::where('user_id', $this->user_id)
            ->where('name', 'Épargne')
            ->first();

        if (!$savingsCategory) {
            // Créer la catégorie si elle n'existe pas
            $savingsCategory = \App\Models\Category::create([
                'user_id' => $this->user_id,
                'name' => 'Épargne',
                'type' => 'income',
                'color' => '#059669', // Vert
                'icon' => 'piggy-bank',
            ]);
        }

        return $savingsCategory->id;
    }
}
