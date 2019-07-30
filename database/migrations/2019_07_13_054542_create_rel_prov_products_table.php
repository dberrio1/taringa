<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelProvProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_prov_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prov_id');
            $table->foreign('prov_id')->references('id')->on('providers');
            $table->unsignedBigInteger('prod_id');
            $table->foreign('prod_id')->references('id')->on('products');
            $table->integer('precio');
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
        Schema::dropIfExists('rel_prov_products');
    }
}
