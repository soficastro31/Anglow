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
        // Solo intentamos crear la columna si NO existe.
        if (!Schema::hasColumn('pedidos', 'user_id')) {
            Schema::table('pedidos', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // 1. Eliminamos la restricción de la llave foránea primero
            $table->dropForeign(['user_id']);

            // 2. Ahora sí podemos borrar la columna de forma segura
            $table->dropColumn('user_id');
        });
    }
};
