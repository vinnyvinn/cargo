<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillOfLandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_of_landings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id');
            $table->integer('completed_by')->nullable();
            $table->string('contract_ids')->nullable();
            $table->string('client_notification')->nullable();
            $table->integer('Client_id');
            $table->string('buying')->nullable();
            $table->string('cost')->nullable();
            $table->string('ctm_ref')->nullable();
            $table->string('esl_ref')->nullable();
            $table->string('consignor')->nullable();
            $table->string('consignee')->nullable();
            $table->string('stage')->nullable();
            $table->string('shipper')->nullable();
            $table->string('shipping_line')->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('bill_of_landings');
    }
}
