<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    //
    protected $guarded = array('id');
    public static $rules = array(
      'name' => 'required',
      'description' => 'required',
      'user_id' => 'required'
    );
    
    public function scenario(){
      return $this->hasMany('App\Models\Scenario');
    }

    public function organisation(){
      return $this->belongsTo('App\Models\Organisation');
    }
}
