<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlazasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('plazas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre', 150);
            $table->foreignId('municipio_id')->constrained()->onDelete('cascade');
            $table->foreignId('estado_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('plazas', function (Blueprint $table)
        {
            $table->foreignUuid('parent_id')->nullable()->constrained('plazas')->onDelete('cascade');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('plazas');
        Schema::enableForeignKeyConstraints();
    }
}
