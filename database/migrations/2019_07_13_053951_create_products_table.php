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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('producto',50);
            $table->unsignedBigInteger('unidad_id');
            $table->foreign('unidad_id')->references('id')->on('units');
            $table->unsignedBigInteger('familia_id');
            $table->foreign('familia_id')->references('id')->on('familias');
            $table->integer('limite');
            $table->integer('cantidad')->default('0');
            $table->smallInteger('estado')->default('1');
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
        Schema::dropIfExists('products');
    }
}
