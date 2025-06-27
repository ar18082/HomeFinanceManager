<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    // Types de compte
    public const TYPE_CHECKING = 'checking';
    public const TYPE_SAVINGS = 'savings';
    public const TYPE_CASH = 'cash';
    public const TYPE_CREDIT = 'credit_card';
    public const TYPE_INVESTMENT = 'investment';

    public const TYPES = [
        self::TYPE_CHECKING,
        self::TYPE_SAVINGS,
        self::TYPE_CASH,
        self::TYPE_CREDIT,
        self::TYPE_INVESTMENT
    ];

    protected $fillable = [
        'user_id',
        'currency_id',
        'name',
        'type',
        'initial_balance',
        'current_balance',
        'description',
        'include_in_net_worth',
        'active'
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'include_in_net_worth' => 'boolean',
        'active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    public function scopeIncludedInNetWorth(Builder $query): void
    {
        $query->where('include_in_net_worth', true);
    }
}
