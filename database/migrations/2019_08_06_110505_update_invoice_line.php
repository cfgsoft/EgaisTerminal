<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoiceLine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_invoice_line', function (Blueprint $table) {
            $table->integer('product_egais_id')->unsigned()->nullable();

            $table->foreign('product_egais_id')->references('id')->on('ref_product_egais')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->dropForeign('doc_invoice_line_product_id_foreign');
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
            $table->dropForeign('doc_invoice_line_product_egais_id_foreign');

            $table->dropColumn('product_egais_id');

            $table->foreign('product_id', 'doc_invoice_line_product_id_foreign')->references('id')->on('ref_product_egais')
                ->onDelete('restrict')->onUpdate('restrict');
        });
    }
}
