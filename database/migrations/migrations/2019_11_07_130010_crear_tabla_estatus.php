<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEstatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('estatus', function (Blueprint $table){
        $table->Increments('id')->unsigned(); 
        $table->integer('pendiente');
        $table->integer('en_proceso');
        $table->integer('en_agenda');
        $table->integer('terminado');
        
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
        Schema::drop ('estatus');
   }
}
