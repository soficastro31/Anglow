<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('compras_proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('proveedor');
            $table->string('producto');
            $table->integer('cantidad');
            $table->decimal('costo_total', 10, 2);
            $table->date('fecha_entrega');
            $table->enum('estado', ['pendiente', 'recibido', 'cancelado'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras_proveedor');
    }
};
