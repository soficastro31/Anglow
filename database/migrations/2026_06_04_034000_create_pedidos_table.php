<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('pedidos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Quién compra
        $table->string('telefono');
        $table->string('ciudad_departamento');
        $table->string('direccion');
        $table->string('barrio_sector');
        $table->text('notas_envio')->nullable();
        $table->decimal('total', 10, 2);
        $table->string('estado_pago')->default('pendiente'); // pendiente, aprobado, rechazado
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
