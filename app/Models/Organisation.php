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

    public static function get_item_buttons_param(){
      $buttons_param = [
        '_update' => true,
        '_delete' => true,
        '_copy' => true,
      ];
      return $buttons_param;
    }

    public static function get_card_tool_param(){
      $card_tool_param = [
        '_filter' => true,
        '_pager' => true,
      ];
      return $card_tool_param;
    }

    public static function get_list_buttons_param(){
      $list_buttons_param = [
        '_import' => true,
        '_export' => true,
      ];
      return $list_buttons_param;
    }

    public function get_forms(){
      $forms = [
        'name' =>  [
          'required' => true,
          'label' => '名前',
          'type' => 'text',
          'name' => 'name',
        ],
        'description' => [
          'required' => false,
          'label' => '詳細',
          'type' => 'textarea',
          'name' => 'description',
        ],
      ];
      return $forms;
    }

    public function project(){
      return $this->hasMany('App\Models\Project');
    }
}
