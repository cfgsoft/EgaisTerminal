<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReadBarCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('read_bar_codes', function (Blueprint $table) {
            $table->string('productcode', 19)->nullable();
            $table->string('f1regid',19)->nullable();
            $table->string('f2regid',19)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('read_bar_codes', function (Blueprint $table) {
            $table->dropColumn(['productcode','f1regid', 'f2regid']);
        });
    }
}
