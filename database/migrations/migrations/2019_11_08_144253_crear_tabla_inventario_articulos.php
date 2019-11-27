<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaInventarioArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('inventario_articulos',function(Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->string('descripcion');
            $table->unsignedInteger('modelo_id');
            $table->foreign('modelo_id')->references('id')->on('modelo');
            $table->unsignedInteger('familia_id');
            $table->foreign('familia_id')->references('id')->on('familia');
            $table->unsignedInteger('estatus_id');
            $table->foreign('estatus_id')->references('id')->on('estatus');
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
        Schema::drop('invetario_articulos');
    }
}
