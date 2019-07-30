<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdAlmacenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_almacenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('almacen',50);
            $table->string('producto',50);
            $table->string('unidad',20);
            $table->string('familia');
            $table->integer('cantidad')->default('0');
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
        Schema::dropIfExists('prod_almacenes');
    }
}
