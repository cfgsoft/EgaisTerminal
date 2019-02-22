<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExciseStampPalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_invoice_pallet_line', function (Blueprint $table) {
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

        Schema::create('excise_stamp_pallet', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('own_id')->unsigned();
            $table->string('barcode', 26)->unique();
            $table->string('productcode', 19)->nullable();
            $table->string('f1regid',19)->nullable();
            $table->string('f2regid',19)->nullable();
            $table->timestamps();
        });

        Schema::create('excise_stamp_pallet_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pallet_id')->unsigned();
            $table->integer('box_id')->unsigned();
            $table->timestamps();

            $table->foreign('pallet_id')->references('id')->on('excise_stamp_pallet')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('box_id')->references('id')->on('excise_stamp_boxes')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->unique(['pallet_id', 'box_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_invoice_pallet_line');
        Schema::dropIfExists('excise_stamp_pallet_line');
        Schema::dropIfExists('excise_stamp_pallet');
    }
}
