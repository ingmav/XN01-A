<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('msw_produccion', function(Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->integer('docto_ve_id')->unsigned();
            $table->boolean('diseno');
            $table->boolean('estatus_diseno');
            $table->boolean('impresion');
            $table->boolean('estatus_impresion');
            $table->boolean('preparacion');
            $table->boolean('estatus_preparacion');
            $table->boolean('entrega');
            $table->boolean('estatus_entrega');
            $table->boolean('instalacion');
            $table->boolean('estatus_instalacion');
            $table->text('detalles');
            
            $table->foreign('docto_ve_id')->references('id')->on('ms_ventas');
            
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
        Schema::drop('msw_produccion');
    }
}
