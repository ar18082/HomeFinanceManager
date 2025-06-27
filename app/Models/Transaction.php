<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'currency_id',
        'amount',
        'type',
        'date',
        'description',
        'status',
        'transfer_transaction_id',
        'recurring_transaction_id',
        'destination_account_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function destinationAccount()
    {
        return $this->belongsTo(Account::class, 'destination_account_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function transferTransaction()
    {
        return $this->belongsTo(Transaction::class, 'transfer_transaction_id');
    }

    public function recurringTransaction()
    {
        return $this->belongsTo(RecurringTransaction::class);
    }
}
