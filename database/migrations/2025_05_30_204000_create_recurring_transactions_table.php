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
        Schema::create('recurring_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('currency_id')->constrained();
            $table->string('type'); // income, expense, transfer
            $table->decimal('amount', 15, 2);
            $table->string('description');
            $table->string('frequency'); // daily, weekly, monthly, yearly
            $table->integer('interval')->default(1); // Pour gérer "tous les 2 mois" par exemple
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('last_generated')->nullable();
            $table->integer('times_to_run')->nullable(); // Nombre de fois à exécuter (null = infini)
            $table->integer('times_run')->default(0); // Nombre de fois déjà exécuté
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();
            // Pour les transferts
            $table->foreignId('destination_account_id')->nullable()->constrained('accounts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_transactions');
    }
}; 