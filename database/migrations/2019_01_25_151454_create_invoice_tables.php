<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('order_incoming_lines');
        Schema::dropIfExists('order_incomings');

        Schema::create('ref_client_egais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descr',128);
            $table->string('code',12);
            $table->string('inn',12)->nullable();
            $table->string('kpp',9)->nullable();
            $table->string('version',12)->nullable();
            $table->boolean('state');
            $table->timestamps();

            $table->unique('code');
        });

        Schema::create('ref_product_egais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descr',128);
            $table->string('code',19);
            $table->integer('capacity')->default(0)->unsigned();
            $table->integer('alc_volume')->default(0)->unsigned();
            $table->integer('product_v_code');
            $table->string('version',12)->nullable();
            $table->timestamps();

            $table->unique('code');
        });

        Schema::create('doc_invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('number', 11);
            $table->string('barcode', 12)->unique();

            $table->string('incoming_number', 20)->nullable();
            $table->date('incoming_date')->nullable();
            $table->decimal('sum',15,2)->default(0)->unsigned();

            $table->integer('shipper_id')->unsigned()->nullable();
            $table->integer('consignee_id')->unsigned()->nullable();

            $table->integer('quantity')->default(0)->unsigned();
            $table->integer('quantity_mark')->default(0)->unsigned();

            $table->integer('quantity_pack')->default(0)->unsigned();
            $table->integer('quantity_pack_mark')->default(0)->unsigned();

            $table->smallInteger('doc_type');
            $table->uuid('doc_id');
            $table->timestamps();

            $table->unique('doc_id');

            $table->foreign('shipper_id')->references('id')->on('ref_client_egais')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('consignee_id')->references('id')->on('ref_client_egais')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_invoice_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->integer('line_id')->unsigned();
            $table->string('line_identifier', 36);
            $table->integer('product_id')->nullable()->unsigned();
            $table->string('product_descr', 190)->nullable();
            $table->string('product_code', 19)->nullable();
            $table->string('f1reg_id',19)->nullable();
            $table->string('f2reg_id',19)->nullable();
            $table->integer('quantity')->default(0)->unsigned();
            $table->integer('quantity_mark')->default(0)->unsigned();
            $table->boolean('show_first')->default(false);
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('doc_invoice')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('product_id')->references('id')->on('ref_product_egais')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_invoice_mark_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->integer('line_id')->unsigned();
            $table->string('line_identifier', 36);
            $table->string('mark_code', 150);
            $table->boolean('read')->default(false);
            $table->timestamps();

            $table->unique(['mark_code', 'invoice_id']);

            $table->foreign('invoice_id')->references('id')->on('doc_invoice')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_invoice_pack_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->integer('line_id')->unsigned();
            $table->string('line_identifier', 36);
            $table->string('mark_code', 26);
            $table->boolean('read')->default(false);
            $table->timestamps();

            $table->unique(['mark_code', 'invoice_id']);

            $table->foreign('invoice_id')->references('id')->on('doc_invoice')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_invoice_read_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->integer('line_id')->unsigned();
            $table->string('line_identifier', 36);
            $table->string('mark_code', 150);
            $table->boolean('savedin1c')->default(false);
            $table->timestamps();

            $table->index(['mark_code', 'invoice_id']);

            $table->foreign('invoice_id')->references('id')->on('doc_invoice')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_invoice_error_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->string('mark_code', 150);
            $table->string('message', 200);
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('doc_invoice')
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
        Schema::dropIfExists('doc_invoice_error_line');
        Schema::dropIfExists('doc_invoice_read_line');
        Schema::dropIfExists('doc_invoice_pack_line');
        Schema::dropIfExists('doc_invoice_mark_line');
        Schema::dropIfExists('doc_invoice_line');
        Schema::dropIfExists('doc_invoice');

        Schema::dropIfExists('ref_product_egais');
        Schema::dropIfExists('ref_client_egais');
    }
}
