<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('zona_horaria');
            $table->string('moneda');
            $table->string('nombre_contacto');
            $table->string('telefono_contacto');
            $table->string('email');
            $table->string('pais');
            $table->string('zona');
            $table->string('nit');
            $table->json('permisos');
            $table->string('balance');
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
        Schema::dropIfExists('entities');
    }
}
