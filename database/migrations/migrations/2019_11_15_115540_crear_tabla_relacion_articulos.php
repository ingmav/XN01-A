<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaRelacionArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('relacion_aticulos', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->foreign('articulo_id')->references('id')->on('articulos');
            $table->string('estatus');
            $table->string('cantidad');
            $table->string('automatico');
            $table->unsignedInteger('ms_articulos_id');
            $table->foreign('ms_articulos_id')->references('id')->on('ms_articulos');
            $table->timestamps();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('relacion_articulos');
    }
}
