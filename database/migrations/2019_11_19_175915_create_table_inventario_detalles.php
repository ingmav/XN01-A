<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInventarioDetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msw_inventario_detallado', function(Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->decimal('cantidad',15,2);
            $table->decimal('base',15,2);
            $table->decimal('altura',15,2);
            $table->decimal('m2',15,2);
            $table->decimal('ml',15,2);
            $table->decimal('precio_unitario',15,2);
            $table->string('descripcion');
            $table->date('fecha');
            /*$table->unsignedInteger('articulos_id');
            $table->foreign('articulos_id')->references('id')->on('articulos');
            $table->string('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');*/

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
        Schema::drop('msw_inventario_detallado');
    }
}
