<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Scenario;

use Illuminate\Support\Facades\DB;

class ScenarioController extends Controller
{
    //
    public $domain = 'scenario';

    public function model(){
      return new Scenario;
    }

    function index( Request $request, $id = null ){
        $items = $this->model()->orderby('created_at','desc')->get();

        $view_params = [
          'id' => $id,
          'items' => $items
        ];

      return view($this->domain.'.index', $view_params);
    }

    function add($id = null){
      return view($this->domain.'.add',['id'=>$id]);
    }

    function create(Request $request, $id=null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);

      $parameter = $this->make_parameter_data($form);

      $items->fill($form['scenario'])->save();
      $items->scenario_parameter()->createMany($parameter);

      return redirect('/scenario/'.$id);

    }


    function make_parameter_data( $form ){
      $parameter = [];
      foreach($form['parameter']['name'] as $key => $name){
        $parameter[$key] = array(
          'name' => $name,
          'value' =>  $form['parameter']['value'][$key]
        );
      }
      return $parameter;
    }
}
