<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'energy_provider_id',
        'energy_meter_id',
        'contract_number',
        'type',
        'tariff_structure',
        'start_date',
        'end_date',
        'monthly_fee',
        'annual_fee',
        'notes',
        'active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'monthly_fee' => 'decimal:2',
        'annual_fee' => 'decimal:2',
        'active' => 'boolean'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(EnergyProvider::class, 'energy_provider_id');
    }

    public function meter()
    {
        return $this->belongsTo(EnergyMeter::class, 'energy_meter_id');
    }

    public function readings()
    {
        return $this->hasMany(EnergyReading::class, 'energy_contract_id');
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

    public function scopeByProvider($query, $providerId)
    {
        return $query->where('energy_provider_id', $providerId);
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

    public function getTariffStructureLabelAttribute()
    {
        return match($this->tariff_structure) {
            'single' => 'Tarif unique',
            'day_night' => 'Jour/Nuit',
            'peak_offpeak' => 'Heures pleines/creuses',
            default => $this->tariff_structure
        };
    }

    public function getFormattedMonthlyFeeAttribute()
    {
        return number_format($this->monthly_fee, 2) . ' €/mois';
    }

    public function getFormattedAnnualFeeAttribute()
    {
        return number_format($this->annual_fee, 2) . ' €/an';
    }

    public function isActive()
    {
        if (!$this->active) {
            return false;
        }

        $now = now();
        if ($this->start_date && $this->start_date > $now) {
            return false;
        }

        if ($this->end_date && $this->end_date < $now) {
            return false;
        }

        return true;
    }

    public function getCurrentTariffs($date = null)
    {
        if (!$date) {
            $date = now();
        }

        return $this->provider->getActiveTariffs($this->type, $date);
    }

    public function calculateReadingCost($reading)
    {
        $tariffs = $this->getCurrentTariffs($reading->reading_date);
        $totalCost = 0;
        $breakdown = [];

        foreach ($tariffs as $tariff) {
            $consumption = $reading->consumption;
            
            // Si tarif jour/nuit, répartir la consommation
            if ($tariff->period_type === 'day_night' && $this->tariff_structure === 'day_night') {
                // Par défaut, 70% jour, 30% nuit (à ajuster selon vos besoins)
                $dayConsumption = $consumption * 0.7;
                $nightConsumption = $consumption * 0.3;
                
                if (str_contains(strtolower($tariff->name), 'jour')) {
                    $consumption = $dayConsumption;
                } elseif (str_contains(strtolower($tariff->name), 'nuit')) {
                    $consumption = $nightConsumption;
                }
            }

            $costHT = $consumption * $tariff->rate;
            $tva = $costHT * ($tariff->tva_rate / 100);
            $costTTC = $costHT + $tva;

            $breakdown[$tariff->name] = [
                'consumption' => $consumption,
                'rate' => $tariff->rate,
                'cost_ht' => $costHT,
                'tva_rate' => $tariff->tva_rate,
                'tva_amount' => $tva,
                'cost_ttc' => $costTTC
            ];

            $totalCost += $costTTC;
        }

        return [
            'total_cost' => $totalCost,
            'breakdown' => $breakdown
        ];
    }
} 