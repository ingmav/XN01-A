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
            $table->Increments('id')->unsigned();
            $table->integer('ventas_id')->unsigned();
            
            $table->string('clave_articulo');
            $table->integer('articulo_id')->unsigned();
            $table->decimal('unidades', 15 , 2)->default(0);
            $table->decimal('precio_unitario', 15, 2)->default(0);
            $table->decimal('porcentaje_descuento', 15, 2)->default(0);
            $table->decimal('descuento_extra', 15, 2)->default(0);
            $table->decimal('precio_total_neto', 15, 2)->default(0);
            $table->text('notas');

            $table->foreign('articulo_id')->references('id')->on('ms_articulos')
                        ->onUpdate('cascade')
                        ->onDelete('cascade');

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
        Schema::drop('ms_ventas_detalles');
    }
}
