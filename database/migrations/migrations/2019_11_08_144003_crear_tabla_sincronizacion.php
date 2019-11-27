<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSincronizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('sincronizacion', function (Blueprint $table){
             $table->Increments('id')->unsigned();
            $table->date('fecha');

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
        Schema::drop('sincronizacion');
    }
}
