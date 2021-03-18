<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionJuegoPlazaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('configuracion_juego_plaza', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('fecha_inicial')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('fecha_final')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignUuid('configuracion_juego_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('plaza_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('configuracion_juego_plaza');
    }
}
