<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeingOrders2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_pack_lines', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::table('order_error_lines', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')
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
        Schema::table('order_pack_lines', function (Blueprint $table) {
            $table->dropForeign('order_pack_lines_order_id_foreign');
        });

        Schema::table('order_error_lines', function (Blueprint $table) {
            $table->dropForeign('order_error_lines_order_id_foreign');
        });
    }
}
