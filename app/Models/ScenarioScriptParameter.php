<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScenarioScriptParameter extends Model
{
    //
    protected $guarded = array('id');
    public static $rules = array(
      'name' => 'required',
      'scenario_script_id' => 'required',
      'value' => 'required'
    );

    public function scenario(){
      return $this->belongsTo('App\Models\ScenarioOperation');
    }
}
