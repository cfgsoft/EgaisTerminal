<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('excise_stamps', function (Blueprint $table) {
            $table->string('barcode',150);
        });

        /*
        Schema::create('ref_excise_stamps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',10)->unique();
            $table->string('version')->nullable();
            $table->boolean('mark')->default(false);
            $table->string('mark_code',150);

            $table->integer('department_id')->nullable()->unsigned();
            $table->integer('product_id')->nullable()->unsigned();
            $table->string('f1reg_id',19)->nullable();
            $table->string('f2reg_id',19)->nullable();
            $table->timestamps();

            $table->unique(['mark_code', 'department_id']);

            $table->foreign('department_id')->references('id')->on('ref_departments')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('product_id')->references('id')->on('ref_products')
                ->onDelete('restrict')->onUpdate('restrict');

        });
        */

        Schema::create('doc_inventory_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id')->unsigned();

            $table->integer('product_id')->nullable()->unsigned();
            $table->string('product_descr',128)->default('');
            $table->string('f2reg_id',19)->nullable();
            $table->integer('quantity')->default(0)->unsigned();
            $table->integer('quantity_pack')->default(0)->unsigned();
            $table->integer('quantity_pallet')->default(0)->unsigned();
            $table->boolean('show_first')->default(false);
            $table->timestamps();

            $table->foreign('inventory_id')->references('id')->on('doc_inventory')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_inventory_mark_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id')->unsigned();

            $table->string('mark_code', 150);
            $table->string('pack_number', 26)->nullable();
            $table->integer('quantity')->default(0);
            $table->boolean('savedin1c')->default(false);
            $table->timestamps();

            $table->unique(['mark_code', 'inventory_id']);

            $table->foreign('inventory_id')->references('id')->on('doc_inventory')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_inventory_pack_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id')->unsigned();

            $table->string('pack_number', 26);
            $table->string('pallet_number', 26)->nullable();
            $table->integer('quantity')->default(0);
            $table->boolean('savedin1c')->default(false);
            $table->timestamps();

            $table->foreign('inventory_id')->references('id')->on('doc_inventory')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_inventory_pallet_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id')->unsigned();

            $table->string('pallet_number', 26);
            $table->boolean('savedin1c')->default(false);
            $table->timestamps();

            $table->foreign('inventory_id')->references('id')->on('doc_inventory')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_inventory_error_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id')->unsigned();

            $table->string('mark_code', 150);
            $table->string('message', 200);
            $table->boolean('savedin1c')->default(false);
            $table->timestamps();

            $table->foreign('inventory_id')->references('id')->on('doc_inventory')
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
        Schema::table('excise_stamps', function (Blueprint $table) {
            $table->dropColumn('barcode');
        });

        Schema::dropIfExists('doc_inventory_error_line');
        Schema::dropIfExists('doc_inventory_pallet_line');
        Schema::dropIfExists('doc_inventory_pack_line');
        Schema::dropIfExists('doc_inventory_mark_line');
        Schema::dropIfExists('doc_inventory_line');

    }
}
