<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScenarioParameter;
use App\Models\Scenario;

class ScenarioParameterController extends ScenarioController
{
    //
    public $domain = 'scenario_parameter';

    public function model(){
      return new ScenarioParameter;
    }

    function add($id = null){
      $scenarios = Scenario::all();
      return view($this->domain.'.add',[
        'id'=>$id,
        'scenarios' => $scenarios
      ]);
    }

    function create(Request $request, $id=null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);

      foreach($form['parameter']['name'] as $key => $name){
        $parameter[$key] = array(
          'name' => $name,
          'value' =>  $form['parameter']['value'][$key],
          'scenario_id' => $form['scenario_id'],
          'created_at' => now(),
          'updated_at' => now()
        );
      };
      $items->insert($parameter);

     return redirect($this->domain.'/'.$id);

    }

}
