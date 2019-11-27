<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaClienteDireccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_direccion', function (Blueprint $table) {
             
            $table->Increments('id')->unsigned();              
            $table->string('nombre_consig');
            $table->string('calle');
            $table->string('nombre_calle');
            $table->string('num_exterior');
            $table->string('num_interior');
            $table->string('colonia');
            $table->string('colonia_clave_fiscal');
            $table->string('poblacion');
            $table->string('poblacion_clave_fiscal');
            $table->string('referencia');
            $table->string('codigo_postal');
            $table->string('telefono1');
            $table->string('telefono2');
            $table->string('rfc_curp');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
                       
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cliente_direccion');
    }
}
