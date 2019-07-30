<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_solicitudes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sol_id');
            $table->foreign('sol_id')->references('id')->on('solicitudes');
            $table->string('producto',50);
            $table->string('unidad',10);
            $table->integer('cantidad');
            $table->integer('entregado')->default('0');
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
        Schema::dropIfExists('detalles_solicitudes');
    }
}
