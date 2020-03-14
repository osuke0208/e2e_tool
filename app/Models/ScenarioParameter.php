<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScenarioParameter extends Model
{
    //
    protected $guarded = array('id');
    public static $rules = array(
      'name' => 'required',
      'scenario_id' => 'required',
      'value' => 'required'
    );

    public function scenario(){
      return $this->belongsTo('App\Models\Scenario');
    }
}
