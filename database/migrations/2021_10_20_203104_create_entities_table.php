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
            $table->id();
            $table->string('zona_horaria');
            $table->string('moneda');
            $table->string('nombre_contacto');
            $table->string('telefono_contacto');
            $table->string('email')->unique();
            $table->string('pais');
            $table->string('zona');
            $table->string('nit')->unique();
            $table->json('permisos')->nullable();
            $table->string('balance');
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
        Schema::dropIfExists('entities');
    }
}
