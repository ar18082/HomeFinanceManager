<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnergyMeter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'meter_number',
        'location',
        'unit',
        'current_reading',
        'last_reading_date',
        'notes',
        'active'
    ];

    protected $casts = [
        'current_reading' => 'decimal:3',
        'last_reading_date' => 'date',
        'active' => 'boolean'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function readings()
    {
        return $this->hasMany(EnergyReading::class)->orderBy('reading_date', 'desc');
    }

    public function latestReading()
    {
        return $this->hasOne(EnergyReading::class)->latest('reading_date');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Méthodes utilitaires
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'electricity' => 'Électricité',
            'gas' => 'Gaz',
            'water' => 'Eau',
            default => $this->type
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'electricity' => '⚡',
            'gas' => '🔥',
            'water' => '💧',
            default => '📊'
        };
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'electricity' => '#FFD700',
            'gas' => '#FF6B35',
            'water' => '#4FC3F7',
            default => '#9E9E9E'
        };
    }

    // Calculer la consommation totale
    public function getTotalConsumptionAttribute()
    {
        return $this->readings()->sum('consumption');
    }

    // Calculer le coût total
    public function getTotalCostAttribute()
    {
        return $this->readings()->sum('cost');
    }

    // Obtenir la consommation du dernier mois
    public function getLastMonthConsumptionAttribute()
    {
        $lastMonth = now()->subMonth();
        return $this->readings()
            ->whereYear('reading_date', $lastMonth->year)
            ->whereMonth('reading_date', $lastMonth->month)
            ->sum('consumption');
    }

    // Obtenir le coût du dernier mois
    public function getLastMonthCostAttribute()
    {
        $lastMonth = now()->subMonth();
        return $this->readings()
            ->whereYear('reading_date', $lastMonth->year)
            ->whereMonth('reading_date', $lastMonth->month)
            ->sum('cost');
    }
} 