<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaServidores extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('servidores', function (Blueprint $table) {            
            $table->string('id',4); // 0001, 0002, ..., NNNN
            $table->string('nombre');
            $table->string('secret_key',32);
            $table->boolean('tiene_internet')->default(0);   
            $table->boolean('catalogos_actualizados')->default(0); 
            $table->string('version')->default("1.0");         
            $table->integer('periodo_sincronizacion')->default(24);
            $table->boolean('principal')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->primary('id');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        
        Schema::drop('servidores');
    }
}
