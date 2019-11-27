<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('inventario', function (Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->decimal('cantidad',15,2);
            $table->decimal('cantidad_m2',15,2);
            $table->decimal('cantidad_ml',15,2);
            $table->string('precio');

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
        Schema::drop ('inventario');
     }
}
