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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');

            // CORRECCIÓN: Eliminamos el ->after('id') para que no rompa la sintaxis de MariaDB
            $table->unsignedBigInteger('categoria_id')->nullable();

            $table->text('descripcion');
            $table->decimal('precio', 10, 2);
            $table->integer('stock');
            $table->string('imagen')->nullable();
            $table->timestamps();

            // Relación de Llave Foránea
            $table->foreign('categoria_id')->references('id')->on('categoria')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
