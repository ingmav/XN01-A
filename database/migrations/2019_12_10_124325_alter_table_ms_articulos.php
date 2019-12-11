<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMsArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_articulos', function (Blueprint $table) {
            $table->tinyInteger('tipo')->after("nombre")->nullable()->default(2)->commnets("1= Digital, 2 =Gran Formato");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_articulos', function (Blueprint $table) {
            $table->dropColumn(['tipo']);
        });
    }
}
