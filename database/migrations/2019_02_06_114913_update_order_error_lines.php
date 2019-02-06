<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderErrorLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_error_lines', function (Blueprint $table) {
            $table->string('product_code', 19)->nullable();
            $table->string('f2reg_id', 19)->nullable();
            $table->boolean('savedin1c')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_error_lines', function (Blueprint $table) {
            $table->dropColumn(['product_code','f2reg_id','savedin1c']);
        });
    }
}
