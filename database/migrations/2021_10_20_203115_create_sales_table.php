<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('precio');
            $table->string('premio');
            $table->string('comision');
            $table->json('caracteristicas');
            $table->foreignUuid('vendedor_id')->constrained('users');
            $table->foreignUuid('cliente_id')->constrained('users');
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
        Schema::dropIfExists('sales');
    }
}
