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
}
