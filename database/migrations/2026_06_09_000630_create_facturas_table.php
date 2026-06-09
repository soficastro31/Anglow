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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura')->unique(); // Ej: ANG-000001

            // Relación con la venta (si borras la venta, se puede mantener la factura por contabilidad)
            $table->unsignedBigInteger('venta_id')->nullable();

            $table->string('cliente_nombre'); // Guardamos el nombre plano por si el usuario se borra
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuesto', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('metodo_pago')->default('Efectivo');
            $table->string('estado')->default('emitida'); // emitida, pagada, anulada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
