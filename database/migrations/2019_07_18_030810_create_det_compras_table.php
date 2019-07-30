<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('oc_id');
            $table->foreign('oc_id')->references('id')->on('orden_compras');
            $table->string('producto',50);
            $table->string('unidad',10);
            $table->integer('valor_uni');
            $table->integer('cantidad');
            $table->integer('entregado')->default('0');
            $table->integer('total');
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('det_compras');
    }
}
