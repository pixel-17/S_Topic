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
        Schema::create('fichas_medicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->unique()->constrained('estudiantes')->cascadeOnDelete();
            $table->enum('tipo_sangre', ['A+','A-','B+','B-','AB+','AB-','O+','O-'])->nullable();
            $table->text('alergias')->nullable();
            $table->text('enfermedades_previas')->nullable();
            $table->text('medicamentos_actuales')->nullable();
            $table->string('telefono_emergencia', 15)->nullable();
            $table->string('contacto_emergencia', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas_medicas');
    }
};
