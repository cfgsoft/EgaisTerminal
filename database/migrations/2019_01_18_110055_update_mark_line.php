<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMarkLine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_mark_lines', function (Blueprint $table) {
            $table->unique(['markcode','order_id'],'markcode_id_unique');
        });

        Schema::table('order_pack_lines', function (Blueprint $table) {
            $table->unique(['markcode','order_id'],'markcode_id_unique');
        });

        Schema::table('doc_returned_invoice_mark_line', function (Blueprint $table) {
            $table->unique(['markcode','returned_invoice_id'],'markcode_id_unique');
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
            $table->dropUnique('markcode_id_unique');
        });

        Schema::table('order_pack_lines', function (Blueprint $table) {
            $table->dropUnique('markcode_id_unique');
        });

        Schema::table('doc_returned_invoice_mark_line', function (Blueprint $table) {
            $table->dropUnique('markcode_id_unique');
        });
    }
}
