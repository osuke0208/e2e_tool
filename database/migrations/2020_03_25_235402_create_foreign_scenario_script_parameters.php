<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignScenarioScriptParameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*
        Schema::table('scenario_script_parameters', function (Blueprint $table) {
          $table->foreign('scenario_operation_id')->references('id')->on('scenario_operations')->onDelete('cascade');
        });
      */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foreign_scenario_script_parameters');
    }
}
