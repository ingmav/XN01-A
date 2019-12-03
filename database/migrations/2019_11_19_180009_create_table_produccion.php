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
            $table->Integer('ventas_id')->unsigned();
            $table->boolean('diseno')->default(0);
            $table->boolean('estatus_diseno')->default(0);
            $table->boolean('calendario_diseno')->default(0);
            $table->boolean('impresion_gf')->default(0);
            $table->boolean('estatus_impresion_gf')->default(0);
            $table->boolean('calendario_impresion_gf')->default(0);
            $table->boolean('impresion_digital')->default(0);
            $table->boolean('estatus_impresion_digital')->default(0);
            $table->boolean('calendario_impresion_digital')->default(0);
            $table->boolean('preparacion')->default(0);
            $table->boolean('estatus_preparacion')->default(0);
            $table->boolean('calendario_preparacion')->default(0);
            $table->boolean('entrega')->default(0);
            $table->boolean('estatus_entrega')->default(0);
            $table->boolean('calendario_entrega')->default(0);
            $table->boolean('instalacion')->default(0);
            $table->boolean('estatus_instalacion')->default(0);
            $table->boolean('calendario_instalacion')->default(0);
            $table->boolean('maquilas')->default(0);
            $table->boolean('estatus_maquilas')->default(0);
            $table->boolean('calendario_maquilas')->default(0);
            $table->text('detalles');
            $table->boolean('estatus')->default(0);
            
            $table->foreign('ventas_id')->references('id')->on('ms_ventas')
                        ->onUpdate('cascade')
                        ->onDelete('cascade');
            
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
