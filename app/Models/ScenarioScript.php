<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ScenarioScript extends ScenarioParameter
{
    //
    protected $guarded = array('id');
    public static $rules = array(
      'name' => 'required',
      'attribution' =>'required',
      'scenario_id' => 'required',
      'value' => 'required'
    );

    public function scenario_operation()
    {
      return $this->hasMany('App\Models\ScenarioOperation');
    }

    public function make_json(){
      $json_str = [];
      foreach ($this->scenario_operation as $scenario_operation){
        $json_str[] = json_decode($scenario_operation->make_json());
      }
      return json_encode  ($json_str,JSON_PRETTY_PRINT);

    }
}
