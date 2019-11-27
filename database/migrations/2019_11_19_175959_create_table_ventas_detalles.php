<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVentasDetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('ms_ventas_detalles', function(Blueprint $table) {
            $table->Integer('docto_ve_id')->unsigned();
            $table->Integer('docto_ve_det_id')->unsigned();
            $table->string('clave_articulo');
            $table->integer('articulos_id')->unsigned();
            $table->decimal('unidades', 15 , 2);
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('porcentaje_descuento', 15, 2);
            $table->string('descuento_extra', 15, 2);
            $table->decimal('precio_total_neto', 15, 2);
            $table->text('notas');

            $table->primary(['docto_ve_id', 'docto_ve_det_id']);
         
            $table->foreign('articulo_id')->references('id')->on('ms_articulos');
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
        Schema::drop('ms_ventas_detalles');
    }
}
