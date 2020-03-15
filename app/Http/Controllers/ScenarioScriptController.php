<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScenarioScript;
use App\Models\Scenario;

class ScenarioScriptController extends ScenarioParameterController
{
    //
    public $domain = 'scenario_script';

    public function model(){
      return new ScenarioScript;
    }
}
