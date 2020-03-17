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

    public function create(Request $request, $id = null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);
      //使わなそうなので1固定
      $form['organisation_id'] = '1';
      $items->fill($form)->save();
      return redirect($this->domain.'/'.$id);
    }
}
