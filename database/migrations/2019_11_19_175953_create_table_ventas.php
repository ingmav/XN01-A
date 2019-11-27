<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('ms_ventas', function (Blueprint $table){
            $table->Integer('docto_ve_id')->unsigned()->primary();
            $table->smalInteger('tipo_venta')->default(1)->unsigned();
            $table->string('folio');
            $table->date('fecha');
            $table->time('hora');
            $table->string('clave_cliente');
            $table->integer('cliente_id')->nullable()->unsigned();;
            $table->string('tipo_descuento', 2);
            $table->decimal('descuento_porcentaje', 15,2);
            $table->decimal('descuento_importe', 15,2);
            $table->string('estatus',2);
            $table->string('descripcion', 255);
            $table->decimal('importe_neto', 15,2);
            
            $table->foreign('cliente_id')->references('id')->on('ms_clientes');
            
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
        Schema::drop('ms_ventas');
    }
}
