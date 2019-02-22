<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPalletLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::rename('orders', 'doc_order');
        //Schema::rename('order_line', 'doc_order_line');
        //Schema::rename('order_mark_line', 'doc_order_mark_line');
        //Schema::rename('order_pack_line', 'doc_order_pack_line');

        Schema::create('order_pallet_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('f2reg_id', 19);
            $table->string('pallet_number', 26);
            $table->boolean('savedin1c')->default(false);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')
                ->onDelete('restrict')->onUpdate('restrict');

            //$table->unique(['pallet_number','order_id'],'pallet_number_id_unique');
        });

        Schema::table('order_pack_lines', function (Blueprint $table) {
            //$table->string('pack_number', 26)->nullable();
            $table->string('pallet_number', 26)->nullable();

            //$table->unique(['order_id', 'box_number', 'pallet_number']);
        });

        //DB::statement('ALTER TABLE order_pack_lines MODIFY COLUMN box_number VARCHAR(26) AFTER markcode');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::rename('doc_order', 'orders');

        Schema::dropIfExists('order_pallet_line');

        Schema::table('order_pack_lines', function (Blueprint $table) {
            //$table->dropColumn('pack_number');
            $table->dropColumn('pallet_number');
        });
    }
}
