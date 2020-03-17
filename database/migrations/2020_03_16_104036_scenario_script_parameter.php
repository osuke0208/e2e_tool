<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScenarioScriptParameter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('scenario_script_parameters', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->integer('scenario_operation_id');
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
        Schema::dropIfExists('scenario_script_parameters');
    }
}
