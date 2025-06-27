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
        Schema::create('energy_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('energy_meter_id')->constrained()->onDelete('cascade');
            $table->date('reading_date'); // Date du relevé
            $table->decimal('reading_value', 15, 3); // Valeur lue
            $table->decimal('consumption', 15, 3)->nullable(); // Consommation calculée
            $table->decimal('cost', 15, 2)->nullable(); // Coût calculé
            $table->foreignId('currency_id')->constrained();
            $table->decimal('unit_price', 10, 4)->nullable(); // Prix unitaire
            $table->string('reading_method')->nullable(); // Méthode de lecture (manuel, photo, etc.)
            $table->text('notes')->nullable();
            $table->boolean('is_estimated')->default(false); // Lecture estimée ou réelle
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour optimiser les requêtes
            $table->index(['energy_meter_id', 'reading_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_readings');
    }
}; 