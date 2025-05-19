<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recursos', function (Blueprint $table) {
            // Después de updated_at, por ejemplo
            $table->boolean('activo')->default(true)->after('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('recursos', function (Blueprint $table) {
            $table->dropColumn('activo');
        });
    }
};
