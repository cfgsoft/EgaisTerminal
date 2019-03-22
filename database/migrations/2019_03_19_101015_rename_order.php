<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('orders',            'doc_order');
        //Schema::rename('order_lines',        'doc_order_line');
        //Schema::rename('order_mark_lines',   'doc_order_mark_line');
        //Schema::rename('order_pack_lines',   'doc_order_pack_line');
        //Schema::rename('order_pallet_line',  'doc_order_pallet_line');
        //Schema::rename('order_error_lines',  'doc_order_error_line');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('doc_order', 'orders');
        //Schema::rename('order_line',        'doc_order_line');
        //Schema::rename('order_mark_line',   'doc_order_mark_line');
        //Schema::rename('order_pack_line',   'doc_order_pack_line');
        //Schema::rename('order_pallet_line', 'doc_order_pallet_line');
        //Schema::rename('order_error_line',  'doc_order_error_line');
    }
}
