<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableArticulosWeb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msw_articulos', function (Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->integer('msw_familia_id')->unsigned();
            $table->string('nombre')->nullable();
            $table->integer('unidad_minimo')->unsigned()->default(0);
            $table->decimal('m2_minimo', 15,2)->default(0);
            $table->decimal('ml_minimo', 15,2)->default(0);
            $table->smallInteger('tipo')->unsigned()->default(1)->nullable()->comments("1= Digital, 2= GF, 3= Otros");
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('msw_familia_id')->references('id')->on('msw_familia')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('msw_articulos');
    }
}
