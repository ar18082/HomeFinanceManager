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
        Schema::table('energy_meters', function (Blueprint $table) {
            // Rendre le champ current_reading nullable et avec une valeur par défaut
            $table->decimal('current_reading', 15, 3)->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('energy_meters', function (Blueprint $table) {
            // Remettre le champ comme non-nullable
            $table->decimal('current_reading', 15, 3)->nullable(false)->default(0)->change();
        });
    }
};
