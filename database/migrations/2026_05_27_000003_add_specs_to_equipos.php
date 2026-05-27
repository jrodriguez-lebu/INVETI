<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            // tipo_disco: SSD, HDD, NVMe, eMMC, Híbrido
            $table->string('tipo_disco')->nullable()->after('almacenamiento');
            // tamaño de pantalla en pulgadas, ej: "15.6", "27"
            $table->string('tamano_pantalla')->nullable()->after('tipo_disco');
        });
    }

    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn(['tipo_disco', 'tamano_pantalla']);
        });
    }
};
