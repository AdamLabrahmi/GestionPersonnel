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
        Schema::table('demande_absences', function (Blueprint $table) {
            // Supprimer la clé étrangère d'abord
            $table->dropForeign(['matriculeFv']);

            // Supprimer la colonne
            $table->dropColumn('matriculeFv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
