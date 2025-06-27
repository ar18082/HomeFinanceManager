<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'amount',
        'interest_rate',
        'duration_months',
        'start_date',
        'end_date',
        'monthly_payment',
        'total_interest',
        'total_amount',
        'remaining_balance',
        'account_id',
        'currency_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'total_interest' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le compte
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Relation avec la devise
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Calculer la date de fin basée sur la durée
     */
    public function calculateEndDate(): void
    {
        $this->end_date = $this->start_date->addMonths($this->duration_months);
    }

    /**
     * Calculer la mensualité
     */
    public function calculateMonthlyPayment(): void
    {
        $monthlyRate = $this->interest_rate / 100 / 12;
        $this->monthly_payment = $this->amount * ($monthlyRate * pow(1 + $monthlyRate, $this->duration_months)) / (pow(1 + $monthlyRate, $this->duration_months) - 1);
    }

    /**
     * Calculer les intérêts totaux
     */
    public function calculateTotalInterest(): void
    {
        $this->total_interest = ($this->monthly_payment * $this->duration_months) - $this->amount;
    }

    /**
     * Calculer le montant total à rembourser
     */
    public function calculateTotalAmount(): void
    {
        $this->total_amount = $this->amount + $this->total_interest;
    }

    /**
     * Calculer le solde restant
     */
    public function calculateRemainingBalance(): void
    {
        $monthsElapsed = $this->start_date->diffInMonths(now());
        $monthsElapsed = min($monthsElapsed, $this->duration_months);
        
        $monthlyRate = $this->interest_rate / 100 / 12;
        $this->remaining_balance = $this->amount * (pow(1 + $monthlyRate, $this->duration_months) - pow(1 + $monthlyRate, $monthsElapsed)) / (pow(1 + $monthlyRate, $this->duration_months) - 1);
    }

    /**
     * Calculer tous les montants
     */
    public function calculateAllAmounts(): void
    {
        $this->calculateEndDate();
        $this->calculateMonthlyPayment();
        $this->calculateTotalInterest();
        $this->calculateTotalAmount();
        $this->calculateRemainingBalance();
    }

    /**
     * Obtenir le pourcentage de progression
     */
    public function getProgressPercentage(): float
    {
        if ($this->total_amount <= 0) {
            return 0;
        }
        
        $paid = $this->total_amount - $this->remaining_balance;
        return min(100, ($paid / $this->total_amount) * 100);
    }

    /**
     * Obtenir le nombre de mois restants
     */
    public function getRemainingMonths(): int
    {
        return max(0, $this->end_date->diffInMonths(now()));
    }

    /**
     * Vérifier si le crédit est terminé
     */
    public function isCompleted(): bool
    {
        return $this->remaining_balance <= 0 || now()->isAfter($this->end_date);
    }

    /**
     * Scope pour les crédits actifs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope pour les crédits terminés
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
} 