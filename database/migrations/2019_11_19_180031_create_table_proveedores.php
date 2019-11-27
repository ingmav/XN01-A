<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('msw_proveedores', function (Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('condicion_pago');
            $table->string('contacto');
            $table->string('descripcion');
            $table->string('cuenta');
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
        Schema::drop('msw_proveedores');
    }
}
