<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisiones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rut')->unique();
            $table->string('nombre',100);
            $table->string('nombre_corto',50);
            $table->string('giro',100);
            $table->string('direccion',50);
            $table->string('comuna',30);
            $table->string('correo',50);
            $table->bigInteger('fono');
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
        Schema::dropIfExists('divisiones');
    }
}
