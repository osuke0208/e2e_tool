<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScenarioGroup;

class ScenarioGroupController extends ProjectController
{
    //
    public $domain = 'scenario_group';
    public $parent_domain = 'project';

    public function model(){
      return new ScenarioGroup;
    }

    public function get_parent_id($item){
      return $item->project->id;
    }

    public function detail(Request $request, $id = null, $this_id = null){
      $item = $this->model()->find($this_id);
      $parent_id = $this->get_parent_id($item);
      return view($this->domain.'.detail',[
        'id' => $id,
        'item'  => $item,
        'domain' => $this->domain,
        'this_id' => $this_id,
        'parent_id' => $parent_id
      ]);
    }

    public function unset_attributes_edit($form){
      unset($form['_token']);
      unset($form['scenario_group_id']);
      return $form;
    }

    public function get_id($form) {
      return $form['scenario_group_id'];
    }

    public function get_redirect_url( $form ,$id ){
      return $this->domain.'/'.$id.'/detail/'.$this->get_id($form);
    }
}
