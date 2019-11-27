<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProduccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('produccion', function(Blueprint $table){
        $table->Increments('id')->unsigned();
        $table->integer('diseno');
        $table->integer('impresion');
        $table->integer('preparacion');
        $table->integer('entrega');
        $table->integer('instalacion');
        $table->text('detalles');
        
        $table->integer('estatus_id')->unsigned();
        $table->foreign('estatus_id')->references('id')->on('estatus');

        $table->integer('ventas_id')->unsigned();
        $table->foreign('ventas_id')->references('id')->on('ventas');
        
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
        Schema::drop ('produccion');
    }
}
