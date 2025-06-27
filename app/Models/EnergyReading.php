<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnergyReading extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'energy_meter_id',
        'energy_provider_id',
        'energy_contract_id',
        'reading_date',
        'reading_value',
        'consumption',
        'cost',
        'currency_id',
        'unit_price',
        'reading_method',
        'notes',
        'is_estimated',
        'period_type',
        'day_consumption',
        'night_consumption',
        'day_cost',
        'night_cost',
        'distribution_cost',
        'transport_cost',
        'tax_cost',
        'fixed_cost',
        'total_cost_without_tva',
        'tva_amount'
    ];

    protected $casts = [
        'reading_value' => 'decimal:3',
        'consumption' => 'decimal:3',
        'cost' => 'decimal:2',
        'unit_price' => 'decimal:4',
        'reading_date' => 'date',
        'is_estimated' => 'boolean',
        'day_consumption' => 'decimal:3',
        'night_consumption' => 'decimal:3',
        'day_cost' => 'decimal:2',
        'night_cost' => 'decimal:2',
        'distribution_cost' => 'decimal:2',
        'transport_cost' => 'decimal:2',
        'tax_cost' => 'decimal:2',
        'fixed_cost' => 'decimal:2',
        'total_cost_without_tva' => 'decimal:2',
        'tva_amount' => 'decimal:2'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function energyMeter()
    {
        return $this->belongsTo(EnergyMeter::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function provider()
    {
        return $this->belongsTo(EnergyProvider::class, 'energy_provider_id');
    }

    public function contract()
    {
        return $this->belongsTo(EnergyContract::class, 'energy_contract_id');
    }

    // Scopes
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('reading_date', [$startDate, $endDate]);
    }

    public function scopeByMeter($query, $meterId)
    {
        return $query->where('energy_meter_id', $meterId);
    }

    public function scopeEstimated($query)
    {
        return $query->where('is_estimated', true);
    }

    public function scopeReal($query)
    {
        return $query->where('is_estimated', false);
    }

    // Méthodes utilitaires
    public function getFormattedReadingValueAttribute()
    {
        return number_format($this->reading_value, 3) . ' ' . $this->energyMeter->unit;
    }

    public function getFormattedConsumptionAttribute()
    {
        if ($this->consumption === null) {
            return 'N/A';
        }
        return number_format($this->consumption, 3) . ' ' . $this->energyMeter->unit;
    }

    public function getFormattedCostAttribute()
    {
        if ($this->cost === null) {
            return 'N/A';
        }
        return number_format($this->cost, 2) . ' ' . $this->currency->symbol;
    }

    public function getFormattedUnitPriceAttribute()
    {
        if ($this->unit_price === null) {
            return 'N/A';
        }
        return number_format($this->unit_price, 4) . ' ' . $this->currency->symbol . '/' . $this->energyMeter->unit;
    }

    // Calculer automatiquement la consommation si pas définie
    public function calculateConsumption()
    {
        if ($this->consumption !== null) {
            return $this->consumption;
        }

        $previousReading = $this->energyMeter->readings()
            ->where('reading_date', '<', $this->reading_date)
            ->orderBy('reading_date', 'desc')
            ->first();

        if ($previousReading) {
            $this->consumption = $this->reading_value - $previousReading->reading_value;
            return $this->consumption;
        }

        return 0;
    }

    // Calculer automatiquement le coût si pas défini
    public function calculateCost()
    {
        if ($this->cost !== null) {
            return $this->cost;
        }

        $consumption = $this->calculateConsumption();
        if ($this->unit_price && $consumption > 0) {
            $this->cost = $consumption * $this->unit_price;
            return $this->cost;
        }

        return 0;
    }
} 