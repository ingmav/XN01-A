<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClaveClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('ms_clave_clientes', function(Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->Integer('cliente_id')->unsigned();
            $table->string('clave_cliente', 5);
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
        Schema::drop('ms_clave_clientes');
    }
}
