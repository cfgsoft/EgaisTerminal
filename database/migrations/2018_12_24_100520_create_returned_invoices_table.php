<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnedInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_returned_invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('number', 11);
            $table->string('barcode', 12)->unique();
            $table->integer('status')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('quantity_mark')->default(0);
            $table->smallInteger('doc_type');
            $table->uuid('doc_id');
            $table->timestamps();
        });

        Schema::create('doc_returned_invoice_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('returned_invoice_id')->unsigned();
            $table->integer('lineid')->unsigned();
            $table->string('productdescr', 100);
            $table->string('productcode', 19);
            $table->string('f1regid',19);
            $table->string('f2regid',19);
            $table->integer('quantity')->default(0);
            $table->integer('quantity_mark')->default(0);
            $table->boolean('show_first');
            $table->timestamps();

            $table->foreign('returned_invoice_id')->references('id')->on('doc_returned_invoice')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_returned_invoice_mark_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('returned_invoice_id')->unsigned();
            $table->integer('lineid')->unsigned();
            $table->string('f2regid', 19);
            $table->string('markcode', 150);
            $table->integer('quantity')->default(0);
            $table->boolean('savedin1c');
            $table->timestamps();

            $table->index('markcode');

            $table->foreign('returned_invoice_id')->references('id')->on('doc_returned_invoice')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_returned_invoice_pack_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('returned_invoice_id')->unsigned();
            $table->integer('lineid')->unsigned();
            $table->string('f2regid', 19);
            $table->string('markcode', 26);
            $table->integer('quantity')->default(0);
            $table->boolean('savedin1c');
            $table->timestamps();

            $table->index('markcode');

            $table->foreign('returned_invoice_id')->references('id')->on('doc_returned_invoice')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_returned_invoice_error_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('returned_invoice_id')->unsigned();
            $table->string('markcode', 150);
            $table->string('message', 200);
            $table->timestamps();

            $table->foreign('returned_invoice_id')->references('id')->on('doc_returned_invoice')
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
        Schema::dropIfExists('doc_returned_invoice_error_lines');
        Schema::dropIfExists('doc_returned_invoice_pack_line');
        Schema::dropIfExists('doc_returned_invoice_mark_line');
        Schema::dropIfExists('doc_returned_invoice_line');
        Schema::dropIfExists('doc_returned_invoice');
    }
}
