<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('fichas_medicas', function (Blueprint $table) {
            $table->decimal('peso', 5, 2)->nullable()->after('tipo_sangre')->comment('kg');
            $table->decimal('talla', 5, 2)->nullable()->after('peso')->comment('metros');
        });
    }
    public function down(): void {
        Schema::table('fichas_medicas', function (Blueprint $table) {
            $table->dropColumn(['peso', 'talla']);
        });
    }
};
