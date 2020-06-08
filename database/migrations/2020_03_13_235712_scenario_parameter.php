<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScenarioParameter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('scenario_paramaters');
        Schema::create('scenario_parameters', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('scenario_id')->unsigned();
          //$table->foreign('scenario_id')->references('id')->on('scenarios')->onDelete('cascade');
          $table->string('value');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('scenario_parameters');
    }
}
