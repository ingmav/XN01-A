<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaVentasDetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('ventas_detalles', function(Blueprint $table) {
            $table->Increments('id')->unsigned();
            $table->string('clave_articulo');
            $table->tinyInteger('unidades');
            $table->decimal('precio_unitario', 15, 2);
            $table->string('porcentaje_descuento');
            $table->string('descuento_extra');
            $table->decimal('precio_total_neto', 15, 2);
            $table->text('memo');
            $table->tinyInteger('posicion');

            $table->integer('articulo_id')->unsigned();
            $table->foreign('articulo_id')->references('id')->on('articulos');

                       
            $table->integer('docto_ve_id')->unsigned();
            $table->foreign('docto_ve_id')->references('id')->on('ventas');

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
       Schema::drop ('ventas_detalles');
    }
}
