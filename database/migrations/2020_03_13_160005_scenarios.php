<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Scenarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('scenarios', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('scenario_group_id')->unsigned();
        //  $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
          $table->integer('user_id');
          $table->string('description');

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
        Schema::dropIfExists('scenarios');
    }
}
