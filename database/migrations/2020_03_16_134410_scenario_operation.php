<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScenarioOperation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('scenario_operations', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('scenario_script_id')->unsigned();
          $table->foreign('scenario_script_id')->references('id')->on('scenario_scripts')->onDelete('cascade');
          $table->integer('scenario_script_order');
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
        Schema::dropIfExists('scenario_operations');
    }
}
