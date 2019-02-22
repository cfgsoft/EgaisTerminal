<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReturnedInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_returned_invoice_mark_line', function (Blueprint $table) {
            $table->string('pack_number', 26)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_returned_invoice_mark_line', function (Blueprint $table) {
            $table->dropColumn('pack_number');
        });
    }
}
