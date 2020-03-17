<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScenarioScript;
use App\Models\Scenario;
use App\Models\ScenarioScriptParameterEvent;

class ScenarioScriptController extends ScenarioParameterController
{
    //
    public $domain = 'scenario_script';

    public function model(){
      return new ScenarioScript;
    }

    function add(Request $request ,$id = null){
      $scenarios = Scenario::all();
      return view($this->domain.'.add',[
        'id'=>$id,
        'scenarios' => $scenarios,
        'domain' => $this->domain
      ]);
    }

    public function create(Request $request, $id = null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);

      $items->fill($form)->save();
      return redirect($this->domain.'/'.$id);
    }
    /*
    public function create( Request $request, $id=null ){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);

      $parameter = $this->make_script_data($form['scenario_script_parameter']);
      $script = [
        'name' => $form['scenario_script']['name'],
        'scenario_id' => $form['scenario_id']
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
    */
}
