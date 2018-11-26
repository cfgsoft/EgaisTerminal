<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_mark_lines', function (Blueprint $table) {
            $table->string('markcode', 150)->change();
            $table->renameColumn('ordermarklineid', 'orderlineid');
            $table->string('f2regid', 19);
        });

        Schema::table('order_lines', function (Blueprint $table) {
            $table->string('f2regid', 19);
        });

        Schema::create('order_pack_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('orderlineid')->unsigned();
            $table->string('productcode', 19);
            $table->string('f2regid', 19);
            $table->string('markcode', 26);
            $table->integer('quantity')->default(0);
            $table->boolean('savedin1c');
            $table->timestamps();
        });

        Schema::create('order_error_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('markcode', 150);
            $table->string('message', 200);
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
        Schema::table('order_mark_lines', function (Blueprint $table) {
            //$table->string('markcode', 68)->change();
            $table->renameColumn('orderlineid', 'ordermarklineid');
            $table->dropColumn(['f2regid']);
        });

        Schema::table('order_lines', function (Blueprint $table) {
            $table->dropColumn(['f2regid']);
        });

        Schema::dropIfExists('order_pack_lines');
        Schema::dropIfExists('order_error_lines');
    }
}
