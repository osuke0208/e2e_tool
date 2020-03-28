<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScenarioParameter;
use App\Models\Scenario;

class ScenarioParameterController extends ScenarioController
{
    //
    public $domain = 'scenario_parameter';
    public $parent_domain = 'scenario';

    public function model(){
      return new ScenarioParameter;
    }

    function create(Request $request, $id=null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);

      $parameter = $this->make_parameter_data($form);
      $items->insert($parameter);

     return redirect($this->parent_domain.'/'.$id.'/detail/'.$form['scenario_id']);

    }

    public function edit(Request $request, $id = null, $parent_id = null, $this_id = null){
      $item = $this->model()->find($this_id);
      return view($this->domain.'/edit',[
        'id' => $id,
        'domain' => $this->domain,
        'action' => 'edit',
        'item' => $item,
        'parent_id'=> $parent_id,
        'this_id' => $this_id
      ]);
    }

    public function update(Request $request, $id = null){
      $comment = $this->model()->find($request->scenario_id);
      $form = $request->all();
      unset($form['_token']);
      unset($form['scenario_parameter_id']);
      $comment->fill($form)->save();

      return redirect($this->parent_domain.'/'.$id.'/detail/'.$request->scenario_id);
    }

    public function make_parameter_data( $form ){
      foreach($form[$this->domain]['name'] as $key => $name){
        $parameter[$key] = array(
          'name' => $name,
          'value' =>  $form[$this->domain]['value'][$key],
          'scenario_id' => $form['scenario_id'],
          'created_at' => now(),
          'updated_at' => now()
        );
      }
      return $parameter;
    }

    public function get_id( $form ) {
      return $form['scenario_parameter_id'];
    }

    public function get_redirect_url( $form , $id ){
      $scenario_id = $this->model()->find($this->get_id($form))->scenario_id;
      return $this->parent_domain.'/'.$id.'/detail/'. $scenario_id;
    }

}
