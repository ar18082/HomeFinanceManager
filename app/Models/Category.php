<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    // Types de catégorie
    public const TYPE_EXPENSE = 'expense';
    public const TYPE_INCOME = 'income';

    public const TYPES = [
        self::TYPE_EXPENSE,
        self::TYPE_INCOME
    ];

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'color',
        'icon',
        'description',
        'parent_id',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    public function scopeExpenses(Builder $query): void
    {
        $query->where('type', self::TYPE_EXPENSE);
    }

    public function scopeIncomes(Builder $query): void
    {
        $query->where('type', self::TYPE_INCOME);
    }

    public function isExpense(): bool
    {
        return $this->type === self::TYPE_EXPENSE;
    }

    public function isIncome(): bool
    {
        return $this->type === self::TYPE_INCOME;
    }
}
