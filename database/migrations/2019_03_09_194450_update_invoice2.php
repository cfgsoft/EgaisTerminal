<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoice2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_invoice_line', function (Blueprint $table) {
            $table->integer('quantity_pack')->default(0)->unsigned();
            $table->integer('quantity_pack_mark')->default(0)->unsigned();
            $table->integer('quantity_pallet')->default(0)->unsigned();
            $table->integer('quantity_pallet_mark')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_invoice_line', function (Blueprint $table) {
            $table->dropColumn('quantity_pack');
            $table->dropColumn('quantity_pack_mark');
            $table->dropColumn('quantity_pallet');
            $table->dropColumn('quantity_pallet_mark');
        });
    }
}
