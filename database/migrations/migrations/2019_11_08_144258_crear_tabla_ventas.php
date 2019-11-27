<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('ventas', function (Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->string('folio');
            $table->date('fecha');
            $table->time('hora');
            $table->string('clave_cliente');
            $table->string('tipo_descuento');
            $table->string('descuento_porcentaje');
            $table->string('descuento_importe');
            $table->string('estatus');
            $table->string('descripcion');
            $table->string('importe_neto');
            $table->string('otros_cargos');
            $table->string('otros_impuestos');
            $table->string('metodo_pago_sat');

            $table->Integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            
            $table->integer('cliente_direccion_id')->unsigned();
            $table->foreign('cliente_direccion_id')->references('id')->on('cliente_direccion');

            $table->integer('direccion_consig_id')->unsigned();
            $table->foreign('direccion_consig_id')->references('id')->on('cliente_direccion');

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
       Schema::drop ('ventas'); 
    }
}
