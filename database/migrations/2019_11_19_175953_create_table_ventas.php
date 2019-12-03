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
            //$table->Integer('docto_ve_id')->unsigned()->primary();
            $table->Increments('id')->unsigned();
            $table->Integer('tipo_venta')->default(1)->unsigned();
            $table->string('folio',9);
            $table->date('fecha');
            $table->time('hora');
            $table->string('clave_cliente', 5);
            $table->integer('cliente_id')->nullable()->unsigned();;
            $table->string('tipo_descuento', 2)->default(0);
            $table->decimal('descuento_porcentaje', 15,2)->default(0);
            $table->decimal('descuento_importe', 15,2)->default(0);
            $table->string('estatus',2);
            $table->decimal('importe_neto', 15,2)->default(0);
            $table->string('descripcion', 255);
            $table->boolean('estatus_produccion')->default(0);
            
            $table->foreign('cliente_id')->references('id')->on('ms_clientes')
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
        Schema::drop('ms_ventas');
    }
}
