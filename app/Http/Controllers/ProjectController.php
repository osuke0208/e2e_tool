<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends OrganisationController
{
    //
    public $domain = 'project';
    public function model(){
      return new Project;
    }

    public function update(Request $request, $id = null){
      $comment = $this->model()->find($request->project_id);
      $form = $request->all();
      unset($form['_token']);
      unset($form['project_id']);
      $comment->fill($form)->save();

      return redirect($this->domain.'/'.$id);
    }

    public function edit(Request $request, $id = null, $this_id = null, $parent_id = null ){
      $item = $this->model()->find($this_id);
      return view($this->domain.'/add',[
        'id' => $id,
        'domain' => $this->domain,
        'action' => 'edit',
        'item' => $item,
        'parent_id'=> $parent_id
      ]);
    }
}
