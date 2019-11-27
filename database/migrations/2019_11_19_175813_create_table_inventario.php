<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('msw_inventario', function (Blueprint $table){
            $table->Increments('id')->unsigned();
            $table->integer('unidades');
            $table->integer('unidades_restantes');
            $table->decimal('cantidad_m2',15,2);
            $table->decimal('cantidad_m2_restante',15,2);
            $table->decimal('cantidad_ml',15,2);
            $table->decimal('cantidad_ml_restante',15,2);
            $table->decimal('precio_unitario',15,2);
            $table->decimal('total_m2',15,2);
            $table->decimal('total_m2_restante',15,2);
            $table->decimal('total_ml',15,2);
            $table->decimal('total_ml_restante',15,2);

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
        Schema::drop('msw_inventario');
    }
}
