<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buying_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100);
            $table->unsignedBigInteger('user_id');
             $table->foreign('user_id')->references('id')->on('users');
            $table->date('buying_date');
            $table->date('shipping_date');
            $table->integer('shipping_cost');
            $table->string('message', 400);
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
        Schema::dropIfExists('buying_orders');
    }
}
