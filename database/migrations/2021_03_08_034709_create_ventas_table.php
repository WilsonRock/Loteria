<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('ventas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('fecha_venta');
            $table->json('boletos');
            $table->double('precio');
            $table->foreignUuid('cliente_id')->constrained()->onDelete('cascade')->cascadeOnUpdate();
            $table->foreignUuid('configuracion_juego_plaza_id')->constrained()->onDelete('cascade')->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
