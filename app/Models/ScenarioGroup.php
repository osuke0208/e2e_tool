<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScenarioGroup extends Model
{
    //
    protected $guarded = array('id');
    public function scenario(){
      return $this->hasMany('App\Models\Scenario');
    }

    public function project(){
      return $this->belongsTo('App\Models\Project');
    }

}
