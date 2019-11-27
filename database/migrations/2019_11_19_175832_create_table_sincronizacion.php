<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSincronizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('msw_sincronizacion', function (Blueprint $table){
            $table->Increments('id')->unsigned();
           $table->datetime('fecha');

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
        Schema::drop('msw_sincronizacion');
    }
}
