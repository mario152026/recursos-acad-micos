<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('niveles_educativos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_nivel');
            $table->timestamps(); // Esto agrega las columnas 'created_at' y 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('niveles_educativos');
    }
};
