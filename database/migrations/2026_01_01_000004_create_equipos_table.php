<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_equipo_id')->constrained('tipos_equipo')->restrictOnDelete();
            $table->string('marca');
            $table->string('modelo');
            $table->string('numero_serie')->nullable();
            $table->string('numero_inventario')->unique();
            $table->enum('estado', ['activo', 'inactivo', 'baja', 'reparacion'])->default('activo');
            $table->foreignId('funcionario_id')->nullable()->constrained('funcionarios')->nullOnDelete();
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->nullOnDelete();
            $table->date('fecha_adquisicion')->nullable();
            $table->decimal('valor_adquisicion', 12, 2)->nullable();
            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
