<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProvedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create ('provedores', function (Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->string('nombre');
            $table->string('direccion');
            $table->integer('telefono');
            $table->string('condicion_pago');
            $table->string('contacto');
            $table->string('descripcion');
            $table->integer('cuenta');
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
        Schema::drop ('provedores'); 

    }
}
