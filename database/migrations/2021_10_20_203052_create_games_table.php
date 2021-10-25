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
            $table->id();
            $table->string('titulo');
            $table->string('identificacion')->unique();
            $table->string('contacto');
            $table->string('cifras');
            $table->string('oportunidades');
            $table->string('premio');
            $table->string('precio');
            $table->string('comision');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->boolean('active')->default(true);
            $table->foreignId('node_id')->constrained('nodes');
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
