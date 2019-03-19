<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cargo_weight');
            $table->string('start');
            $table->string('destination');
            $table->integer('cargo_type');
            $table->string('cargo_quantity');
            $table->string('desc');
            $table->string('remarks')->nullable();
            $table->string('status')->default('pending');
            $table->string('distance');
            $table->string('bl_number')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('cargos');
    }
}
