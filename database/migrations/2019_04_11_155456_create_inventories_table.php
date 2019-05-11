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
            $table->string('name_short',40);
            $table->string('code',10)->unique();
            $table->string('version')->nullable();
            $table->boolean('mark')->default(false);
            $table->boolean('lic')->default(false);
            $table->string('city',40)->nullable();
            $table->string('street',40)->nullable();
            $table->string('house',20)->nullable();
            $table->timestamps();

            $table->index(['descr', 'id']);
            $table->index(['name_short', 'id']);
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

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
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
