<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descr');
            $table->string('short_name',40);
            $table->string('code',10)->unique();
            $table->string('version')->nullable();
            $table->boolean('mark')->default(false);
            $table->boolean('lic')->default(false);
            $table->string('city',40);
            $table->string('street',40);
            $table->string('house',20);
            $table->timestamps();

            $table->index(['descr', 'id']);
            $table->index(['short_name', 'id']);
        });

        Schema::table('excise_stamps', function (Blueprint $table) {
            $table->integer('department_id')->nullable()->unsigned();
        });

        Schema::table('excise_stamp_boxes', function (Blueprint $table) {
            $table->integer('department_id')->nullable()->unsigned();
        });

        Schema::table('excise_stamp_pallet', function (Blueprint $table) {
            $table->integer('department_id')->nullable()->unsigned();
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

        Schema::create('doc_inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('number', 11)->nullable();
            $table->integer('department_id')->nullable()->unsigned();
            $table->integer('quantity_mark')->default(0)->unsigned();
            $table->integer('quantity_pack_mark')->default(0)->unsigned();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('ref_departments')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        /*
        Schema::create('doc_inventory_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id');

            $table->integer('line_id')->unsigned()->nullable();
            $table->integer('product_id')->nullable()->unsigned();
            $table->string('f2reg_id',19)->nullable();
            $table->integer('quantity_mark')->default(0)->unsigned();
            $table->boolean('show_first')->default(false);
            $table->timestamps();

            $table->foreign('inventory_id')->references('id')->on('doc_inventory')
                ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('doc_inventory_mark_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id');
            $table->string('mark_code', 150);
            $table->timestamps();
        });

        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::dropIfExists('doc_inventory_mark_line');
        Schema::dropIfExists('doc_inventory_line');
        Schema::dropIfExists('doc_inventory');
        */

        Schema::dropIfExists('doc_inventory');
        Schema::dropIfExists('ref_departments');

        Schema::table('excise_stamps', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });

        Schema::table('excise_stamp_boxes', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });

        Schema::table('excise_stamp_pallet', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });

    }
}
