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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('currency_id')->constrained();
            $table->decimal('amount', 15, 2);
            $table->string('type'); // income, expense, transfer
            $table->date('date');
            $table->text('description')->nullable();
            $table->string('status')->default('completed'); // completed, pending, reconciled
            $table->foreignId('transfer_transaction_id')->nullable()->constrained('transactions')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });

        // Table pivot pour la relation many-to-many avec les tags
        Schema::create('tag_transaction', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->primary(['tag_id', 'transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_transaction');
        Schema::dropIfExists('transactions');
    }
};
