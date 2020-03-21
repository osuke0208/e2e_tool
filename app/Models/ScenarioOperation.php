<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScenarioOperation extends Model
{
    //
    protected $guarded = array('id');
    public static $rules = array(
      'name' => 'required',
      'scenario_script_id' => 'required',
      'value' => 'required'
    );

    public function scenario_script(){
      return $this->belongsTo('App\Models\ScenarioScript');
    }

    public function scenario_script_parameter(){
      return $this->hasMany('App\Models\ScenarioScriptParameter');
    }

    function make_json(){
      $json_str = [];
      foreach($this->scenario_script_parameter as $scenario_script_parameter){
        $json_str[$scenario_script_parameter->name] = $scenario_script_parameter->value;
      }
//      return json_encode  ($json_str,JSON_PRETTY_PRINT);
      return json_encode  ($json_str);
    }
}
