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
        Schema::create('demande_absences', function (Blueprint $table) {
            $table->id();
            $table->string('Motif', 255);
            $table->date('DateDebut');
            $table->date('DateFin');
            $table->string('pdf_files', 255)->nullable();
            $table->timestamp('date_demande')->useCurrent();
            $table->boolean('autorisation')->default(false);
            $table->string('matriculeFm')->nullable();
            $table->string('matriculePA')->nullable();
            $table->foreign('matriculeFm')->references('matricule')->on('formateurs')->onDelete('cascade');
            $table->foreign('matriculePA')->references('matricule')->on('personnel__administratifs')->onDelete('cascade');
            $table->enum('status', ['en attente', 'informer'])->default('en attente');
            $table->timestamps();
        });
            // $table->string('matriculeFv')->nullable();
            // $table->foreign('matriculeFv')->references('matricule')->on('formateurs')->onDelete('cascade'); // Ajoutez cette ligne
            // $table->string('status')->default('en attente');


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_absences');
    }
};
