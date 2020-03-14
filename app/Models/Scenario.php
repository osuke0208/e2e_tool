<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    //
    protected $guarded = array('id');
    public static $rules = array(
      'name' => 'required',
      'description' => 'required',
      'user_id' => 'required'
    );

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function scenario_parameter(){
      return $this->hasMany('App\Models\ScenarioParameter');
    }

    public function make_json(){
      $json_parameters = array();
      foreach($this->scenario_parameter as $scenario_parameter){
        $json_parameters[$scenario_parameter->name] =  $scenario_parameter->value;
      }
      $json_str = [
        'scenarios' => $this->name,
        'params' => $json_parameters
      ];

      return  json_encode($json_str);

    }
}
