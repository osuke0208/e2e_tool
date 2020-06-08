<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisation;

class OrganisationController extends Controller
{
    //
    public $domain = 'organisations';
    public $domain_name = '組織';
    public $paginate_line = 20;
    public function query(){
      return Organisation::query();
    }
    public function model(){
      return new Organisation;
    }

    public function index(Request $request, $id = null){
      $items = $this->model()->orderby('created_at','desc')->paginate($this->paginate_line);
      $list_param = $this->get_param($request);
      $list_param['items'] = $items;

      $list_param['item_buttons_param'] = $this->model()->get_item_buttons_param();
      $list_param['card_tool_param'] = $this->model()->get_card_tool_param();
      $list_param['list_buttons_param'] = $this->model()->get_list_buttons_param();
      $param = [
        'list_param' => $list_param,
      ];

      return view('layouts.dashboard')->with($param);
    }

    public function show(Request $request, $id = null){
      $item = $this->model()->find($id);
      $param = $this->get_param($request);

      $param['list_param'] = $list_param;
      return view($this->domain.'.details')->with($param);
    }

    public function get_param(Request $request, $id = null){
      $param = [
        'domain' => $this->domain,
        'domain_name' => $this->domain_name,
        'title' => $this->domain_name,
        '_checkbox' => true,
      ];
      if(!empty($id)){
        $param['item'] = $this->model()->find($id);
      }
      return $param;
    }
    public function create(Request $request, $id = null){
      $param = $this->get_param($request);
      $forms = $this->model()->get_forms();
      $param['forms'] = $forms;
      $param['_edit'] = false;
      $param['_copy'] = false;
      return view('layouts.create')->with($param);
    }



    public function store(Request $request){
      $form = $this->create_form($request);
      $item = $this->model()->create($form);
      return back()->withInput();
    }

    public function create_form(Request $request){
      $form = [
        'name' => $request->get('name'),
        'description' => $request->get('description'),
      ];
      return $form;
    }


    public function edit(Request $request, $id = null){
      $param = $this->get_param($request,$id);
      $forms = $this->model()->get_forms();
      $param['forms'] = $forms;
      $param['_edit'] = true;
      $param['_copy'] = false;
      return view('layouts.create')->with($param);
    }

    public function update(Request $request ,$id = null){
      $form = $this->update_form($request);
      $item = $this->model()->find($id)->update($form);
      return back()->withInput();
    }

    public function update_form(Request $request){
      $form = [
        'name' => $request->get('name'),
        'description' => $request->get('description'),
      ];
      return $form;
    }

    public function copy(Request $request, $id = null){
      $param = $this->get_param($request,$id);
      $forms = $this->model()->get_forms();
      $param['forms'] = $forms;
      $param['_edit'] = false;
      $param['_copy'] = true;
      return view('layouts.create')->with($param);
    }

    public function delete(Request $request,$id = null){
      $param = $this->get_param($request, $id);
      return view('layouts.delete')->with($param);
    }

    public function destroy(Request $request , $id = null){
      $this->model()->find($id)->delete();
      return back()->withInput();
    }

    public function get_id($form) {
      return $form['organisation_id'];
    }

    public function get_redirect_url( $form, $id ){
      return $this->domain.'/'.$id;
    }

}
