<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_invoice_pallet_line', function (Blueprint $table) {
            $table->renameColumn('mark_code', 'pallet_number');
        });

        Schema::table('doc_invoice_pack_line', function (Blueprint $table) {
            $table->renameColumn('mark_code', 'pack_number');
            $table->string('pallet_number', 26)->nullable();
        });

        Schema::table('doc_invoice_mark_line', function (Blueprint $table) {
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
        Schema::table('doc_invoice_pallet_line', function (Blueprint $table) {
            $table->renameColumn('pallet_number', 'mark_code');
        });

        Schema::table('doc_invoice_pack_line', function (Blueprint $table) {
            $table->renameColumn('pack_number', 'mark_code');
            $table->dropColumn('pallet_number');
        });

        Schema::table('doc_invoice_mark_line', function (Blueprint $table) {
            $table->dropColumn('pack_number');
        });
    }
}
