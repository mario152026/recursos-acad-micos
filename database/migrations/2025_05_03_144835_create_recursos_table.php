<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('tipo');  // Apuntes, Ejercicios, etc.
            $table->string('archivo_url');
            $table->timestamp('fecha_subida')->useCurrent();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_asignatura');
            $table->unsignedBigInteger('id_nivel');
            $table->timestamps();  // created_at, updated_at

            // Definir claves foráneas
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_asignatura')->references('id')->on('asignaturas')->onDelete('cascade');
            $table->foreign('id_nivel')->references('id')->on('niveles_educativos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }
};
