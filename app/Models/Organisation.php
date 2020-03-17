<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    //
    protected $guarded = array('id');
    public static $rules = array(
      'name' => 'required',
      'description' => 'required',
    );

    public function project(){
      return $this->hasMany('App\Models\Project');
    }
}
