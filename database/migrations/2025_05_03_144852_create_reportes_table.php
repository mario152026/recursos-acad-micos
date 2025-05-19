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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();

            // Relación al usuario que reporta
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Relación al recurso reportado
            $table->foreignId('recurso_id')
                ->constrained('recursos')
                ->cascadeOnDelete();

            // Motivo del reporte
            $table->string('motivo', 255);

            // Timestamps created_at / updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
