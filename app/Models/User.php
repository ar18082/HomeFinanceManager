<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the transactions for the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the accounts for the user.
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * Get the recurring transactions for the user.
     */
    public function recurringTransactions()
    {
        return $this->hasMany(RecurringTransaction::class);
    }

    /**
     * Get the savings goals for the user.
     */
    public function savingsGoals()
    {
        return $this->hasMany(SavingsGoal::class);
    }

    /**
     * Get the credits for the user.
     */
    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

    /**
     * Get the energy meters for the user.
     */
    public function energyMeters()
    {
        return $this->hasMany(EnergyMeter::class);
    }

    /**
     * Get the energy readings for the user.
     */
    public function energyReadings()
    {
        return $this->hasMany(EnergyReading::class);
    }
}
