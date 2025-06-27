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
        Schema::create('energy_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ex: Mega Energie
            $table->string('code')->unique(); // ex: mega
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('energy_tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('energy_provider_id')->constrained()->onDelete('cascade');
            $table->string('name'); // ex: "Distribution jour", "Énergie verte"
            $table->string('type'); // energy, distribution, transport, tax, fixed
            $table->string('period_type')->default('single'); // single, day_night, peak_offpeak
            $table->decimal('rate', 10, 6); // Tarif unitaire
            $table->string('unit', 10); // kWh, m³, jour, mois, année
            $table->decimal('tva_rate', 5, 2)->default(6.00); // Taux de TVA
            $table->date('start_date')->nullable(); // Date de début d'application
            $table->date('end_date')->nullable(); // Date de fin d'application
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('energy_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('energy_provider_id')->constrained()->onDelete('cascade');
            $table->foreignId('energy_meter_id')->constrained()->onDelete('cascade');
            $table->string('contract_number')->nullable(); // Numéro de contrat
            $table->string('type'); // electricity, gas, water
            $table->string('tariff_structure')->default('single'); // single, day_night, peak_offpeak
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('monthly_fee', 10, 2)->default(0); // Frais mensuels
            $table->decimal('annual_fee', 10, 2)->default(0); // Frais annuels
            $table->text('notes')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_contracts');
        Schema::dropIfExists('energy_tariffs');
        Schema::dropIfExists('energy_providers');
    }
}; 