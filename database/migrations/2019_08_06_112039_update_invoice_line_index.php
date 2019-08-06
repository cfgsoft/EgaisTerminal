<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoiceLineIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //DB::statement('ALTER TABLE doc_invoice_line MODIFY COLUMN product_egais_id INT(10) AFTER product_code');

        Schema::table('doc_invoice_line', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('ref_products')
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
        Schema::table('doc_invoice_line', function (Blueprint $table) {
            $table->dropForeign('doc_invoice_line_product_id_foreign');
        });
    }
}
