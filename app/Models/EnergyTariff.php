<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyTariff extends Model
{
    use HasFactory;

    protected $fillable = [
        'energy_provider_id',
        'name',
        'type',
        'period_type',
        'rate',
        'unit',
        'tva_rate',
        'start_date',
        'end_date',
        'active',
        'notes'
    ];

    protected $casts = [
        'rate' => 'decimal:6',
        'tva_rate' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean'
    ];

    // Relations
    public function provider()
    {
        return $this->belongsTo(EnergyProvider::class, 'energy_provider_id');
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

    public function scopeByPeriodType($query, $periodType)
    {
        return $query->where('period_type', $periodType);
    }

    public function scopeValidForDate($query, $date)
    {
        return $query->where(function($q) use ($date) {
            $q->whereNull('start_date')
              ->orWhere('start_date', '<=', $date);
        })->where(function($q) use ($date) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', $date);
        });
    }

    // Méthodes utilitaires
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'energy' => 'Énergie',
            'distribution' => 'Distribution',
            'transport' => 'Transport',
            'tax' => 'Taxe',
            'fixed' => 'Frais fixes',
            default => $this->type
        };
    }

    public function getPeriodTypeLabelAttribute()
    {
        return match($this->period_type) {
            'single' => 'Tarif unique',
            'day_night' => 'Jour/Nuit',
            'peak_offpeak' => 'Heures pleines/creuses',
            default => $this->period_type
        };
    }

    public function getFormattedRateAttribute()
    {
        return number_format($this->rate, 6) . ' €/' . $this->unit;
    }

    public function getFormattedTvaRateAttribute()
    {
        return number_format($this->tva_rate, 2) . '%';
    }

    public function calculateCost($consumption)
    {
        $costHT = $consumption * $this->rate;
        $tva = $costHT * ($this->tva_rate / 100);
        $costTTC = $costHT + $tva;

        return [
            'consumption' => $consumption,
            'rate' => $this->rate,
            'cost_ht' => $costHT,
            'tva_rate' => $this->tva_rate,
            'tva_amount' => $tva,
            'cost_ttc' => $costTTC
        ];
    }
} 