<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelArticuloTipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('msw_rel_articulo_tipo', function (Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->integer('ms_articulo_id')->unsigned();
            $table->integer('msw_tipo_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            /*$table->foreign('ms_articulo_id')->references('id')->on('ms_articulo')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('msw_tipo_id')->references('id')->on('msw_tipo')
            ->onUpdate('cascade')
            ->onDelete('cascade');*/
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('msw_rel_articulo_tipo');
    }
}
