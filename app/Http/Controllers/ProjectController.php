<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends OrganisationController
{
    //
    public $domain = 'project';
    public $parent_domain = 'organsation';
    public function model(){
      return new Project;
    }

    public function update(Request $request, $id = null){
      $comment = $this->model()->find($request->project_id);
      $form = $request->all();
      $redirect = $this->get_redirect_url($form,$id);
      $form = $this->unset_attributes_edit($form);
      $comment->fill($form)->save();


      return redirect($redirect);
    }

    public function unset_attributes_edit($form){
      unset($form['_token']);
      unset($form['project_id']);
      return $form;
    }


    public function edit(Request $request, $id = null, $this_id = null, $parent_id = null){
      $item = $this->model()->find($this_id);
      return view($this->domain.'/add',[
        'id' => $id,
        'domain' => $this->domain,
        'action' => 'edit',
        'item' => $item,
        'parent_id'=> $parent_id,
        'parent_domain' => $this->parent_domain
      ]);
    }


    public function get_id($form) {
      return $form['project_id'];
    }

    public function get_redirect_url( $form ,$id ){
      return $this->domain.'/'.$id;
    }
}
