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
        'domain' => $this->domain,
        'action' => 'add'
      ]);
    }

    public function create(Request $request, $id = null){
      $items = $this->model();
      $form = $request->all();
      unset($form['_token']);
      $items->fill($form)->save();

      return redirect($this->domain.'/'.$id);
    }

    public function edit(Request $request, $id = null, $parent_id = null, $this_id = null){
      $item = $this->model()->find($this_id);
      return view($this->domain.'/add',[
        'id' => $id,
        'domain' => $this->domain,
        'action' => 'edit',
        'item' => $item,
        'parent_id'=> $parent_id
      ]);
    }

    public function remove(Request $request, $id = null){
      $form = $request->all();
      $this_id = $this->get_id($form);
      $redirect_to = $this->get_redirect_url($form,$id);
      $item = $this->model()->find($this_id)->delete();

      return redirect($redirect_to);

    }

    public function get_id($form) {
      return $form['organisation_id'];
    }

    public function get_redirect_url( $form, $id ){
      return $this->domain.'/'.$id;
    }

}
