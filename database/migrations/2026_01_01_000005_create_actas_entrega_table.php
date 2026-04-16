<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actas_entrega', function (Blueprint $table) {
            $table->id();
            $table->string('numero_acta')->unique();
            $table->foreignId('equipo_id')->constrained('equipos')->restrictOnDelete();
            $table->foreignId('funcionario_id')->constrained('funcionarios')->restrictOnDelete();
            $table->date('fecha_entrega');
            $table->text('observaciones')->nullable();
            $table->boolean('firmada')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actas_entrega');
    }
};
