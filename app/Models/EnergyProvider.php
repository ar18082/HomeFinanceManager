<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'website',
        'contact_email',
        'contact_phone',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    // Relations
    public function tariffs()
    {
        return $this->hasMany(EnergyTariff::class);
    }

    public function contracts()
    {
        return $this->hasMany(EnergyContract::class);
    }

    public function readings()
    {
        return $this->hasMany(EnergyReading::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Méthodes utilitaires
    public function getActiveTariffs($type = null, $date = null)
    {
        $query = $this->tariffs()->active();
        
        if ($type) {
            $query->where('type', $type);
        }
        
        if ($date) {
            $query->where(function($q) use ($date) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', $date);
            })->where(function($q) use ($date) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', $date);
            });
        }
        
        return $query->get();
    }

    public function calculateCost($consumption, $type = 'electricity', $date = null, $periodType = 'single')
    {
        $tariffs = $this->getActiveTariffs($type, $date);
        $totalCost = 0;
        $breakdown = [];

        foreach ($tariffs as $tariff) {
            $rate = $tariff->rate;
            $cost = $consumption * $rate;
            $tva = $cost * ($tariff->tva_rate / 100);
            
            $breakdown[$tariff->name] = [
                'rate' => $rate,
                'consumption' => $consumption,
                'cost_ht' => $cost,
                'tva_rate' => $tariff->tva_rate,
                'tva_amount' => $tva,
                'cost_ttc' => $cost + $tva
            ];
            
            $totalCost += $cost + $tva;
        }

        return [
            'total_cost' => $totalCost,
            'breakdown' => $breakdown
        ];
    }
} 