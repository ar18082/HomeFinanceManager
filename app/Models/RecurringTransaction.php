<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class RecurringTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'currency_id',
        'type',
        'amount',
        'description',
        'frequency',
        'interval',
        'start_date',
        'end_date',
        'last_generated',
        'times_to_run',
        'times_run',
        'active',
        'notes',
        'destination_account_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'last_generated' => 'date',
        'active' => 'boolean',
        'amount' => 'decimal:2',
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function destinationAccount()
    {
        return $this->belongsTo(Account::class, 'destination_account_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeDue($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->where(function ($q) {
                        // N'a pas encore atteint le nombre maximum d'exécutions
                        $q->whereNull('times_to_run')
                          ->orWhere('times_run', '<', 'times_to_run');
                    })
                    // Et n'a pas dépassé la date de fin
                    ->where(function ($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    });
            });
    }

    // Méthodes
    public function getNextDueDate()
    {
        $lastDate = $this->last_generated ?? $this->start_date;
        $interval = $this->interval;

        return match ($this->frequency) {
            'daily' => $lastDate->addDays($interval),
            'weekly' => $lastDate->addWeeks($interval),
            'monthly' => $lastDate->addMonths($interval),
            'yearly' => $lastDate->addYears($interval),
            default => null,
        };
    }

    public function shouldGenerate()
    {
        if (!$this->active) {
            return false;
        }

        if ($this->times_to_run !== null && $this->times_run >= $this->times_to_run) {
            return false;
        }

        if ($this->end_date !== null && $this->end_date < now()) {
            return false;
        }

        $nextDueDate = $this->getNextDueDate();
        return $nextDueDate && $nextDueDate <= now();
    }

    public function generateTransaction()
    {
        if (!$this->shouldGenerate()) {
            return null;
        }

        $transaction = Transaction::create([
            'user_id' => $this->user_id,
            'account_id' => $this->account_id,
            'category_id' => $this->category_id,
            'currency_id' => $this->currency_id,
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => now(),
            'destination_account_id' => $this->destination_account_id,
            'recurring_transaction_id' => $this->id,
        ]);

        $this->update([
            'last_generated' => now(),
            'times_run' => $this->times_run + 1,
        ]);

        return $transaction;
    }
} 