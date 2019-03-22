<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_order', function (Blueprint $table) {
            $table->integer('quantity')->default(0)->change();
            $table->integer('quantity_mark')->default(0)->change();
        });

        DB::statement('ALTER TABLE doc_invoice_line MODIFY COLUMN quantity_pack INT(11) AFTER quantity_mark');
        DB::statement('ALTER TABLE doc_invoice_line MODIFY COLUMN quantity_pack_mark INT(11) AFTER quantity_pack');
        DB::statement('ALTER TABLE doc_invoice_line MODIFY COLUMN quantity_pallet INT(10) AFTER quantity_pack_mark');
        DB::statement('ALTER TABLE doc_invoice_line MODIFY COLUMN quantity_pallet_mark INT(10) AFTER quantity_pallet');

        DB::statement('ALTER TABLE doc_invoice_mark_line MODIFY COLUMN pack_number VARCHAR(26) AFTER mark_code');

        DB::statement('ALTER TABLE doc_returned_invoice_mark_line MODIFY COLUMN pack_number VARCHAR(26) AFTER markcode');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_order', function (Blueprint $table) {
            $table->integer('quantity')->change();
            $table->integer('quantity_mark')->change();
        });
    }
}
