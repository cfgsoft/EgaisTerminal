<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameOrderLine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('order_lines', 'doc_order_line');
        Schema::rename('order_mark_lines',  'doc_order_mark_line');
        Schema::rename('order_pack_lines',  'doc_order_pack_line');
        Schema::rename('order_pallet_line', 'doc_order_pallet_line');
        Schema::rename('order_error_lines', 'doc_order_error_line');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('doc_order_line', 'order_lines');
        Schema::rename('doc_order_mark_line', 'order_mark_lines');
        Schema::rename('doc_order_pack_line', 'order_pack_lines');
        Schema::rename('doc_order_pallet_line', 'order_pallet_line');
        Schema::rename('doc_order_error_line', 'order_error_lines');
    }
}
