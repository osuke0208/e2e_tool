<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    //
    protected $guarded = array('id');
    public static $rules = array(
      'name' => 'required',
      'user_id' => 'required'
    );

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function scenario_parameter(){
      return $this->hasMany('App\Models\ScenarioParameter');
    }

    public function scenario_group(){
      return $this->belongsTo('App\Models\ScenarioGroup', 'scenario_group_id');
    }

    public function scenario_script(){
      return $this->hasMany('App\Models\ScenarioScript');
    }

    public function make_json(){
      $json_parameters = [];
      foreach($this->scenario_parameter as $scenario_parameter){
        $json_parameters[$scenario_parameter->name] =  $scenario_parameter->value;
      }

      $json_scripts = [];
      foreach($this->scenario_script as $scenario_script){
        $json_scripts[] = $scenario_script->name;
      }

      $json_str = [
        'scenarios' => array_values(array_unique($json_scripts)),
        'params' => $json_parameters
      ];

      return  json_encode($json_str,JSON_PRETTY_PRINT);

    }

    public function scopeNameEqual($query,$name){
      return $query->where('name' , $name);
    }
}
