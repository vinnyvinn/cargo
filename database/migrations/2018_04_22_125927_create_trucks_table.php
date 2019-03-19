<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bl_id');
            $table->string('driver');
            $table->string('driver_id');
            $table->string('contact');
            $table->string('vehicle_no');
            $table->string('qty');
            $table->string('weight');
            $table->string('good_condition');
            $table->string('image_path');
            $table->string('buying')->nullable();
            $table->string('cost')->nullable();
            $table->string('container_no')->nullable();
            $table->dateTime('date_loaded')->nullable();
            $table->dateTime('date_offloaded')->nullable();
            $table->dateTime('departure')->nullable();
            $table->dateTime('arrival')->nullable();
            $table->string('current_location')->nullable();
            $table->dateTime('return')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('trucks');
    }
}
