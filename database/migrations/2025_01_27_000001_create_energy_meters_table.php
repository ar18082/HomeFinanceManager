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
        Schema::create('energy_meters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nom du compteur (ex: "Compteur principal", "Compteur garage")
            $table->enum('type', ['electricity', 'gas', 'water']); // Type d'énergie
            $table->string('meter_number')->nullable(); // Numéro du compteur
            $table->string('location')->nullable(); // Localisation (ex: "Cuisine", "Garage")
            $table->string('unit', 10); // Unité de mesure (kWh, m³, L)
            $table->decimal('current_reading', 15, 3)->default(0); // Dernière lecture
            $table->date('last_reading_date')->nullable(); // Date de la dernière lecture
            $table->text('notes')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_meters');
    }
}; 