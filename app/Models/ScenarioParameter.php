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

    public function scopeNameEqualScenario($query, $name){
      return $query->whereHas('scenario',function($query) use($name){
        $query->where('name', $name);
      });
    }
}
