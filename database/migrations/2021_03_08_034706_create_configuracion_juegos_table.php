<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionJuegosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('configuracion_juegos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre', 100);
            $table->string('descripcion');
            $table->double('valor_boleto');
            $table->integer('cantidad_boletos');
            $table->integer('cifras');
            $table->double('premio');
            $table->longText('terminos');
            $table->foreignId('tipo_juego_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('municipio_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('estado_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('configuracion_juegos');
    }
}
