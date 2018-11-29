<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderIncomingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::table('excise_stamps', function (Blueprint $table) {
        //    $table->string('id', 150)->primary()->change();
        //});


        Schema::create('excise_stamp_boxes', function (Blueprint $table) {
            $table->increments('id'); //->primary()
            $table->string('barcode', 26)->unique();
            $table->string('productcode', 19);
            $table->string('f1regid',19);
            $table->string('f2regid',19);
            $table->timestamps();
        });

        Schema::create('excise_stamp_box_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('excise_stamp_box_id')->unsigned(); //$table->string('excise_stamp_box_id',26);
            $table->string('markcode',150);
            $table->timestamps();

            $table->foreign('excise_stamp_box_id')->references('id')->on('excise_stamp_boxes')
                ->onDelete('cascade')->onUpdate('cascade');
        });


        Schema::create('order_incomings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('number', 11);
            $table->string('barcode', 11);
            $table->timestamps();
        });

        Schema::create('order_incoming_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_incoming_id')->unsigned();
            $table->integer('orderlineid')->unsigned();
            $table->string('productdescr', 100);
            $table->string('productcode', 19);
            $table->integer('quantity')->default(0);
            $table->integer('quantitymarks')->default(0);
            $table->boolean('showfirst');
            $table->timestamps();

            $table->foreign('order_incoming_id')->references('id')->on('order_incomings')
                ->onDelete('restrict')->onUpdate('restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('excise_stamp_box_lines', function (Blueprint $table) {
            $table->dropForeign('excise_stamp_box_lines_excise_stamp_box_id_foreign');
        });

        Schema::dropIfExists('excise_stamp_boxes');
        Schema::dropIfExists('excise_stamp_box_lines');


        Schema::table('order_incoming_lines', function (Blueprint $table) {
            $table->dropForeign('order_incoming_lines_order_incoming_id_foreign');
        });

        Schema::dropIfExists('order_incoming_lines');
        Schema::dropIfExists('order_incomings');
    }
}
