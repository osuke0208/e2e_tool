@extends('layouts.add')
@php
if($action == 'add'){
  $add_title = 'シナリオ追加';
}elseif($action == 'edit'){
  $add_title = 'シナリオ編集';
}else{
  $add_title = '';
}
@endphp

@section('input_field')
  <input type="hidden" id="project_id" name="project_id" value="{{$parent_id}}">
  <div class="row">
    <div class="col-3">
      <input type="hidden" id="user_id" name="user_id" value="{{$id}}">
      @isset($item)
        <input type="hidden" id="scenario_id" name="scenario_id" value="{{$item->id}}">
      @endisset
      <input  type="text" class="form-control" id="name" placeholder="シナリオ名" name="name" value="@isset($item){{$item->name}}@endisset" >
    </div>
    <div class="col-6">
      <input  type="text" class="form-control" id="description" placeholder="概要" name="description" value="@isset($item){{$item->description}}@endisset">
    </div>
  </div>
@endsection
