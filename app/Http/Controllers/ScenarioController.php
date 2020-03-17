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

    public function model(){
      return new Scenario;
    }

    function add(Request $request,$id = null){
      $projects = Project::all();
      return view($this->domain.'.add',[
        'id'=>$id,
        'domain' => $this->domain,
        'projects' => $projects
      ]);
    }

}
