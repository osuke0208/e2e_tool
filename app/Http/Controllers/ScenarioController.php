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

    public function detail(Request $request, $id = null, $this_id = null){
      $item = $this->model()->find($this_id);
      return view($this->domain.'.detail',[
        'id' => $id,
        'item'  => $item,
        'domain' => $this->domain,
        'this_id' => $this_id
      ]);
    }

    function add(Request $request,$id = null,$parent_id = null){
      return view($this->domain.'.add',[
        'id'=>$id,
        'domain' => $this->domain,
        'parent_id' => $parent_id,
      ]);
    }

    public function create(Request $request, $id = null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);
      $items->fill($form)->save();
      return redirect($this->parent_domain.'/'.$id);
    }

}
