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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 8)->unique();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['M', 'F'])->nullable();
            $table->string('telefono', 15)->nullable();
            $table->foreignId('carrera_id')->nullable()->constrained('carreras')->nullOnDelete();
            $table->string('semestre', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
