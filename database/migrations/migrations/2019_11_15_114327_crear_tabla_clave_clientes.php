<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaClaveClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('clave_clientes', function(Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->string('clave_cliente');
            $table->integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->unsignedInteger('rol_clave_id');
            $table->foreign('rol_clave_id')->references('id')->on('roles');
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
        //
    }
}
