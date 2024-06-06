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
        Schema::create('formateurs__permanents', function (Blueprint $table) {
            $table->id();
            $table->date('Date_Recrutement');
            $table->date('Date_Depart_Retrait');
            $table->integer('Echelle');
            $table->string('Echelon');
            $table->string('Grade');
            $table->string('matriculeFm');
            $table->foreign('matriculeFm')->references('matricule')->on('formateurs')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formateurs__permanents');
    }
};
