<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Scenario;
use App\Models\Project;

use Illuminate\Support\Facades\DB;

class ScenarioController extends OrganisationController
{
    //
    public $domain = 'scenario';
    public $parent_domain = 'project';
    public function model(){
      return new Scenario;
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

    function add(Request $request,$id = null,$parent_id = null){
      return view($this->domain.'.add',[
        'id'=>$id,
        'domain' => $this->domain,
        'parent_id' => $parent_id,
        'action' => 'add'
      ]);
    }

    public function create(Request $request, $id = null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);
      $items->fill($form)->save();
      return redirect($this->parent_domain.'/'.$id);
    }

    public function update(Request $request, $id = null){
      $comment = $this->model()->find($request->scenario_id);
      $form = $request->all();
      unset($form['_token']);
      unset($form['scenario_id']);
      $comment->fill($form)->save();

      return redirect($this->domain.'/'.$id.'/detail/'.$request->scenario_id);
    }
}
