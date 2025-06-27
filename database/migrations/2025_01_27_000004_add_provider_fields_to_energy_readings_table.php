<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('energy_readings', function (Blueprint $table) {
            $table->foreignId('energy_provider_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('energy_contract_id')->nullable()->constrained()->onDelete('set null');
            $table->string('period_type')->default('single'); // single, day, night, peak, offpeak
            $table->decimal('day_consumption', 15, 3)->nullable(); // Consommation jour
            $table->decimal('night_consumption', 15, 3)->nullable(); // Consommation nuit
            $table->decimal('day_cost', 15, 2)->nullable(); // Coût jour
            $table->decimal('night_cost', 15, 2)->nullable(); // Coût nuit
            $table->decimal('distribution_cost', 15, 2)->nullable(); // Coût distribution
            $table->decimal('transport_cost', 15, 2)->nullable(); // Coût transport
            $table->decimal('tax_cost', 15, 2)->nullable(); // Coût taxes
            $table->decimal('fixed_cost', 15, 2)->nullable(); // Coût fixe
            $table->decimal('total_cost_without_tva', 15, 2)->nullable(); // Total HT
            $table->decimal('tva_amount', 15, 2)->nullable(); // Montant TVA
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('energy_readings', function (Blueprint $table) {
            $table->dropForeign(['energy_provider_id']);
            $table->dropForeign(['energy_contract_id']);
            $table->dropColumn([
                'energy_provider_id',
                'energy_contract_id',
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
            ]);
        });
    }
}; 