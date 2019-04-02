<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoice3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE ref_categories MODIFY COLUMN parent_id INT(10) AFTER ismark');
        DB::statement('ALTER TABLE ref_categories MODIFY COLUMN parent_code VARCHAR (10) AFTER parent_id');

        Schema::table('doc_invoice_line', function (Blueprint $table) {
            $table->integer('quantity_pack')->default(0)->change();
            $table->integer('quantity_pack_mark')->default(0)->change();
            $table->integer('quantity_pallet')->default(0)->change();
            $table->integer('quantity_pallet_mark')->default(0)->change();
        });

        Schema::create('ref_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descr',100);
            $table->string('code',9)->unique();
            $table->string('version',12)->nullable();
            $table->boolean('ismark')->default(false);
            $table->string('address_post')->nullable();
            $table->timestamps();
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
            $table->integer('quantity_pack')->change();
            $table->integer('quantity_pack_mark')->change();
            $table->integer('quantity_pallet')->change();
            $table->integer('quantity_pallet_mark')->change();
        });

        Schema::dropIfExists('ref_customers');
    }
}
