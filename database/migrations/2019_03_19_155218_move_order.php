<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //->after('column')
        DB::statement('ALTER TABLE doc_order_pack_line MODIFY COLUMN pallet_number VARCHAR(26) AFTER markcode');
        DB::statement('ALTER TABLE doc_order_mark_line MODIFY COLUMN boxnumber VARCHAR(26) AFTER markcode');
        DB::statement('ALTER TABLE doc_order_mark_line MODIFY COLUMN f2regid VARCHAR(19) AFTER productcode');
        DB::statement('ALTER TABLE doc_order_line MODIFY COLUMN f2regid VARCHAR(19) AFTER productcode');
        DB::statement('ALTER TABLE doc_order_error_line MODIFY COLUMN product_code VARCHAR(19) AFTER order_id');
        DB::statement('ALTER TABLE doc_order_error_line MODIFY COLUMN f2reg_id VARCHAR(19) AFTER product_code');
        DB::statement('ALTER TABLE doc_order_error_line MODIFY COLUMN savedin1c TINYINT(1) AFTER message');
        DB::statement('ALTER TABLE doc_order MODIFY COLUMN Quantity INT(11) AFTER status');
        DB::statement('ALTER TABLE doc_order MODIFY COLUMN QuantityMarks INT(11) AFTER Quantity');
        DB::statement('ALTER TABLE doc_order MODIFY COLUMN DocType SMALLINT(6) AFTER QuantityMarks');
        DB::statement('ALTER TABLE doc_order MODIFY COLUMN DocId CHAR(36) AFTER DocType');

        Schema::table('doc_order', function (Blueprint $table) {
            $table->renameColumn('Quantity', 'quantity');
            $table->renameColumn('QuantityMarks', 'quantity_mark');
            $table->renameColumn('DocType', 'doc_type');
            $table->renameColumn('DocId', 'doc_id');
        });

        Schema::table('doc_order_line', function (Blueprint $table) {
            $table->renameColumn('orderlineid', 'line_id');
            $table->renameColumn('productdescr', 'product_descr');
            $table->renameColumn('productcode', 'product_code');
            $table->renameColumn('f2regid', 'f2reg_id');
            $table->renameColumn('quantitymarks', 'quantity_mark');
            $table->renameColumn('showfirst', 'show_first');
        });

        Schema::table('doc_order_mark_line', function (Blueprint $table) {
            $table->renameColumn('orderlineid', 'line_id');
            $table->renameColumn('productcode', 'product_code');
            $table->renameColumn('f2regid', 'f2reg_id');
            $table->renameColumn('boxnumber', 'pack_number');
        });

        Schema::table('doc_order_pack_line', function (Blueprint $table) {
            $table->renameColumn('orderlineid', 'line_id');
            $table->renameColumn('productcode', 'product_code');
            $table->renameColumn('f2regid', 'f2reg_id');
            $table->renameColumn('markcode', 'pack_number');
        });

        Schema::rename('categories', 'ref_categories');
        Schema::rename('products', 'ref_products');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_order', function (Blueprint $table) {
            $table->renameColumn('quantity', 'Quantity');
            $table->renameColumn('quantity_mark', 'QuantityMarks');
            $table->renameColumn('doc_type', 'DocType');
            $table->renameColumn('doc_id', 'DocId');
        });

        Schema::table('doc_order_line', function (Blueprint $table) {
            $table->renameColumn('line_id', 'orderlineid');
            $table->renameColumn('product_descr', 'productdescr');
            $table->renameColumn('product_code', 'productcode');
            $table->renameColumn('f2reg_id', 'f2regid');
            $table->renameColumn('quantity_mark', 'quantitymarks');
            $table->renameColumn('show_first', 'showfirst');
        });

        Schema::table('doc_order_mark_line', function (Blueprint $table) {
            $table->renameColumn('line_id', 'orderlineid');
            $table->renameColumn('product_code', 'productcode');
            $table->renameColumn('f2reg_id', 'f2regid');
            $table->renameColumn('pack_number', 'boxnumber');
        });

        Schema::table('doc_order_pack_line', function (Blueprint $table) {
            $table->renameColumn('line_id', 'orderlineid');
            $table->renameColumn('product_code', 'productcode');
            $table->renameColumn('f2reg_id', 'f2regid');
            $table->renameColumn('pack_number', 'markcode');
        });

        Schema::rename('ref_categories', 'categories');
        Schema::rename('ref_products', 'products');
    }
}
