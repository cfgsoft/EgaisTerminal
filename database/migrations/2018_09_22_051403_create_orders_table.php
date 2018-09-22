<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('number', 10);
            $table->string('barcode', 11);
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::create('orderlines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('productdescr', 100);
            $table->string('productcode', 19);
            $table->integer('quantity')->default(0);
            $table->integer('quantitymarks')->default(0);
            $table->boolean('showfirst');
            $table->timestamps();
        });

        Schema::create('ordermarklines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('ordermarklineid');
            $table->string('productcode', 19);
            $table->string('markcode', 68);
            $table->integer('quantity')->default(0);
            $table->boolean('savedin1c');
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
        Schema::dropIfExists('ordermarklines');
        Schema::dropIfExists('orderlines');
        Schema::dropIfExists('orders');
    }
}
