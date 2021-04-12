<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('balances', function (Blueprint $table) {
            $table->uuid('id');
            $table->double('saldo_actual');
            $table->double('saldo_final');
            $table->text('descripcion');
            $table->double('precio');
            $table->uuid('parent_id')->nullable();
            $table->foreignId('tipo_balance_id')->constrained()->onDelete('cascade')->cascadeOnUpdate();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade')->cascadeOnUpdate();
            $table->foreignUuid('cliente_id')->nullable()->constrained()->onDelete('cascade')->cascadeOnUpdate();
            $table->foreignUuid('venta_id')->nullable()->constrained()->onDelete('cascade')->cascadeOnUpdate();

            $table->timestamps();
            $table->primary('id');
            $table->foreign('parent_id')->references('id')->on('balances')->onDelete('cascade')->cascadeOnUpdate();
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
        Schema::dropIfExists('balances');
    }
}
