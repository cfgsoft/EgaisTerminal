<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_inventory_line', function (Blueprint $table) {
            $table->integer('line_id')->unsigned()->default(0);
            $table->string('product_code', 19);
        });

        Schema::table('doc_inventory_mark_line', function (Blueprint $table) {
            $table->string('product_code', 19);
            $table->string('f2reg_id', 19);
            $table->integer('order_id')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_inventory_line', function (Blueprint $table) {
            $table->dropColumn(['line_id','product_code']);
        });

        Schema::table('doc_inventory_mark_line', function (Blueprint $table) {
            $table->dropColumn(['product_code','f2reg_id','order_id']);
        });
    }
}
