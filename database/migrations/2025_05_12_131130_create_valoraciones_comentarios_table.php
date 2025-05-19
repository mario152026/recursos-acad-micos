<?php

// database/migrations/2025_05_12_000000_create_valoracion_comentarios_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valoracion_comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()        // referencia a users.id
                ->cascadeOnDelete();
            $table->foreignId('recurso_id')
                ->constrained('recursos') // referencia a recursos.id
                ->cascadeOnDelete();
            $table->tinyInteger('calificacion');      // 1–5
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valoracion_comentarios');
    }
};
