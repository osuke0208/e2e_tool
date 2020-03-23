<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScenarioScript;
use App\Models\Scenario;
use App\Models\ScenarioScriptParameterEvent;

class ScenarioScriptController extends ScenarioController
{
    //
    public $domain = 'scenario_script';
    public $parent_domain = 'scenario';

    public function model(){
      return new ScenarioScript;
    }

    public function get_parent_id($item){
      return $item->scenario->id;
    }

    public function create(Request $request, $id = null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);

      $items->fill($form)->save();
      return redirect($this->parent_domain.'/'.$id.'/detail/'.$form['scenario_id']);
    }

    public function update(Request $request, $id = null){
      $comment = $this->model()->find($request->scenario_script_id);
      $form = $request->all();
      unset($form['_token']);
      unset($form['scenario_script_id']);
      $comment->fill($form)->save();

      return redirect($this->parent_domain.'/'.$id.'/detail/'.$request->scenario_id);
    }

}
