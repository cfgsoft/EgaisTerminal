<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExciseStamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('excise_stamp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode', 150);
            $table->string('productcode', 19);
            $table->string('f1regid',19);
            $table->string('f2regid',19);
            $table->integer('department_id')->unsigned();
            $table->timestamps();

            $table->unique(['barcode', 'department_id']);

            //$table->foreign('department_id')->references('id')->on('ref_departments')
            //    ->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::table('excise_stamps', function (Blueprint $table) {
            //$table->integer('id_new');
            //$table->unique(['barcode', 'department_id']);
        });

        Schema::table('excise_stamp_boxes', function (Blueprint $table) {
            $table->dropUnique('excise_stamp_boxes_barcode_unique');
            $table->unique(['barcode', 'department_id']);
        });

        Schema::table('excise_stamp_pallet', function (Blueprint $table) {
            $table->dropUnique('excise_stamp_pallet_barcode_unique');
            $table->unique(['barcode', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excise_stamp');

        Schema::table('excise_stamps', function (Blueprint $table) {
            //$table->dropColumn('id_new');
            //$table->dropUnique('excise_stamps_barcode_department_id_unique');
        });

        Schema::table('excise_stamp_boxes', function (Blueprint $table) {
            $table->unique('barcode');
            $table->dropUnique('excise_stamp_boxes_barcode_department_id_unique');
        });

        Schema::table('excise_stamp_pallet', function (Blueprint $table) {
            $table->unique('barcode');
            $table->dropUnique('excise_stamp_pallet_barcode_department_id_unique');
        });
    }
}
