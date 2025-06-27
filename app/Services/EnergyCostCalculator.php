<?php

namespace App\Services;

use App\Models\EnergyReading;
use App\Models\EnergyProvider;
use App\Models\EnergyContract;
use Carbon\Carbon;

class EnergyCostCalculator
{
    /**
     * Calcule le coût complet d'un relevé selon la structure tarifaire Mega
     */
    public function calculateReadingCost(EnergyReading $reading, $providerId = null, $contractId = null)
    {
        if ($providerId) {
            $provider = EnergyProvider::find($providerId);
        } elseif ($reading->provider) {
            $provider = $reading->provider;
        } else {
            return null;
        }

        if ($contractId) {
            $contract = EnergyContract::find($contractId);
        } elseif ($reading->contract) {
            $contract = $reading->contract;
        } else {
            $contract = null;
        }

        $date = $reading->reading_date;
        $consumption = $reading->consumption ?: $this->calculateConsumption($reading);
        
        // Déterminer le type d'énergie selon le compteur
        $energyType = $reading->energyMeter->type;
        
        // Obtenir tous les tarifs actifs pour cette date et ce type d'énergie
        $tariffs = $provider->getActiveTariffs($energyType, $date);
        
        $breakdown = [];
        $totalCostHT = 0;
        $totalTVA = 0;
        
        // Répartition jour/nuit si applicable (uniquement pour l'électricité)
        $dayConsumption = 0;
        $nightConsumption = 0;
        
        if ($energyType === 'electricity' && $contract && $contract->tariff_structure === 'day_night') {
            // Basé sur vos données réelles : ~50% jour, ~50% nuit
            // Vous pouvez ajuster ces pourcentages selon vos habitudes
            $dayConsumption = $consumption * 0.5;
            $nightConsumption = $consumption * 0.5;
        } else {
            $dayConsumption = $consumption;
            $nightConsumption = 0;
        }

        foreach ($tariffs as $tariff) {
            $tariffConsumption = $consumption;
            $tariffType = $tariff->type;
            
            // Ajuster la consommation selon le type de tarif (uniquement pour l'électricité)
            if ($energyType === 'electricity' && $tariff->period_type === 'day_night') {
                if (str_contains(strtolower($tariff->name), 'jour')) {
                    $tariffConsumption = $dayConsumption;
                } elseif (str_contains(strtolower($tariff->name), 'nuit')) {
                    $tariffConsumption = $nightConsumption;
                }
            }
            
            // Calculer le coût pour ce tarif
            $costHT = $tariffConsumption * $tariff->rate;
            $tva = $costHT * ($tariff->tva_rate / 100);
            $costTTC = $costHT + $tva;
            
            $breakdown[$tariff->name] = [
                'type' => $tariffType,
                'rate' => $tariff->rate,
                'consumption' => $tariffConsumption,
                'cost_ht' => $costHT,
                'tva_rate' => $tariff->tva_rate,
                'tva_amount' => $tva,
                'cost_ttc' => $costTTC
            ];
            
            $totalCostHT += $costHT;
            $totalTVA += $tva;
            
            // Stocker les coûts par catégorie
            switch ($tariffType) {
                case 'energy':
                    $reading->cost = ($reading->cost ?: 0) + $costTTC;
                    break;
                case 'distribution':
                    if ($energyType === 'electricity' && str_contains(strtolower($tariff->name), 'jour')) {
                        $reading->day_cost = ($reading->day_cost ?: 0) + $costTTC;
                    } elseif ($energyType === 'electricity' && str_contains(strtolower($tariff->name), 'nuit')) {
                        $reading->night_cost = ($reading->night_cost ?: 0) + $costTTC;
                    } else {
                        $reading->distribution_cost = ($reading->distribution_cost ?: 0) + $costTTC;
                    }
                    break;
                case 'transport':
                    $reading->transport_cost = ($reading->transport_cost ?: 0) + $costTTC;
                    break;
                case 'tax':
                    $reading->tax_cost = ($reading->tax_cost ?: 0) + $costTTC;
                    break;
                case 'fixed':
                    $reading->fixed_cost = ($reading->fixed_cost ?: 0) + $costTTC;
                    break;
            }
        }
        
        // Mettre à jour les champs du relevé
        $reading->day_consumption = $dayConsumption;
        $reading->night_consumption = $nightConsumption;
        $reading->total_cost_without_tva = $totalCostHT;
        $reading->tva_amount = $totalTVA;
        $reading->cost = $totalCostHT + $totalTVA;
        
        return [
            'total_cost' => $totalCostHT + $totalTVA,
            'total_cost_ht' => $totalCostHT,
            'total_tva' => $totalTVA,
            'breakdown' => $breakdown,
            'day_consumption' => $dayConsumption,
            'night_consumption' => $nightConsumption,
            'energy_type' => $energyType
        ];
    }

    /**
     * Calcule la consommation si pas définie
     */
    private function calculateConsumption(EnergyReading $reading)
    {
        $previousReading = $reading->energyMeter->readings()
            ->where('reading_date', '<', $reading->reading_date)
            ->orderBy('reading_date', 'desc')
            ->first();

        if ($previousReading) {
            return $reading->reading_value - $previousReading->reading_value;
        }

        return 0;
    }

    /**
     * Calcule le coût pour une période donnée
     */
    public function calculatePeriodCost($meterId, $startDate, $endDate, $providerId = null)
    {
        $readings = EnergyReading::where('energy_meter_id', $meterId)
            ->whereBetween('reading_date', [$startDate, $endDate])
            ->orderBy('reading_date')
            ->get();

        $totalCost = 0;
        $totalConsumption = 0;
        $breakdown = [];

        foreach ($readings as $reading) {
            $costData = $this->calculateReadingCost($reading, $providerId);
            if ($costData) {
                $totalCost += $costData['total_cost'];
                $totalConsumption += $reading->consumption ?: 0;
                
                // Agréger le breakdown
                foreach ($costData['breakdown'] as $tariffName => $data) {
                    if (!isset($breakdown[$tariffName])) {
                        $breakdown[$tariffName] = [
                            'consumption' => 0,
                            'cost_ht' => 0,
                            'tva_amount' => 0,
                            'cost_ttc' => 0
                        ];
                    }
                    $breakdown[$tariffName]['consumption'] += $data['consumption'];
                    $breakdown[$tariffName]['cost_ht'] += $data['cost_ht'];
                    $breakdown[$tariffName]['tva_amount'] += $data['tva_amount'];
                    $breakdown[$tariffName]['cost_ttc'] += $data['cost_ttc'];
                }
            }
        }

        return [
            'total_cost' => $totalCost,
            'total_consumption' => $totalConsumption,
            'breakdown' => $breakdown,
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'days' => Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1
            ]
        ];
    }
} 