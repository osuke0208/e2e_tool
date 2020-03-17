<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisation;

class OrganisationController extends Controller
{
    //
    public $domain = 'organisation';
    public function model(){
      return new Organisation;
    }

    public function index(Request $request, $id = null){
      $items = $this->model()->orderby('created_at','desc')->get();
      return view($this->domain.'.index',[
        'id' => $id,
        'items'  => $items,
        'domain' => $this->domain
      ]);
    }

    public function add(Request $request, $id = null){
      return view($this->domain.'.add',[
        'id' => $id,
        'domain' => $this->domain
      ]);
    }

    public function create(Request $request, $id = null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);
      $items->fill($form)->save();
      return redirect($this->domain.'/'.$id);
    }
}
