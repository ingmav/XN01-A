<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('articulos', function (Blueprint $table){
        $table->Increments('id')->unsigned();
        $table->string('nombre');
        $table->string('estatus');
        $table->string('unidad_venta');
        $table->string('unidad_compra');
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
       Schema::drop ('articulos');

    }
}