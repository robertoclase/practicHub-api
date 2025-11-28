<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('parte_diarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seguimiento_practica_id')->constrained()->onDelete('cascade');
            $table->date('fecha');
            $table->integer('horas_realizadas');
            $table->text('actividades_realizadas');
            $table->text('observaciones')->nullable();
            $table->text('dificultades')->nullable();
            $table->text('soluciones_propuestas')->nullable();
            $table->boolean('validado_tutor')->default(false);
            $table->boolean('validado_profesor')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parte_diarios');
    }
};
