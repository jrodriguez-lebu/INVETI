<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->string('cpu')->nullable()->after('observaciones');
            $table->string('ram')->nullable()->after('cpu');
            $table->string('almacenamiento')->nullable()->after('ram');
            $table->string('ubicacion')->nullable()->after('almacenamiento');
            $table->string('codigo_anydesk')->nullable()->after('ubicacion');
            $table->string('office_version')->nullable()->after('codigo_anydesk');
            $table->string('clave_windows')->nullable()->after('office_version');
            $table->string('factura_documento')->nullable()->after('clave_windows');
            $table->boolean('datos_incompletos')->default(true)->after('factura_documento');
            $table->json('campos_faltantes')->nullable()->after('datos_incompletos');
        });
    }

    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn([
                'cpu',
                'ram',
                'almacenamiento',
                'ubicacion',
                'codigo_anydesk',
                'office_version',
                'clave_windows',
                'factura_documento',
                'datos_incompletos',
                'campos_faltantes',
            ]);
        });
    }
};
