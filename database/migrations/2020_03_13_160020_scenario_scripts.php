<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScenarioScripts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('scenario_scripts', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('scenario_id')->unsigned();
          $table->foreign('scenario_id')->references('id')->on('scenarios')->onDelete('cascade');
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
        Schema::dropIfExists('scenario_scripts');
    }
}
