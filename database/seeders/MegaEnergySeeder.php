<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EnergyProvider;
use App\Models\EnergyTariff;

class MegaEnergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer le fournisseur Mega Energie
        $mega = EnergyProvider::create([
            'name' => 'Mega Energie',
            'code' => 'mega',
            'description' => 'Fournisseur d\'énergie belge',
            'website' => 'https://www.mega.be',
            'active' => true
        ]);

        // Tarifs basés sur votre facture (2023-2024)
        
        // 1. Énergie verte (Contribution énergie renouvelable)
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coût énergie verte',
            'type' => 'energy',
            'period_type' => 'single',
            'rate' => 0.027222,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-11-14',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coût énergie verte',
            'type' => 'energy',
            'period_type' => 'single',
            'rate' => 0.027223,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-11-15',
            'end_date' => '2023-12-31',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coût énergie verte',
            'type' => 'energy',
            'period_type' => 'single',
            'rate' => 0.027552,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2024-01-01',
            'active' => true
        ]);

        // 1.1. Consommation électricité jour/nuit
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Consommation électricité jour',
            'type' => 'energy',
            'period_type' => 'day_night',
            'rate' => 0.15114,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-11-14',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Consommation électricité jour',
            'type' => 'energy',
            'period_type' => 'day_night',
            'rate' => 0.124404,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-11-15',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Consommation électricité nuit',
            'type' => 'energy',
            'period_type' => 'day_night',
            'rate' => 0.118652,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-11-14',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Consommation électricité nuit',
            'type' => 'energy',
            'period_type' => 'day_night',
            'rate' => 0.10035,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-11-15',
            'active' => true
        ]);

        // 1.2. Redevance fixe électricité
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Redevance fixe électricité',
            'type' => 'fixed',
            'period_type' => 'single',
            'rate' => 0.068493,
            'unit' => 'jour',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-11-14',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Redevance fixe électricité',
            'type' => 'fixed',
            'period_type' => 'single',
            'rate' => 0.978494,
            'unit' => 'jour',
            'tva_rate' => 6.00,
            'start_date' => '2023-11-15',
            'active' => true
        ]);

        // 2. Distribution (Coûts de distribution)
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coûts de distribution',
            'type' => 'distribution',
            'period_type' => 'single',
            'rate' => 0.027382,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-12-31',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coûts de distribution',
            'type' => 'distribution',
            'period_type' => 'single',
            'rate' => 0.02606,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2024-01-01',
            'active' => true
        ]);

        // 3. Distribution jour/nuit
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coûts de distribution jour',
            'type' => 'distribution',
            'period_type' => 'day_night',
            'rate' => 0.070473,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-12-31',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coûts de distribution jour',
            'type' => 'distribution',
            'period_type' => 'day_night',
            'rate' => 0.077735,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2024-01-01',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coûts de distribution nuit',
            'type' => 'distribution',
            'period_type' => 'day_night',
            'rate' => 0.027946,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-12-31',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coûts de distribution nuit',
            'type' => 'distribution',
            'period_type' => 'day_night',
            'rate' => 0.030821,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2024-01-01',
            'active' => true
        ]);

        // 4. Terme fixe (abonnement)
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Terme fixe',
            'type' => 'fixed',
            'period_type' => 'single',
            'rate' => 0.19726,
            'unit' => 'jour',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-12-31',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Terme fixe',
            'type' => 'fixed',
            'period_type' => 'single',
            'rate' => 0.852055,
            'unit' => 'jour',
            'tva_rate' => 6.00,
            'start_date' => '2024-01-01',
            'active' => true
        ]);

        // 5. Transport
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coûts de transport',
            'type' => 'transport',
            'period_type' => 'single',
            'rate' => 0.024633,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2024-02-29',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Coûts de transport',
            'type' => 'transport',
            'period_type' => 'single',
            'rate' => 0.020008,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2024-03-01',
            'active' => true
        ]);

        // 6. Taxes
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Cotisation sur l\'énergie',
            'type' => 'tax',
            'period_type' => 'single',
            'rate' => 0.001926,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Accise spéciale',
            'type' => 'tax',
            'period_type' => 'single',
            'rate' => 0.04748,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Redevance de raccordement',
            'type' => 'tax',
            'period_type' => 'single',
            'rate' => 0.00075,
            'unit' => 'kWh',
            'tva_rate' => 0.00,
            'start_date' => '2023-10-21',
            'active' => true
        ]);

        // ===== TARIFS GAZ MEGA =====
        
        // 1. Abonnement gaz
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Abonnement gaz',
            'type' => 'fixed',
            'period_type' => 'single',
            'rate' => 0.068493,
            'unit' => 'jour',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-11-14',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Abonnement gaz',
            'type' => 'fixed',
            'period_type' => 'single',
            'rate' => 0.978494,
            'unit' => 'jour',
            'tva_rate' => 6.00,
            'start_date' => '2023-11-15',
            'active' => true
        ]);

        // 2. Consommation gaz
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Consommation gaz',
            'type' => 'energy',
            'period_type' => 'single',
            'rate' => 0.05363,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-11-14',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Consommation gaz',
            'type' => 'energy',
            'period_type' => 'single',
            'rate' => 0.044746,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-11-15',
            'active' => true
        ]);

        // 3. Distribution gaz
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Distribution gaz',
            'type' => 'distribution',
            'period_type' => 'single',
            'rate' => 0.015275,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-12-31',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Distribution gaz',
            'type' => 'distribution',
            'period_type' => 'single',
            'rate' => 0.017135,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2024-01-01',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Distribution gaz (supplémentaire)',
            'type' => 'distribution',
            'period_type' => 'single',
            'rate' => 0.00191,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'active' => true
        ]);

        // 4. Terme fixe gaz
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Terme fixe gaz',
            'type' => 'fixed',
            'period_type' => 'single',
            'rate' => 0.19726,
            'unit' => 'jour',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-12-31',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Terme fixe gaz',
            'type' => 'fixed',
            'period_type' => 'single',
            'rate' => 0.852055,
            'unit' => 'jour',
            'tva_rate' => 6.00,
            'start_date' => '2024-01-01',
            'active' => true
        ]);

        // 5. Transport gaz
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Transport gaz',
            'type' => 'transport',
            'period_type' => 'single',
            'rate' => 0.00144,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'end_date' => '2023-12-31',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Transport gaz',
            'type' => 'transport',
            'period_type' => 'single',
            'rate' => 0.00153,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2024-01-01',
            'active' => true
        ]);

        // 6. Taxes gaz
        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Cotisation énergie gaz',
            'type' => 'tax',
            'period_type' => 'single',
            'rate' => 0.000998,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Accise spéciale gaz',
            'type' => 'tax',
            'period_type' => 'single',
            'rate' => 0.00823,
            'unit' => 'kWh',
            'tva_rate' => 6.00,
            'start_date' => '2023-10-21',
            'active' => true
        ]);

        EnergyTariff::create([
            'energy_provider_id' => $mega->id,
            'name' => 'Redevance de raccordement gaz',
            'type' => 'tax',
            'period_type' => 'single',
            'rate' => 0.000075,
            'unit' => 'kWh',
            'tva_rate' => 0.00,
            'start_date' => '2023-10-21',
            'active' => true
        ]);

        $this->command->info('✅ Fournisseur Mega Energie et tarifs créés avec succès !');
        $this->command->info('📊 Tarifs intégrés : Énergie verte, Distribution jour/nuit, Transport, Taxes');
        $this->command->info('🔥 Tarifs gaz intégrés : Abonnement, Consommation, Distribution, Transport, Taxes');
    }
} 