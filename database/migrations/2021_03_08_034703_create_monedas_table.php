<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonedasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('monedas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50);
            $table->string('nombre', 50);
            $table->string('simbolo', 50);
            $table->foreignId('pais_id')->constrained('paises')->onDelete('cascade')->cascadeOnUpdate();
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
        Schema::dropIfExists('monedas');
    }
}
