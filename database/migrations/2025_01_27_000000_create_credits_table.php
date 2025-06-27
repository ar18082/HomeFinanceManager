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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2); // Montant emprunté
            $table->decimal('interest_rate', 5, 2); // Taux d'intérêt annuel
            $table->integer('duration_months'); // Durée en mois
            $table->date('start_date'); // Date de début
            $table->date('end_date'); // Date de fin calculée
            $table->decimal('monthly_payment', 15, 2); // Mensualité
            $table->decimal('total_interest', 15, 2); // Intérêts totaux
            $table->decimal('total_amount', 15, 2); // Montant total à rembourser
            $table->decimal('remaining_balance', 15, 2); // Solde restant
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('currency_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['active', 'completed', 'defaulted'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
}; 