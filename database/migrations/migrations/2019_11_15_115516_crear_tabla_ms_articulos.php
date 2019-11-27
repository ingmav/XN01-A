<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaMsArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('ms_articulos', function(Blueprint $table){
                $table->Increments('id')->unsigned();
                $table->string('nombre');
                $table->string('estatus');
                $table->unsignedInteger('ms_familia_id');
                $table->foreign('ms_familia_id')->references('id')->on('familia');
                $table->string('cantidad_minima');
                $table->string('actualizacion');
                $table->string('unitario');
                $table->string('ancho');
                $table->string('unidad_venta');
                $table->string('paquete');
                $table->string('unidad_compra');
                $table->string('largo');
                $table->string('unidad_principal');
                $table->string('tipo');
                $table->string('exportable');
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
        Schema::drop ('mas_articulos');
    }
}
