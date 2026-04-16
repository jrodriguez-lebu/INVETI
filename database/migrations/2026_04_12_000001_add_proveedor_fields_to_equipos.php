<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->string('numero_opi')->nullable()->after('factura_documento');
            $table->string('numero_factura')->nullable()->after('numero_opi');
            $table->string('rut_proveedor')->nullable()->after('numero_factura');
            $table->string('nombre_proveedor')->nullable()->after('rut_proveedor');
        });
    }

    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn(['numero_opi', 'numero_factura', 'rut_proveedor', 'nombre_proveedor']);
        });
    }
};
