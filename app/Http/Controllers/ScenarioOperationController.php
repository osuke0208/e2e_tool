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
    public $parent_domain = 'scenario_script';

    public function model(){
      return new ScenarioOperation;
    }
    public function add(Request $request, $id = null, $parent_id = null){
      $events = ScenarioScriptParameterEvent::all();
      return view($this->domain.'.add',[
        'id'=>$id,
        'parent_id' => $parent_id,
        'events' => $events,
        'domain' => $this->domain,
        'action' => 'add'
      ]);
    }

    public function create( Request $request, $id=null ){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);

      $scenario_script_order = $items
                              ->where('scenario_script_id', $form['scenario_script_id'])
                              ->max('scenario_script_order') + 1;
      $parameter = $this->make_script_data($form['scenario_script_parameter']);
      $script = [
        'name' => $form['scenario_script']['name'],
        'scenario_script_id' => $form['scenario_script_id'],
        'scenario_script_order' => $scenario_script_order
      ];

      $items->fill($script)->save();
      $items->scenario_script_parameter()->createMany($parameter);

     return redirect($this->parent_domain.'/'.$id.'/detail/'.$form['scenario_script_id']);
    }

    public function update(Request $request, $id = null){
      $item = $this->model()->find($request->scenario_operation_id);
      $form = $request->all();
      unset($form['_token']);
      unset($form['scenario_operation_id']);
      $parameter = $this->make_script_data($form['scenario_script_parameter']);
      $script = [
        'name' => $form['scenario_script']['name'],
        'scenario_script_id' => $form['scenario_script_id'],
        'scenario_script_order' => $form['scenario_script_order']
      ];
      $item->fill($script)->save();
      $item->scenario_script_parameter()->createMany($parameter);

      return redirect($this->parent_domain.'/'.$id.'/detail/'.$request->scenario_script_id);
    }

    public function edit(Request $request, $id = null, $parent_id = null, $this_id = null){
      $events = ScenarioScriptParameterEvent::all();
      $item = $this->model()->find($this_id);
      return view($this->domain.'/edit',[
        'id' => $id,
        'domain' => $this->domain,
        'action' => 'edit',
        'item' => $item,
        'events' => $events,
        'parent_id'=> $parent_id,
        'this_id' => $this_id
      ]);
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

    public function get_id( $form ) {
      return $form['scenario_operation_id'];
    }

    public function get_redirect_url( $form , $id ){
      $scenario_script_id = $this->model()->find($this->get_id($form))->scenario_script_id;
      return $this->parent_domain.'/'.$id.'/detail/'. $scenario_script_id;
    }

}
