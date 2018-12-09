<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBarcode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('number', 11)->change();
            $table->string('barcode', 12)->change();
            $table->integer('Quantity')->default(0);
            $table->integer('QuantityMarks')->default(0);

            $table->smallInteger('DocType');
            $table->uuid('DocId');

            $table->unique('barcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique('orders_barcode_unique');

            $table->string('number', 10)->change();
            $table->string('barcode', 11)->change();
            $table->dropColumn(['Quantity','QuantityMarks', 'DocType', 'DocId'] );
        });
    }
}
