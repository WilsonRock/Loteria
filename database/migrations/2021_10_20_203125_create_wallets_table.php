<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('saldo_inicial');
            $table->string('saldo_final');
            $table->foreignId('node_id')->constrained('nodes');
            $table->foreignUuid('usuario_id')->constrained('users');
            $table->foreignId('venta_id')->constrained('sales');
            $table->foreignId('parent_id')->nullable()->constrained('wallets');
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
        Schema::dropIfExists('wallets');
    }
}
