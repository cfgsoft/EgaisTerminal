<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoiceDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_invoice', function (Blueprint $table) {
            $table->integer('department_id')->unsigned()->nullable();
            $table->boolean('savedin1c')->default(false);

            $table->foreign('department_id')->references('id')->on('ref_departments')
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
        Schema::table('doc_invoice', function (Blueprint $table) {
            $table->dropForeign('doc_invoice_department_id_foreign');

            $table->dropColumn('department_id');
            $table->dropColumn('savedin1c');
        });
    }
}
