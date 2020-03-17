<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScenarioOperation;
use App\Models\ScenarioScript;
use App\Models\ScenarioScriptParameterEvent;

class ScenarioOperationController extends ScenarioParameterController
{
    //
    public $domain = 'scenario_operation';

    public function model(){
      return new ScenarioOperation;
    }
    public function add(Request $request, $id = null){
      $scenarios = ScenarioScript::all();
      $events = ScenarioScriptParameterEvent::all();
      return view($this->domain.'.add',[
        'id'=>$id,
        'scenario_scripts' => $scenarios,
        'events' => $events,
        'domain' => $this->domain
      ]);
    }

    public function create( Request $request, $id=null ){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);

      $parameter = $this->make_script_data($form['scenario_script_parameter']);
      $script = [
        'name' => $form['scenario_script']['name'],
        'scenario_script_id' => $form['scenario_script_id']
      ];

      $items->fill($script)->save();
      $items->scenario_script_parameter()->createMany($parameter);

     return redirect($this->domain.'/'.$id);
    }

    public function make_script_data( $form ){
      foreach($form as $key => $value){
        $parameter[] = [
          'name' => $key,
          'value' =>  $value,
          'created_at' => now(),
          'updated_at' => now()
        ];
      }
      return $parameter;
    }

}
