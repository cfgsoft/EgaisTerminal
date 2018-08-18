<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descr');
            $table->string('code',10);
            $table->string('version')->nullable();
            $table->string('ismark')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
			$table->string('descr');
			$table->string('code',10);
			$table->string('version')->nullable();
			$table->string('ismark')->nullable();
            $table->integer('category_id')->unsigned();
            $table->timestamps();

            //$table->foreign('category_id')->reference('id')->on('categories')
            //    ->onDelete('restrict')->onUpdate('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
}
