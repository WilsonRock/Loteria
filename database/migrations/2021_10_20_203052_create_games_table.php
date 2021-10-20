<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titulo');
            $table->string('identificacion');
            $table->string('contacto');
            $table->string('cifras');
            $table->string('oportunidades');
            $table->string('premio');
            $table->string('precio');
            $table->string('comision');
            $table->string('fecha_inicio');
            $table->string('fecha_final');
            $table->boolean('active')->default(true);
            $table->foreignUuid('node_id')->constrained('nodes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
