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
        Schema::create('atenciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('motivo_id')->constrained('motivos')->restrictOnDelete();
            $table->dateTime('fecha')->useCurrent();
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('es_recurrente')->default(false);
            $table->boolean('derivado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atenciones');
    }
};
