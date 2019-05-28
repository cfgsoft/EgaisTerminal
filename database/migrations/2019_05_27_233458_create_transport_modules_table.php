<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_transport_module_egais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descr', 100);
            $table->string('code',9)->unique();
            $table->string('version', 12)->nullable();
            $table->boolean('is_mark')->default(false);
            $table->string('fsrar_id',12);
            $table->ipAddress('ip_address');
            $table->integer('port')->default(8080);
            $table->integer('total_in')->default(0);
            $table->integer('total_out')->default(0);
            $table->dateTime('last_date_success')->nullable();
            $table->dateTime('last_date_fail')->nullable();
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
        Schema::dropIfExists('ref_transport_module_egais');
    }
}
